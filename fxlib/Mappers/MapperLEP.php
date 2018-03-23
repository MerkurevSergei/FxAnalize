<?php


namespace FxLib\Mappers;

use FxLib\DI;
use FxLib\Record\RecordMapLEP;
use FxLib\Record\RecordRaw;

class MapperLEP
{
    /**
     *
     */
    const STAGE_INIT = 'init';
    /**
     *
     */
    const STAGE_FINDB = 'findB';
    /**
     *
     */
    const STAGE_FINDU = 'findU';


    /**
     * @var RecordRaw
     */
    private $cursor;
    /**
     * @var \FxLib\Data\BigData|mixed
     */
    private $data;
    private $dataOut;
    private $options;
    private $stage;
    private $log = [];

    public function __construct(DI $di)
    {
        $this->options = $di->getOptions();
        $this->data = $di->getDataBase();
        $this->dataOut = $di->getDataOut();
    }

    public function start()
    {
        foreach ($this->data->records() as $key => $record) {
            if (!$this->cursor) {
                $this->cursor = $record;
                $this->stage = self::STAGE_INIT;
            }
            $this->addToLog($record);
            call_user_func([$this, $this->stage], $record);
        }
    }

    /**
     * @param RecordRaw $record
     */
    private function init(RecordRaw $record)
    {
        $gapV = $this->options['initGapV'];
        if ($this->cursor->getCost() - $record->getCost() >= $gapV) {
            $this->cursor = $record;
            $this->stage = self::STAGE_FINDB;
            $this->findB($record);
        } elseif ($record->getCost() - $this->cursor->getCost() >= $gapV) {
            $this->cursor = $record;
            $this->stage = self::STAGE_FINDU;
            $this->findU($record);
        }
    }

    /**
     * @param RecordRaw $record
     */
    private function findB(RecordRaw $record)
    {
        // Ищем пик
        if ($this->cursor->getCost() >= $record->getCost()
        ) {
            $this->cursor = $record;
        } else {
            if ($record->getCost() - $this->cursor->getCost() >= $this->options['fixGapV']) {
                $rawArray = array_merge($record->shrinkArray(), $this->getAddition(-1));
                $this->dataOut->write(new RecordMapLEP($rawArray));
                $this->stage = self::STAGE_INIT;
                $this->data->seek($this->cursor);
                $this->init($this->cursor);
            }
        }
    }

    /**
     * @param RecordRaw $record
     */
    private function findU(RecordRaw $record)
    {
        // Ищем пик
        if ($this->cursor->getCost() <= $record->getCost()
        ) {
            $this->cursor = $record;
        } else {
            if ($this->cursor->getCost() - $record->getCost() >= $this->options['fixGapV']) {
                $rawArray = array_merge($record->shrinkArray(), $this->getAddition(1));
                $this->dataOut->write(new RecordMapLEP($rawArray));
                $this->stage = self::STAGE_INIT;
                $this->data->seek($this->cursor);
                $this->init($this->cursor);
            }
        }
    }

    /**
     * @param RecordRaw $record
     */
    private function addToLog(RecordRaw $record)
    {
        if (count($this->log) >= $this->options['logPeriod']) {
            array_shift($this->log);
        }
        $this->log[] = $record;
    }

    /**
     * @return RecordRaw
     */
    private function maxLogRecord()
    {
        $maxRec = null;
        foreach ($this->log as $rec) {
            if ($maxRec === null) {
                $maxRec = $rec;
            }
            if ($maxRec->getCost() <= $rec->getCost()) {
                $maxRec = $rec;
            }
        }
        return $maxRec;
    }

    /**
     * @return mixed
     */
    private function minLogRecord()
    {
        $minRec = null;
        foreach ($this->log as $rec) {
            if ($minRec === null) {
                $minRec = $rec;
            }
            if ($minRec->getCost() >= $rec->getCost()) {
                $minRec = $rec;
            }
        }
        return $minRec;
    }


    /**
     * @param $type
     * @return array
     */
    private function getAddition($type)
    {
        $addition = [];
        $addition[] = $type;

        $maxRec = $this->maxLogRecord();
        if ($this->cursor->getPosition() < $maxRec->getPosition()) {
            $addition[] = $this->cursor->getPosition();
            $addition[] = $this->cursor->getCost();
        } else {
            $addition[] = $maxRec->getPosition();
            $addition[] = $maxRec->getCost();
        }

        $minRec = $this->minLogRecord();
        if ($this->cursor->getPosition() < $minRec->getPosition()) {
            $addition[] = $this->cursor->getPosition();
            $addition[] = $this->cursor->getCost();
        } else {
            $addition[] = $minRec->getPosition();
            $addition[] = $minRec->getCost();
        }
        return $addition;
    }

}