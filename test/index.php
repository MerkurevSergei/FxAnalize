<?php

ini_set("memory_limit", "1024M");
ini_set('max_execution_time', 36000);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';

$viewdata = [];
$viewdata['data'] = [];
$viewdata['dataHelper'] = [];
$pathtestdata = __DIR__ . '/../data/test/EURUSD.csv';

require_once 'data.php';
require_once 'dataHelper.php';
//
require_once 'view.php';

