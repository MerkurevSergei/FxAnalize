<?php
ini_set('max_execution_time', 36000);
ini_set('memory_limit', '1024M');
define('ROOT', realpath(__DIR__));
require_once __DIR__ . '/vendor/autoload.php';

//use FxLib\Data;
//use FxLib\Strategies\StrategyIBP;
//use FxLib\RecordWriter;

//  $data = new Data(__DIR__ . '/data/EURUSD/1M/EURUSD1.csv', 'r+');
//$options = require(__DIR__ . '/FxLib/options.php');
//$writer = new RecordWriter(__DIR__ . '/data/EURUSD/1M/EURUUSD1PointsBottomGames.csv', 'w+');

// $di = new \FxLib\DI();
// $di->setData($data);
// $di->setOptions($options);
//  $di->setWriter($writer);

//
//    $sibp = new StrategyIBP($di);
//    $sibp->start();
$options = require_once(ROOT . '/config/options.php');

$handle = fopen($options['Data']['EURUSD1MRaw'], 'r+');
$data = [];
$raw = [];
$i = 0;
while (($raw = fgetcsv($handle,60,',')) !== false) {
    //strtotime(str_replace('.', '-', $raw[0].'T'.$raw[1]))
    //echo date('Y-m-d H:i:s', strtotime($date));
    $data[] = $raw;

    $i++;
    if ($i == 1000000) {
        break;
    }
}
while (($raw = fgetcsv($handle,60,',')) !== false) {
    //strtotime(str_replace('.', '-', $raw[0].'T'.$raw[1]))
    //echo date('Y-m-d H:i:s', strtotime($date));
    $data[] = $raw;

    $i++;
    if ($i == 1000000) {
        break;
    }
}

