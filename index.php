<?php
ini_set('max_execution_time', 36000);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;
use FxLib\DataHelper;

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
    while ($helper->valid()) {
        // start point
        $starts['b'] = getStartBRecord($inits['b']);
        $starts['u'] = getStartURecord($inits['u']);

        // peaks
        $helper->seek($starts['b']);
        for($i=0; $i<$options['maxSeqPeaks']; $i++) {
            $peak = $helper->nextSBPeak();
            if ($peak === false) {
                break;
            }
            $peaks['b'][] = $peak;
        }

        $helper->seek($starts['u']);
        for($i=0; $i<$options['maxSeqPeaks']; $i++) {
            $peak = $helper->nextSUPeak();
            if ($peak === false) {
                break;
            }
            $peaks['b'][] = $peak;
        }

        // start game
        // fill starts
        break;
    }
} catch (Error $e) {
    echo $e->getMessage();
}

