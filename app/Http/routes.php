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

    Route::post('/wallet/login', ['uses'=> 'Api\WalletController@authenticate']);
    Route::post('/wallet/logout', ['uses'=> 'Api\WalletController@logout']);

        // middleware
    Route::group(['middleware' => 'auth.api'], function() {
        Route::post('/wallet/status', ['uses'=> 'Api\WalletController@status']);
        Route::post('/wallet/balance', ['uses'=> 'Api\WalletController@balance']);
        Route::post('/wallet/increaseamount', ['uses'=> 'Api\WalletController@increaseAmount']);
        Route::post('/wallet/decreaseamount', ['uses'=> 'Api\WalletController@decreaseAmount']);
    });
});
