<?php

namespace FxLib\Appraisers;

use FxLib\DI;
use FxLib\Record\RecordProfit;
use FxLib\Record\RecordRaw;

class AppraiserIBP
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
        for ($i=0; $i<$count; $i++) {
            if ($this->profits[$i]->isClosed()) {
                $this->dataOut->write($this->profits[$i]);
                continue;
            }
            break;
        }
        $this->profits = array_slice($this->profits, $i);

        // Идем по остальным и играем
        foreach ($this->profits as &$profit) {
            if ($profit->isClosed()) {
                continue;
            }
            $profit->setMax($record->getCost(),$record->getPosition());
            if ($profit->getCost() - $record->getCost() >= 1 + $this->options['spread'] && !$profit->getPos1()) {
                $profit->setPos1($record->getPosition());
            }
            if ($profit->getCost() - $record->getCost() >= 3 + $this->options['spread'] && !$profit->getPos3()) {
                $profit->setPos3($record->getPosition());
            }
            if ($profit->getCost() - $record->getCost() >= 5 + $this->options['spread'] && !$profit->getPos5()) {
                $profit->setPos5($record->getPosition());
            }
            if ($profit->getCost() - $record->getCost() >= 7 + $this->options['spread'] && !$profit->getPos7()) {
                $profit->setPos7($record->getPosition());
            }
            if ($profit->getCost() - $record->getCost() >= 9 + $this->options['spread'] && !$profit->getPos9()) {
                $profit->setPos9($record->getPosition());
                $profit->close();
            }

            if ($record->getPosition() - $profit->getPosition() > $this->options['distAppraised']) {
                $profit->close();
            }
        }
        unset($profit);

        // Если текущая запись в карте, добавляем в работу
        if (($recordMap = $this->dataHelp->exist($record->getPosition())) !== false) {
            $this->profits[] = new RecordProfit($recordMap->toArray());
        }
    }

}