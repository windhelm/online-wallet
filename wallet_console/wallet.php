#!/usr/bin/php
<?php

$loader = require( __DIR__ . '/vendor/autoload.php' );

// set algorithm convert
$convert_algorithm = new Windhelm\Algorithmus\AllToRubAlgorithm();

$app = new Windhelm\Application(
    'http://online-wallet.app',
    $argv,
    $argc,
    $convert_algorithm
);

$app->run();