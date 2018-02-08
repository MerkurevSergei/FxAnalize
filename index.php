<?php
ini_set('max_execution_time', 900);

require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;

//$quene = new \Ds\Queue();
//$quene->push([1,1,2]);
//print_r($quene);
//$row = 1;
try {
    $fxdata = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1.csv',
        __DIR__ . '/data/EURUSD/1M/EURUSD1Re.csv', 'r+');
    $fxdata->addObserver();
//    foreach ($fxdata->next() as $fxrecord) {
//        print_r($fxrecord);
//    }
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