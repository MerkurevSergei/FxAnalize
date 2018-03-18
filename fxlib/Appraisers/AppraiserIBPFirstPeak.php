<?php

namespace FxLib\Appraisers;

use FxLib\DI;
use FxLib\Record\RecordProfit;
use FxLib\Record\RecordProfitFirstPeak;
use FxLib\Record\RecordRaw;

class AppraiserIBPFirstPeak
{

    private $dataBase;
    private $dataHelp;
    private $dataOut;
    private $options;

    private $profits = [];


    public function __construct(DI $di)
    {
        $this->options = $di->getOptions();
        $this->dataBase = $di->getDataBase();
        $this->dataHelp = $di->getDataHelp();
        $this->dataOut = $di->getDataOut();
    }

    public function start()
    {
        foreach ($this->dataBase->records() as $key => $record) {
            $this->work($record);
        }
        foreach ($this->profits as $profit) {
            $this->dataOut->write($profit);
        }
    }

    private function work(RecordRaw $record)
    {
        // Закрываем отыгравшие и идущие вначале
        $count = count($this->profits);
        for ($i = 0; $i < $count; $i++) {
            if ($this->profits[$i]->isClosed()) {
                $this->dataOut->write($this->profits[$i]);
                continue;
            }
            break;
        }
        $this->profits = array_slice($this->profits, $i);

        // Идем по остальным и играем
        foreach ($this->profits as &$profit) {
            // Если строка игры закрыта или необходимое число пунктов не пройдено
            if ($profit->isClosed() ||
                $record->getPosition() - $profit->getPosition() < $this->options['peakFallGapH']) {
                continue;
            }

            // Нужное число пунктов прошли, отбираем максимумы и ставим цену открытия
            if (!$profit->getCostStart()) {
                $profit->setCostStart($record->getCost());
            }
            $profit->setMax($record->getCost(), $record->getPosition());

            // Закрываем игры
            if ($profit->getCostStart() - $record->getCost() >= 10 - $this->options['spread'] && !$profit->getPosClose()) {
                $profit->setPosClose($record->getPosition());
                $profit->close();
            }

            if ($record->getPosition() - $profit->getPosition() > $this->options['distAppraised']) {
                $profit->setPosClose($record->getPosition());
                $profit->close();
            }
        }
        unset($profit);

        // Если текущая запись в карте, добавляем в работу
        if (($recordMap = $this->dataHelp->exist($record->getPosition())) !== false) {
            $this->profits[] = new RecordProfitFirstPeak($recordMap->toArray());
        }
    }

}