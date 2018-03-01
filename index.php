<?php
ini_set('max_execution_time', 36000);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;
use FxLib\DataHelper;
use FxLib\Strategies\StrategyIBP;
use FxLib\Strategies\StrategyIUP;
use FxLib\RecordWriter;
try {
    $data = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1.csv', 'r+');
    $helper = new DataHelper($data);
    $options = require (__DIR__.'/FxLib/options.php');



    $siup = new StrategyIUP($options['StrategyIUP']);
    $i =0;

    $resetter = null;

    $helper->rewind();

    $sibpOptions = $options['StrategyIBP'];
    $sibpOptions['writer'] = new RecordWriter(__DIR__ .'/data/EURUSD/1M/EURUUSD1PointsBottomGames.csv','w+');
    $sibp = new StrategyIBP($sibpOptions, $helper->current());
    foreach ($helper->records() as $record) {
        $resetter = $sibp->notify($record);
        if (isset($resetter)) {
            $helper->seek($resetter);
            $sibp->clearResetter();
        }
        $i++;
        if ($i>10000) {
            break;
        }
    }
} catch (Error $e) {
    echo $e->getMessage();
}

