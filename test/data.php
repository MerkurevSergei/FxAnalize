<?php

use FxLib\Data;

$answers = require 'answers_data.php';
$data = new Data($pathtestdata, 'r+');


// Тест № 0
$record = $data->next();
if ($record[0] == $answers[1][0] && $record[1] == $answers[1][1]
) {
    $viewdata['data']['next'] = 'Тест получение следующей записи пройден';
} else {
    $viewdata['data']['next'] = 'Тест получение следующей записи не пройден';
}

// Тест № 1
$record = $data->current();
if ($record[0] == $answers[1][0] && $record[1] == $answers[1][1]
) {
    $viewdata['data']['current'] = 'Тест получение текущей записи пройден';
} else {
    $viewdata['data']['current'] = 'Тест получение текущей записи не пройден';
}

// Тест № 2 Сброс и перебор
$data->rewind();
$i = 0;
foreach ($data->records() as $record) {
    if ($record[0] == $answers[$i][0] && $record[1] == $answers[$i][1]
    ) {
        $viewdata['data']['records'][] = 'Тест получение записи №' . $i . ' пройден';
    } else {
        $viewdata['data']['records'][] = 'Тест получение записи №' . $i . ' не пройден';
    }

    if ($i++ == 8) {
        break;
    }
}

// Тест № 3 Сброс, переход и перебор
$data->rewind();
$data->seek(2);
$i = 0;
foreach ($data->records() as $record) {
    if ($record[0] == $answers[$i+2][0] && $record[1] == $answers[$i+2][1]
    ) {
        $viewdata['data']['SeekAndRecords'][] = 'Тест получение записи №' . $i . ' пройден';
    } else {
        $viewdata['data']['SeekAndRecords'][] = 'Тест получение записи №' . $i . ' не пройден';
    }

    if ($i++ == 5) {
        break;
    }
}

unset($answers);
unset($data);
