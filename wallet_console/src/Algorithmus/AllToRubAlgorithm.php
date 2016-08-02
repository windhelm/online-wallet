<?php

namespace Windhelm\Algorithmus;

class AllToRubAlgorithm extends DefaultAlgorithm{

    public $avalaible_currency = ['USD','EUR','KGS'];

    public function convert($currency,$capitals)
    {
        $summ_rub = 0;
        $summ = 0;

        // all to RUB and to $currency
        foreach ($capitals as $capital){
            $amount = $capital->amount;
            $_currency = $capital->currency;

            if ($_currency == 'RUB'){
                $summ_rub += $amount;
                continue;
            }

            if ($amount > 0){
                $_curse = $this->getCurseByCurrency($_currency);
                $curse = str_replace(",",".",$_curse["price"]);
                $summ_rub += $amount * $curse;
            }
        }

        $_curse = $this->getCurseByCurrency($currency);
        $curse = str_replace(",",".",$_curse["price"]);

        if ($currency == "RUB")
            $curse = 1;

        $summ = $summ_rub / $curse;
        return $summ;
    }

}