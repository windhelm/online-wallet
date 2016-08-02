<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{

    public function status()
    {
        $wallets = \Auth::user()->getWallets();
        $view = view('api/wallets',['wallets'=>$wallets]);
        return response()->json(["auth" => \Auth::check(),"view" => sprintf('%s',$view)]);
    }
    
    public function balance(Request $request)
    {
        $wallet_id = $request->input('wallet_id');

        $repository = \EntityManager::getRepository('App\Capital');
        $capitals = $repository->findBy(array('wallet_id' => $wallet_id));

        $buf = array();

        foreach ($capitals as $capital){
            array_push($buf, array('amount' => $capital->getAmount(),'currency' => $capital->getCurrency()));
        }

        return response()->json(["auth" => \Auth::check(), "error" => 0, "capitals" => $buf]);
        
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

}
