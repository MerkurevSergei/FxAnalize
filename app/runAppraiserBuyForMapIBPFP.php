<?php

use FxLib\Data\ArrayData;
use FxLib\Data\BigData;
use FxLib\Appraisers\AppraiserIBPFirstPeak;

$options = require_once(ROOT . '/config/config.php');
$dataBase = new BigData($options['Data']['EURUSD1MRaw'], 'r+', $options['Fxlib']['DataRaw']);
$dataHelp = new ArrayData($options['Data']['EURUSD1MMap'], 'r+', $options['Fxlib']['DataMap']);
$dataOut = new ArrayData($options['Data']['EURUSD1MProfitFirstPeak'], 'w+', $options['Fxlib']['DataProfitFirstPeak']);

$di = new \FxLib\DI();
$di->setOptions($options['Appraisers']['AppraiserIBPFirstPeak']);
$di->setDataBase($dataBase);
$di->setDataHelp($dataHelp);
$di->setDataOut($dataOut);

$sibp = new AppraiserIBPFirstPeak($di);
$sibp->start();