<?php

namespace Windhelm\Algorithmus\Contract;

interface Convert
{
    public function convert($currency,$capitals);
    public function init();
}