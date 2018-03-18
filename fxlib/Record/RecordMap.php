<?php

namespace FxLib\Record;


/**
 * Class Record
 *
 * @package FxLib
 */
class RecordMap extends RecordRaw
{
    private $peakNum;
    /**
     * Peak constructor.
     *
     * @param $record
     */
    public function __construct($record)
    {
        parent::__construct($record);
        $this->peakNum = array_pop($record);
    }

    /**
     * @return mixed
     */
    public function getPeakNum()
    {
        return $this->peakNum;
    }

    /**
     * @param mixed $peakNum
     */
    public function setPeakNum($peakNum)
    {
        $this->peakNum = $peakNum;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $row = parent::toArray();
        $row[] = $this->peakNum;
        return $row;
    }
}