<?php
ini_set('max_execution_time', 36000);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;
use FxLib\Strategies\StrategyIBP;
use FxLib\RecordWriter;

try {
    $data = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1.csv', 'r+');
    $options = require(__DIR__ . '/FxLib/options.php');
    $writer = new RecordWriter(__DIR__ . '/data/EURUSD/1M/EURUUSD1PointsBottomGames.csv', 'w+');

    $di = new \FxLib\DI();
    $di->setData($data);
    $di->setOptions($options);
    $di->setWriter($writer);


    $sibp = new StrategyIBP($di);
    $sibp->start();

} catch (Error $e) {
    echo $e->getMessage();
}

