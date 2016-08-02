<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use App\Http\Requests;
use Webpatser\Uuid\Uuid;

class WalletController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();

        $user->addWallet(
            new Wallet(Uuid::generate())
        );

        \EntityManager::persist($user);
        \EntityManager::flush();
    }

    public function show()
    {
        $wallets = \Auth::user()->getWallets();

        $view = view('api/wallets',['wallets'=>$wallets]);
        return response()->json(["auth" => \Auth::check(),"view" => sprintf('%s',$view)]);
    }

    public function logout()
    {
        \Auth::logout();
        return response()->json(["auth" => \Auth::check(), "error" => 0]);
    }

    public function increaseAmount(Request $request)
    {
        // validator
        $wallet_id = $request->input('wallet_id');
        $currency = $request->input('currency');
        $amount = $request->input('amount');

        $repository = \EntityManager::getRepository('App\Capital');
        $capital = $repository->findOneBy(array('wallet_id' => $wallet_id,'currency' => $currency));

        $capital->increaseAmount($amount);

        \EntityManager::persist($capital);
        \EntityManager::flush();

        return response()->json(["auth" => \Auth::check(),"error" => 0]);
    }

    public function decreaseAmount(Request $request)
    {
        $wallet_id = $request->input('wallet_id');
        $currency = $request->input('currency');
        $amount = $request->input('amount');

        $repository = \EntityManager::getRepository('App\Capital');
        $capital = $repository->findOneBy(array('wallet_id' => $wallet_id,'currency' => $currency));

        $result = $capital->decreaseAmount($amount);

        \EntityManager::persist($capital);
        \EntityManager::flush();

        if ($result)
            $error = 0;
        else
            $error = "total amount < 0";

        return response()->json(["auth" => \Auth::check(),"result" => $result,"error" => $error]);
    }


    public function authenticate(Request $request)
    {
        $login = $request->input('login');
        $pass = $request->input('password');

        if (\Auth::attempt(['email' => $login, 'password' => $pass])) {
            // Authentication passed...
            return response()->json(["auth" => \Auth::check(), "error" => 0]);
        }
        return response()->json(["auth" => \Auth::check(), "error" => "auth no"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
