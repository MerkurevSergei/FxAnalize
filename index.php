<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__ . '/fxlib/fopen_user.php';

$quene = new \Ds\Queue();
$quene->push([1,1,2]);
print_r($quene);
//$row = 1;
try {
    $handle = fopen_user("C:\\te1mp\\fx\\EURUSD\\EURUSD1.csv", "r+");

    fclose($handle);
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