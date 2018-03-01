<?php

namespace FxLib\Strategies;


use FxLib\DI;
use FxLib\Record;

/**
 * Class StrategyIBP
 *
 * @package FxLib\Strategies
 */
class StrategyIBP
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
    private $writer;


    /**
     * @var Record
     */
    private $cursor;
    private $peakNumber;
    /**
     * @var string
     */
    private $stage;


    public function __construct(DI $di)
    {
        $this->options = $di->getOptions()['StrategyIBP'];
        $this->data = $di->getData();
        $this->writer = $di->getWriter();
    }

    public function start()
    {

        $this->data->rewind();
        $rawRecord = $this->data->current();
        $rawRecord[] = 0;
        $record = new Record($rawRecord);

        $this->cursor = $record;
        $this->peakNumber = 0;
        $this->stage = self::STAGE_INIT;

        $i = 0;
        foreach ($this->data->records() as $key => $rawRecord) {
            if ($key > $this->options['cutline']) {
                $this->data->cut();
                continue;
            }
            $rawRecord[] = $i;
            $record = new Record($rawRecord);
            $this->notify($record);
            $i++;
        }


    }

    /**
     * @param Record $record
     *
     */
    public function notify(Record $record)
    {
        $record->setCost($record->getCost() * $this->options['factor']);
        call_user_func([$this, $this->stage], $record);
    }

    /**
     * @param Record $record
     */
    private function init(Record $record)
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
     * @param Record $record
     */
    private function find(Record $record)
    {
        // СБРОС: Период поиска пика длиннее заданного
        if ($record->getPosition() - $this->cursor->getPosition()
            > $this->options[$this->peakNumber]['distH']
        ) {
            $this->peakNumber = 0;
            $this->stage = self::STAGE_INIT;
            $this->data->seek($this->cursor->getPosition());
            return;
        }

        // СБРОС: Количество пиков подряд более заданного
        if ($this->peakNumber >= $this->options['maxSeqPeaks']) {
            $this->peakNumber = 0;
            $this->stage = self::STAGE_INIT;
            $this->data->seek($this->cursor->getPosition());
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
     * @param Record $record
     */
    private function fix(Record $record)
    {
        $fixGapH = $this->options[$this->peakNumber]['peakFallGapH'];


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
                $this->writer->write($rawRecord);
            }

            $this->stage = self::STAGE_FIND;
            $this->find($record);
        }
    }


}