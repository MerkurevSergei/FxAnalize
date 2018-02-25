<?php

use FxLib\DataHelper;
use FxLib\Data;

$answers = require 'answers_dataHelper.php';
$data = new Data($pathtestdata, 'r+');
$helper = new DataHelper($data);
$viewdata['dataHelper']['records'] = [];
$viewdata['dataHelper']['peaks'] = [];
$viewdata['dataHelper']['bpeaks'] = [];
$viewdata['dataHelper']['upeaks'] = [];
$viewdata['dataHelper']['seek'] = [];


// Тест №1 получение записей по порядку
$i = 0;
foreach ($helper->records() as $record) {
    if ($record->getDate() == $answers['records'][$i][0]
        && $record->getTime() == $answers['records'][$i][1]
    ) {
        $viewdata['dataHelper']['records'][] = 'Тест получение записи №' . $i . ' пройден';
    } else {
        $viewdata['dataHelper']['records'][] = 'Тест получение записи №' . $i . ' не пройден';
    }

    if ($i++ == 8) {
        break;
    }
}

//
// Тест №2 получение пиков по порядку
$i = 0;
$helper->rewind();
for ($i = 0; $i<8; $i++) {
    $record = $helper->nextPeak();
    if ($record->getDate() == $answers['peaks'][$i][0]
        && $record->getTime() == $answers['peaks'][$i][1]
    ) {
        $viewdata['dataHelper']['peaks'][] = 'Тест порядкового пика №' . $i . ' пройден';
    } else {
        $viewdata['dataHelper']['peaks'][] = 'Тест порядкового пика №' . $i . ' не пройден';
    }
}

// Тест №3 получение только нижних пиков по порядку

$helper->rewind();
for ($i = 0; $i<8; $i++) {
    $record = $helper->nextBPeak();
    if ($record->getDate() == $answers['bpeaks'][$i][0]
        && $record->getTime() == $answers['bpeaks'][$i][1]
    ) {
        $viewdata['dataHelper']['bpeaks'][] = 'Тест нижних пиков №' . $i . ' пройден';
    } else {
        $viewdata['dataHelper']['bpeaks'][] = 'Тест нижних пиков №' . $i . ' не пройден';
    }
}

// Тест №4 получение только верхних пиков по порядку
$i = 0;
$helper->rewind();
for ($i = 0; $i<8; $i++) {
    $record = $helper->nextUPeak();
    if ($record->getDate() == $answers['upeaks'][$i][0]
        && $record->getTime() == $answers['upeaks'][$i][1]
    ) {
        $viewdata['dataHelper']['upeaks'][] = 'Тест верхних пиков №' . $i . ' пройден';
    } else {
        $viewdata['dataHelper']['upeaks'][] = 'Тест верхних пиков №' . $i . ' не пройден';
    }
}

// Тест №5 смещение
$i = 0;
$helper->rewind();
$tmp = [];
foreach ($helper->records() as $record) {
    if ($record->getDate() == $answers['seek'][$i][0]
        && $record->getTime() == $answers['seek'][$i][1]
    ) {
        $viewdata['dataHelper']['seek'][] = 'Тест получение записи при смещении №' . $i
            . ' пройден';
    } else {
        $viewdata['dataHelper']['seek'][] = 'Тест получение записи при смещении №' . $i
            . ' не пройден';
    }
    $tmp[] = $record;
    if ($i++ == 4) {
        break;
    }
}

    $helper->seek($tmp[2]);
foreach ($helper->records() as $record) {
    if ($record->getDate() == $answers['seek'][$i][0]
        && $record->getTime() == $answers['seek'][$i][1]
    ) {
        $viewdata['dataHelper']['seek'][] = 'Тест получение записи при смещении №' . $i
            . ' пройден';
    } else {
        $viewdata['dataHelper']['seek'][] = 'Тест получение записи при смещении №' . $i
            . ' не пройден';
    }
    $tmp[] = $record;
    if ($i++ == 8) {
        break;
    }
}

