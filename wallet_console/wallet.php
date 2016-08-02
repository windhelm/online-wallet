#!/usr/bin/php
<?php

$loader = require( __DIR__ . '/vendor/autoload.php' );
$loader->addPsr4( 'Windhelm\\', __DIR__ . '/src/' );

$app = new Windhelm\Application(
    'http://online-wallet.app',
    $argv,
    $argc
);

$app->run();