<?php

namespace FxLib\Record;


/**
 * Class Record
 *
 * @package FxLib
 */
class RecordRaw
{
    /**
     * @var int
     */
    private $date;
    /**
     * @var
     */
    private $time;
    /**
     * @var
     */
    private $costOpen;
    /**
     * @var
     */
    private $costMax;
    /**
     * @var
     */
    private $costMin;
    /**
     * @var
     */
    private $costClose;

    /**
     * @var
     */
    private $volume;

    /**
     * @var
     */
    private $position;


    /**
     * Peak constructor.
     *
     * @param $record
     */
    public function __construct($record)
    {
        list($this->date, $this->time, $this->costOpen, $this->costMax, $this->costMin, $this->costClose, $this->volume, $this->position)
            = $record;
        $this->costOpen*=10000;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->costOpen;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            $this->date,
            $this->time,
            $this->costOpen,
            $this->costMax,
            $this->costMin,
            $this->costClose,
            $this->volume,
            $this->position
        ];
    }
    public function shrinkArray() {
        return [
            $this->date,
            $this->time,
            $this->volume,
            $this->position,
            $this->costOpen
        ];
    }
}