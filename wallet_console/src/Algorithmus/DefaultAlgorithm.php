<?php

namespace Windhelm\Algorithmus;

class DefaultAlgorithm implements Contract\Convert{

    protected $curses_currency = [];

    protected $avalaible_currency = ['RUB','USD','EUR','KGS'];

    public function init()
    {
        $xml = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp');

        $currencies = new \SimpleXMLElement($xml);
        $buf_currencies = array();

        foreach ($currencies as $currency){

            if (in_array($currency->CharCode, $this->avalaible_currency)){
                array_push($buf_currencies,array('currency' => $currency->CharCode,'price' => $currency->Value));
            }
            $this->setCursesCurrency($buf_currencies);
        }
    }

    private function setCursesCurrency($list)
    {
        $this->curses_currency = $list;
    }

    protected function getCursesCurrency()
    {
        return $this->curses_currency;
    }

    protected function getCurseByCurrency($currency)
    {
        foreach ($this->getCursesCurrency() as $curse){
            if ($curse["currency"] == $currency)
                return $curse;
        }
    }

    public function convert($currency,$capitals)
    {

    }

}