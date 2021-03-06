<?php

namespace FxLib;

/**
 * Class DataHelper
 *
 * @package FxLib
 */
/**
 * Class DataHelper
 * @package FxLib
 */
class DataHelper
{
    /**
     * @var BigData
     */
    private $data;
    /**
     * @var array
     */
    private $record_parts = [];

    /**
     * DataHelper constructor.
     *
     * @param BigData $data
     */
    public function __construct(BigData $data)
    {
        $this->data = $data;
        $this->rewind();
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->data->valid();
    }

    /**
     * @return bool
     */
    public function eof()
    {
        return $this->data->eof();
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
     * @param RecordRaw $record
     */
    public function seek(RecordRaw $record)
    {
        $pos = $record->getPosition();
        $this->data->seek($pos);
        $this->fillRecordParts();
    }


    /**
     * @return bool|RecordRaw
     */
    public function current()
    {
        if (count($this->record_parts) < 2) {
            return false;
        }
        return new RecordRaw($this->record_parts);
    }

    /**
     * @return bool|RecordRaw
     */
    public function next()
    {
        if ($this->eof()) {
            return false;
        }
        $this->slipRecordParts($this->data->next());
        $record = new RecordRaw($this->record_parts);
        return $record;

    }

    /**
     * @return \Generator
     */
    public function records()
    {
        if (count($this->record_parts) < 2) {
            return false;
        }
        $this->data->next();
        foreach ($this->data->records() as $key => $record) {
            if (!isset($record[0])) {
                continue;
            }
            $REC = new RecordRaw($this->record_parts);
            $this->slipRecordParts($record);
            yield  $REC;
        }
    }

    /**
     *
     */
    private function fillRecordParts()
    {
        $this->record_parts = [];
        if ($this->eof()) {
            return false;
        }
        $part0 = $this->data->current();
        $part0['trend'] = 0;
        $this->record_parts[] = $part0;

        $part1 = $this->data->next();
        $part1['trend'] = $this->getTrend($part0, $part1);
        $this->record_parts[] = $part1;

    }


    private function slipRecordParts($record)
    {
        if (count($this->record_parts) < 2) {
            return false;
        }
        $trend = $this->getTrend($this->record_parts[1], $record);
        $record['trend'] = $trend;
        array_shift($this->record_parts);
        array_push($this->record_parts, $record);
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