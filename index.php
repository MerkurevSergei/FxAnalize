<?php
ini_set('max_execution_time', 900);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;
use FxLib\Peak;

try {
    $fxdata = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1.csv',
        __DIR__ . '/data/EURUSD/1M/EURUSD1Re.csv', 'r+');



    $prev = NULL;
    $direction = NULL;
    $row = 0;
    $peaks = [];
    foreach ($fxdata->next() as $fxrecord) {
        $row++;
        if ($row>10000) {
            break;
        }

        // INIT
        if ($prev == NULL) {
            $prev = $fxrecord[2];
            continue;
        }
        if ($direction == NULL) {
            $direction = ($fxrecord[2] > $prev) ? 1 : -1;
            continue;
        }

        // BODY
        if ($fxrecord[2] > $prev && $direction == -1) {
            $peaks[] = new Peak($fxrecord[2],'down', 100, -10);
        }
        if ($fxrecord[2] < $prev && $direction == 1) {
            $peaks[] = new Peak($fxrecord[2],'up', 100, -10);
        }
        for ($i=0; $i<count($peaks); ++$i) {
            //if $peaks[$i]->closed($fxrecord[2])
        }
        // FOR NEXT STEP
        $direction = ($fxrecord[2] > $prev) ? 1 : -1;
        $prev = $fxrecord[2];
    }

    echo('<pre>');
   // print_r($trendup);
    echo('<br>');
   //print_r($trenddown);
    echo('</pre>');

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