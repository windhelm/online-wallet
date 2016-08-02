<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::resource('wallet', 'WalletController');

Route::group(['prefix' => 'api/v1'], function() {

    Route::post('/wallet/login', ['uses'=> 'WalletController@authenticate']);
    Route::post('/wallet/logout', ['uses'=> 'WalletController@logout']);

        // middleware
    Route::group(['middleware' => 'auth.api'], function() {
        Route::post('/wallet/get', ['uses'=> 'WalletController@show']);
        Route::post('/wallet/increaseamount', ['uses'=> 'WalletController@increaseAmount']);
        Route::post('/wallet/decreaseamount', ['uses'=> 'WalletController@decreaseAmount']);
    });
});
