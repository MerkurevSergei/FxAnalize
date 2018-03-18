<?php

use FxLib\DI;
use FxLib\Data\BigData;
use FxLib\Appraisers\AppraiserLEP;
use FxLib\Data\ArrayData;

$configApp = require_once(ROOT . '/config/config.php');
$configRecord = require_once(ROOT . '/config/records.php');
$configDataPath = require_once(ROOT . '/config/datapath.php');
$dataBase = new BigData($configDataPath['EURUSD1MRaw'], 'r+', $configRecord['Raw']);
$dataHelp = new ArrayData($configDataPath['EURUSD1MMapLEP'], 'r+', $configRecord['MapLEP']);
$dataOut = new ArrayData($configDataPath['EURUSD1MProfitLEP'], 'w+', $configRecord['ProfitLEP']);

$di = new DI();
$di->setOptions($configApp['Appraisers']['AppraiserLEP']);
$di->setDataBase($dataBase);
$di->setDataHelp($dataHelp);
$di->setDataOut($dataOut);

$alep = new AppraiserLEP($di);
$alep->start();

echo '<h1>Работа AppraiserLEP (Log extremums before peak) выполнена</h1>';