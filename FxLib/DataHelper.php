<?php

namespace FxLib;

/**
 * Class DataHelper
 *
 * @package FxLib
 */
class DataHelper
{
    /**
     * @var Data
     */
    private $data;
    /**
     * @var array
     */
    private $record_parts = [];

    /**
     * DataHelper constructor.
     *
     * @param Data $data
     */
    public function __construct(Data $data)
    {
        $this->data = $data;
        $this->rewind();
        $this->fillRecordParts();
    }

    /**
     * @return Record
     */
    public function current()
    {
        return new Record($this->record_parts);
    }

    /**
     * @return \Generator
     */
    public function next()
    {
        $this->shiftRecordParts();
        $record = new Record($this->record_parts);
        return $record;

    }

    public function records() {

    }

    /**
     *
     */
    public function rewind()
    {
        $this->data->rewind();
        $this->fillRecordParts();
    }

    /**
     * @param Record $record
     */
    public function seek(Record $record)
    {
        $pos = $record->getPosition();
        $this->data->seek($pos);
        $this->fillRecordParts();
    }


    /**
     * @return \Generator
     */
    public function nextPeak()
    {
        foreach ($this->next() as $record) {
            if ($record->isPeak()) {
                yield $record;
            }
        }
    }

    /**
     *
     */
    public function nextBPeak()
    {
        foreach ($this->nextPeak() as $record) {
            if ($record->isBottomPeak()) {
                yield $record;
            }
        }
    }

    /**
     *
     */
    public function nextUPeak()
    {
        foreach ($this->nextPeak() as $record) {
            if ($record->isUpperPeak()) {
                yield $record;
            }
        }
    }

    /**
     *
     */
    public function nextIBPeak()
    {

    }

    /**
     *
     */
    public function IUPeak()
    {

    }

    /**
     *
     */
    private function fillRecordParts()
    {
        $part0 = $this->data->current();
        $part0['trend'] = 0;
        $this->record_parts[] = $part0;

        $part1 = $this->data->next();
        $part1['trend'] = $this->getTrend($part0, $part1);
        $this->record_parts[] = $part1;
    }

    /**
     *
     */
    private function shiftRecordParts()
    {
        $part1 = $this->data->next();
        $trend = $this->getTrend($this->record_parts[0], $part1);
        $part1['trend'] = $trend;
        array_shift($this->record_parts);
        array_push($this->record_parts, $part1);
    }

    /**
     * @param $part0
     * @param $part1
     *
     * @return int
     */
    private function getTrend($part0, $part1)
    {
        list(, , $cost0) = $part0;
        list(, , $cost1) = $part1;
        if ($cost0 > $cost1) {
            return -1;
        } elseif ($cost0 < $cost1) {
            return 1;
        } else {
            return $part0['trend'];
        }
    }
}