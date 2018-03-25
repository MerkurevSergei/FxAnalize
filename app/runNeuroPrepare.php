<?php

use FxLib\Data\BigData;
use FxLib\Data\ArrayData;
use FxLib\Neuro\Converter;

$configApp = require_once(ROOT . '/config/config.php');
$configRecord = require_once(ROOT . '/config/records.php');
$configDataPath = require_once(ROOT . '/config/datapath.php');
$dataBase = new BigData($configDataPath['EURUSD1MRaw'], 'r+', $configRecord['Raw']);
$dataOut = new ArrayData($configDataPath['EURUSD1MNeuroData'], 'w+', $configRecord['NeuroData']);

$di = new \FxLib\DI();
$di->setOptions($configApp['Neuro']['NeuroSimple']);
$di->setDataBase($dataBase);
$di->setDataOut($dataOut);

$lep = new Converter($di);
$lep->start();

echo '<h1>Работа Neuro Converter выполнена</h1>';