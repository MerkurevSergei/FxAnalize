<?php
ini_set('max_execution_time', 36000);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;

try {
    $fxdata = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1Melt.csv', 'r+');

    $fxrecord0 = null;
    $trendLocalTop = 0;
    $trendLocalBottom = 0;
    $peaks = [];
    // TEMP
    $handleUp = new SplFileObject(__DIR__ . '/data/EURUSD/1M/EURUSD1PeakUp.csv',
        'w+');
    $handleBottom = new SplFileObject(__DIR__
        . '/data/EURUSD/1M/EURUSD1PeakBottom.csv',
        'w+');


    foreach ($fxdata->nextPeak() as $key => $record) {
        $peakType = array_pop($record);
        list($data, , , $max0, $min0, ,) = $record;
        if ($peakType > 0) {
            foreach ($fxdata->nextPeak() as $key2 => $record2) {
                $peakType2 = array_pop($record2);

                if ($key2 - $key > 1500) {
                    $handleUp->fputcsv([$data, 1500]);
                    break;
                }
                list(, , , $max2, $min2, ,) = $record2;
                if ($peakType2 > 0 && $max2 > $max0) {
                    $handleUp->fputcsv([$data, $key2 - $key]);
                    break;
                }
            }
        } elseif ($peakType < 0) {
            foreach ($fxdata->nextPeak() as $key2 => $record2) {
                $peakType2 = array_pop($record2);

                if ($key2 - $key > 1500) {
                    $handleBottom->fputcsv([$data, 1500]);
                    break;
                }

                list(, , , $max2, $min2, ,) = $record2;

                if ($peakType2 < 0 && $max2 < $max0) {
                    $handleBottom->fputcsv([$data, $key2 - $key]);
                    break;
                }
            }
        }
        $fxdata->seek($key + 1);

        //
        if ($fxdata->isReadyCut()) {
            $fxdata->cut();
        }
//    echo('<pre>');
//    print_r($peaks);
//    echo('<br>');
//    //print_r($trenddown);
//    echo('</pre>');
    }
    unset($handleBottom);
    unset($handleUp);
} catch (Error $e) {
    echo $e->getMessage();
}

