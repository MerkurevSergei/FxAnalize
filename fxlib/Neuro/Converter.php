<?php


namespace FxLib\Neuro;

use FxLib\DI;
use FxLib\Record\RecordMapLEP;
use FxLib\Record\RecordRaw;

class Converter
{
    /**
     * @var \FxLib\Data\BigData|mixed
     */
    private $data;
    private $dataOut;
    private $options;

    private $logPast = [];
    private $logFuture = [];
    private $flagLogP = 0;
    private $flagLogF = 0;

    public function __construct(DI $di)
    {
        $this->options = $di->getOptions();
        $this->data = $di->getDataBase();
        $this->dataOut = $di->getDataOut();
    }

    public function start()
    {
        foreach ($this->data->records() as $key => $record) {
            if (!$this->flagLogF) {
                $this->logFuture[] = $record;
                $this->flagLogF = count($this->logFuture) >= $this->options['logFSize'];
                continue;
            }
            if (!$this->flagLogP) {
                $this->logPast[] = array_shift($this->logFuture);
                $this->logFuture[] = $record;
                $this->flagLogP = count($this->logPast) >= $this->options['logPSize'];
                continue;
            }
            array_shift($this->logPast);
            $this->logPast[] = array_shift($this->logFuture);
            $this->logFuture[] = $record;

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
}