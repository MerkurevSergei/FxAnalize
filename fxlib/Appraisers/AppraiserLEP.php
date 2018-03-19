<?php

namespace FxLib\Appraisers;

use FxLib\DI;
use FxLib\Record\RecordRaw;
use FxLib\Record\RecordMapLEP;
use FxLib\Record\RecordProfitLEP;

class AppraiserLEP
{

    /**
     * @var \FxLib\Data\BigData|mixed
     */
    private $dataBase;
    /**
     * @var \FxLib\Data\ArrayData|mixed
     */
    private $dataHelp;
    /**
     * @var \FxLib\Data\ArrayData|mixed
     */
    private $dataOut;
    /**
     * @var array|mixed
     */
    private $options;

    /**
     * @var array
     */
    private $profits = [];


    /**
     * AppraiserLEP constructor.
     *
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->options = $di->getOptions();
        $this->dataBase = $di->getDataBase();
        $this->dataHelp = $di->getDataHelp();
        $this->dataOut = $di->getDataOut();
    }

    /**
     *
     */
    public function start()
    {
        foreach ($this->dataBase->records() as $key => $record) {
            $this->closeProfitRecords();
            $this->addProfitRecord($record);
            $this->work($record);
        }

        // Вывод остатка в конце файла
        foreach ($this->profits as $profit) {
            $this->dataOut->write($profit);
        }
    }

    /**
     * @param RecordRaw $record
     */
    private function addProfitRecord(RecordRaw $record)
    {
        if (($recordMap = $this->dataHelp->exist($record->getPosition())) !== false
        ) {
            foreach ($this->profits as $profit) {
                if ($profit->getType() === $recordMap->getType()) {
                    return;
                }
            }
            $raw = $recordMap->toArray();
            $raw[] = 0;
            $raw[] = 0;
            $raw[] = 0;
            $this->profits[] = new RecordProfitLEP($raw);
        }
    }

    /**
     *
     */
    private function closeProfitRecords()
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
    }

    /**
     * @param RecordRaw $record
     */
    private function work(RecordRaw $record)
    {
        // Идем по остальным и играем
        foreach ($this->profits as &$profit) {
            // Если строка игры закрыта или необходимое число пунктов не пройдено
            if ($profit->isClosed()) {
                continue;
            }

            // Закрытые записи прошли
            $profit->setMax($record->getCost(), $record->getPosition());

            // Закрываем игры
            if ($profit->getType() * ($record->getCost() - $profit->getCost()) >= 3 - $this->options['spread']) {
                $profit->setDistEnd($record->getPosition() - $profit->getPosition());
                $profit->close();
            }

            if ($record->getPosition() - $profit->getPosition() >= $this->options['distAppraised']) {
                $profit->setDistEnd($this->options['distAppraised']);
                $profit->close();
            }
        }
        unset($profit);
    }

}