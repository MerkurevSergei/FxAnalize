<?php
ini_set('max_execution_time', 900);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;
use FxLib\Peak;

try {
    $fxdata = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1.csv',
        __DIR__ . '/data/EURUSD/1M/EURUSD1Re.csv', 'r+');

    // new Analizer();
    // Analizer->getPeak($fxdata, __DIR__ . '/data/EURUSD/1M/EURUSD1Peak.csv');

    $fxrecord0 = null;
    $trendLocalTop = 0;
    $trendLocalBottom = 0;
    $peaks = [];
    // TEMP
    $handleUp = fopen(__DIR__ . '/data/EURUSD/1M/EURUSD1PeakUp.csv', 'w+');
    $handleBottom = fopen(__DIR__ . '/data/EURUSD/1M/EURUSD1PeakBottom.csv',
        'w+');

    $countUp = 0;
    $countBottom = 0;
    $peakUpPre = 0;
    $peakBottomPre = 0;

    foreach ($fxdata->next() as $key => $fxrecord1) {
//        if ($key > 10000) {
//            break;
//        }
        if (!$fxrecord0) {
            $fxrecord0 = $fxrecord1;
            $peakUpPre = $fxrecord1[2];
            $peakBottomPre = $fxrecord1[3];
            continue;
        }

        // BODY
        list($point0, $open0, $max0, $min0, $close0, $vol0) = $fxrecord0;
        list($point1, $open1, $max1, $min1, $close1, $vol1) = $fxrecord1;
        if ($min1 > $min0 && $trendLocalBottom < 0) {

            fputcsv($handleBottom, [$countBottom]);
            $countBottom = 0;
        }
        if ($max1 < $max0 && $trendLocalTop > 0) {
            fputcsv($handleUp, [$countUp]);
            $countUp = 0;
        }

        $countUp++;
        $countBottom++;

        // FOR NEXT STEP
        $trendLocalTop = $max1 - $max0;
        $trendLocalBottom = $min1 - $min0;
        $fxrecord0 = $fxrecord1;
    }
    fclose($handleUp);
    fclose($handleBottom);
//    echo('<pre>');
//    print_r($peaks);
//    echo('<br>');
//    //print_r($trenddown);
//    echo('</pre>');

} catch (Error $e) {
    echo $e->getMessage();
}


//reformat();

//if (($handle = fopen("C:\\temp\\fx\\EURUSD\\EURUSD1.csv", "r+")) !== false) {
//    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
//        $num = count($data);
//        echo "<p> $num полей в строке $row: <br /></p>\n";
//        $row++;
//        for ($c = 0; $c < $num; $c++) {
//            echo $data[$c] . "<br />\n";
//        }
//        if ($row>5000) {
//            break;
//        }
//    }
//
//}
