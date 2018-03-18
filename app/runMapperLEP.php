<?php

use FxLib\Data\BigData;
use FxLib\Mappers\MapperLEP;
use FxLib\Data\ArrayData;

$configApp = require_once(ROOT . '/config/config.php');
$configRecord = require_once(ROOT . '/config/records.php');
$configDataPath = require_once(ROOT . '/config/datapath.php');
$dataBase = new BigData($configDataPath['EURUSD1MRaw'], 'r+', $configRecord['Raw']);
$dataOut = new ArrayData($configDataPath['EURUSD1MMapLEP'], 'w+', $configRecord['MapLEP']);

$di = new \FxLib\DI();
$di->setOptions($configApp['Mappers']['MapperLEP']);
$di->setDataBase($dataBase);
$di->setDataOut($dataOut);

$lep = new MapperLEP($di);
$lep->start();

echo '<h1>Работа MapperLEP (Log extremums before peak) выполнена</h1>';