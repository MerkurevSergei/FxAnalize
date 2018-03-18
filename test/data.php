<?php

use FxLib\Data\BigData;

$answers = require 'answers_data.php';
$options = require_once(ROOT . '/config/config.php');
$data = new BigData($pathtestdata, 'r+', [
    'sizePart' => 4,
    'sizeCache' => 2,
    'maxRowLength' => 60,
    'delimeter' => ','
]);


// Тест № 0 Сброс и перебор
$i = 0;
foreach ($data->records() as $record) {
    if ($record->getDate() == $answers[$i][0] && $record->getTime() == $answers[$i][1]
    ) {
        $viewdata['data']['records'][] = 'Тест получение записи №' . $i . ' пройден';
    } else {
        $viewdata['data']['records'][] = 'Тест получение записи №' . $i . ' не пройден';
    }

    if ($i++ == 8) {
        break;
    }
}

// Тест № 1 Сброс, переход и перебор
$i = 0;
$flag = 0;
$offset = null;
foreach ($data->records() as $record) {
    if ($record->getDate() == $answers[$i][0] && $record->getTime() == $answers[$i][1]
    ) {
        $viewdata['data']['SeekAndRecords'][] = 'Тест получение записи №' . $i . ' пройден';
    } else {
        $viewdata['data']['SeekAndRecords'][] = 'Тест получение записи №' . $i . ' не пройден';
    }

    if ($i == 3) {
        $offset = $record;
    }
    if ($i == 5 && $flag == 0) {
        $data->seek($offset);
        $i = $i-2;
        $flag = 1;
    }
    if ($i == 8) {
        break;
    }
    $i++;

}

unset($answers);
unset($data);
