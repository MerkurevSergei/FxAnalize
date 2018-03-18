<?php

use FxLib\Data\BigData;
use FxLib\Mappers\MapperIBP;
use FxLib\Data\ArrayData;

$options = require_once(ROOT . '/config/config.php');
$dataBase = new BigData($options['Data']['EURUSD1MRaw'], 'r+', $options['Fxlib']['DataRaw']);
$dataOut = new ArrayData($options['Data']['EURUSD1MMap'], 'w+', $options['Fxlib']['DataMap']);

$di = new \FxLib\DI();
$di->setOptions($options['Mappers']['MapperIBP']);
$di->setDataBase($dataBase);
$di->setDataOut($dataOut);

$sibp = new MapperIBP($di);
$sibp->start();

echo '<h1>Работа MapperIBP выполнена</h1>';