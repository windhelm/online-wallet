<?php

namespace Windhelm;

class Application{

    protected $basePath;

    protected $argv;

    protected $argc;

    public $prefixApi = "/api/v1/";

    protected $routes = [
        "logout" => "wallet/logout",
        "login" => "wallet/login",
        "status" => "wallet/status",
        "increaseAmount" => "wallet/increaseamount",
        "decreaseAmount" => "wallet/decreaseamount"
    ];

    public function __construct($basePath = null,$argv,$argc)
    {
        $this->basePath = $basePath;
        $this->argv = $argv;
        $this->argc = $argc;
    }

    public function getRoute($command)
    {
        return $this->routes[$command];
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function getArgv()
    {
        return $this->argv;
    }

    public function getArgc()
    {
        return $this->argc;
    }

    public function validateInput($argv,$argc)
    {
        // if argument count > 1
        if ($argc > 0) {
            if (in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
                echo "help\n he";
                return true;
            }

            $command = $argv[1];

            switch ($command){
                case "login":

                    if (!isset($argv[2])){
                        echo "no specify the login";
                        return false;
                    }

                    if (!isset($argv[3])){
                        echo "no specify the amount";
                        return false;
                    }

                    break;
                case "decreaseAmount":
                case "increaseAmount":

                    if (!isset($argv[2])){
                        echo "no specify the wallet";
                        return false;
                    }

                    if (!isset($argv[3])){
                        echo "no specify the currency";
                        return false;
                    }

                    if (isset($argv[4])){
                        $amount = $argv[4];

                        if ($amount == 0){
                            echo "zero amount";
                            return false;
                        }

                        if ($amount < 0){
                            echo "only > 0";
                            return false;
                        }

                    }else{
                        echo "no specify the amount";
                        return false;
                    }

                    break;
            }

            return true;

        }else{
            return false;
        }

    }

    public function executeCommand($argv,$argc)
    {
        $command = $argv[1];

        switch($command){
            case "login":
                $data = array(
                    'login'=> $argv[2],
                    'password'=> $argv[3],
                );

                $result = $this->sendRequest($this->getRoute($command),$data);

                if ($result->auth){
                    echo "login succes";
                }else{
                    echo "error: "."login error";
                }

                break;
            case "logout":
                $result = $this->sendRequest($this->getRoute($command));

                if (!$result->auth){
                    echo "logout succes";
                }else{
                    echo "error: "."logout error";
                }

                break;

            case "status":
                // if login show info wallet else show please login
                $result = $this->sendRequest($this->getRoute($command));

                if ($result->auth){
                    $view = $result->view;
                    echo $view;
                }else{
                    echo "error: "."no login, please login";
                }

                break;
            case "decreaseAmount":
            case "increaseAmount":

                $data = array(
                    'wallet_id'=> $argv[2],
                    'currency'=> $argv[3],
                    'amount' => $argv[4]
                );

                $result = $this->sendRequest($this->getRoute($command),$data);

                if ($result->auth){
                    if ($result->error === 0)
                        echo "succes";
                    else
                        echo "error: ".$result->error;
                }else{
                    echo "error: ". "please login";
                }

                break;
            default:
                echo "unknown command";
        }


    }


    public function run()
    {
        $argv = $this->getArgv();
        $argc = $this->getArgc();
        $result = $this->validateInput($argv,$argc);

        if ($result)
            $this->executeCommand($argv,$argc);
    }

    public function sendRequest($url,$data = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->basePath . $this->prefixApi . $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result);

        return $json;
    }


}