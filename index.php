<?php
ini_set('max_execution_time', 36000);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;
use FxLib\DataHelper;
use FxLib\Strategies\StrategyIBP;
use FxLib\Strategies\StrategyIUP;
try {
    $data = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1.csv', 'r+');
    $helper = new DataHelper($data);
    $options = require (__DIR__.'/FxLib/options.php');

    $inits = [
        'b' => $helper->current(),
        'u' => $helper->current()
    ];
    $starts = [
        'b' => $helper->current(),
        'u' => $helper->current()
    ];
    $peaks = [
        'b' => [],
        'u' => []
    ];

    $sibp = new StrategyIBP($options['StrategyIBP']);
    $siup = new StrategyIUP($options['StrategyIUP']);
    $i =0;
    $helper->rewind();
    foreach ($helper->records() as $record) {
        $sibp->notify($record);
        //$siup->notify($record);
        $i++;
        if ($i>50) {
            break;
        }
    }
} catch (Error $e) {
    echo $e->getMessage();
}

