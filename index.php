<?php
ini_set('max_execution_time', 36000);
ini_set('memory_limit', '1024M');
define('ROOT', realpath(__DIR__));
require_once __DIR__ . '/vendor/autoload.php';

use FxLib\Data;
use FxLib\Strategies\StrategyIBP;
use FxLib\RecordWriter;

$options = require_once(ROOT . '/config/config.php');
$data = new Data($options['Data']['EURUSD1MRaw'], 'r+', $options['Fxlib']['Data']);
$writer = new RecordWriter(__DIR__ . '/data/EURUSD/EURUUSD1PointsBottomGames.csv', 'w+');

$di = new \FxLib\DI();
$di->setOptions($options);
$di->setData($data);
$di->setWriter($writer);

$sibp = new StrategyIBP($di);
$sibp->start();