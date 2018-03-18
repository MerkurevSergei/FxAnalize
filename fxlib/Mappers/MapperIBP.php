<?php

namespace FxLib\Mappers;


use FxLib\DI;
use FxLib\Record\RecordMap;
use FxLib\Record\RecordRaw;

/**
 * Class StrategyIBP
 *
 * @package FxLib\Strategies
 */
class MapperIBP
{
    /**
     *
     */
    const STAGE_INIT = 'init';
    /**
     *
     */
    const STAGE_FIND = 'find';
    /**
     *
     */
    const STAGE_FIX = 'fix';

    /**
     * @var array
     * KEY DESCRIPTION:
     * factor - multiplier for rate
     * initGapV - NOT ZERO!!!
     * peakFallH - init stage horizontal gap,
     */
    private $options;
    private $data;
    private $dataOut;


    /**
     * @var RecordRaw
     */
    private $cursor;
    private $peakNumber;
    /**
     * @var string
     */
    private $stage;


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
                $this->cursor = $this->data->getRecord(0);
                $this->peakNumber = 0;
                $this->stage = self::STAGE_INIT;
            }
            $this->notify($record);
        }
    }

    private function reset()
    {
        $this->peakNumber = 0;
        $this->stage = self::STAGE_INIT;
        $this->data->seek($this->cursor);
    }

    /**
     * @param RecordRaw $record
     *
     */
    private function notify(RecordRaw $record)
    {
        call_user_func([$this, $this->stage], $record);
    }

    /**
     * @param RecordRaw $record
     */
    private function init(RecordRaw $record)
    {
        $gapV = $this->options['initGapV'];
        if ($this->cursor->getCost() < $record->getCost()) {
            $this->cursor = $record;
        } elseif ($this->cursor->getCost() - $record->getCost() >= $gapV) {
            $this->cursor = $record;
            $this->stage = self::STAGE_FIND;
            $this->find($record);
        }
    }

    /**
     * @param RecordRaw $record
     */
    private function find(RecordRaw $record)
    {
        // СБРОС: Период поиска пика длиннее заданного
        if ($record->getPosition() - $this->cursor->getPosition()
            > $this->options['peakBtDistH']
        ) {
            $this->reset();
            return;
        }

        // СБРОС: Количество пиков подряд более заданного
        if ($this->peakNumber >= $this->options['maxSeqPeaks']) {
            $this->reset();
            return;
        }

        // ФИКСАЦИЯ: Пик текущий, либо ниже
        // $record->isBottomPeak() && вероятно не нужно
        if ($this->cursor->getCost() >= $record->getCost()
        ) {
            $this->cursor = $record;
            $this->stage = self::STAGE_FIX;
            $this->fix($record);
        }
    }


    /**
     * @param RecordRaw $record
     */
    private function fix(RecordRaw $record)
    {
        $fixGapH = $this->options['peakFallGapH'];


        // ПИК ОПРОВЕРГНУТ, ЕСТЬ ЛУЧШИЙ ПИК: меняем пик
        if ($this->cursor->getCost() - $record->getCost() >= 0) {
            $this->cursor = $record;
        }

        // ПОИСК: пик подтвержден, ищем следующий
        if ($record->getPosition() - $this->cursor->getPosition() >= $fixGapH) {
            $this->peakNumber++;
            if ($this->peakNumber >= $this->options['startNumberPeak']) {
                $rawRecord = $this->cursor->toArray();
                $rawRecord[] = $this->peakNumber;
                $this->dataOut->write(new RecordMap($rawRecord));
            }

            $this->stage = self::STAGE_FIND;
            $this->find($record);
        }
    }


}