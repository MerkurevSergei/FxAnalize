<?php

ini_set('max_execution_time', 36000);

require_once __DIR__ . '/../vendor/autoload.php';

$viewdata = [];
$viewdata['data'] = [];
$viewdata['dataHelper'] = [];
$pathtestdata = __DIR__ . '/../data/test/EURUSD.csv';
require_once 'data.php';
require_once 'dataHelper.php';

require_once 'view.php';

