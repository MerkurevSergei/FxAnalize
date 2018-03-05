<?php
ini_set('max_execution_time', 36000);
ini_set('memory_limit', '1024M');
define('ROOT', realpath(__DIR__));
require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;

//use FxLib\Strategies\StrategyIBP;
//use FxLib\RecordWriter;


//$options = require(__DIR__ . '/FxLib/options.php');
//$writer = new RecordWriter(__DIR__ . '/data/EURUSD/1M/EURUUSD1PointsBottomGames.csv', 'w+');

//  $di->setWriter($writer);

//
//    $sibp = new StrategyIBP($di);
//    $sibp->start();
$options = require_once(ROOT . '/config/config.php');
$data = new Data($options['Data']['EURUSD1MRaw'], 'r+', $options['Fxlib']['Data']);
$data->records();
$di = new \FxLib\DI();
$di->setOptions($options);
$di->setData($data);

//$handle = fopen($options['Data']['EURUSD1MRaw'], 'r+');
//$data = [];
//$raw = [];
//$i = 0;
//while (($raw = fgetcsv($handle,60,',')) !== false) {
//    //strtotime(str_replace('.', '-', $raw[0].'T'.$raw[1]))
//    //echo date('Y-m-d H:i:s', strtotime($date));
//    $data[] = $raw;
//
//    $i++;
//    if ($i == 1000000) {
//        break;
//    }
//}
