<?php

namespace FxLib\Record;


/**
 * Class Record
 *
 * @package FxLib
 */
/**
 * Class RecordProfit
 * @package FxLib\Record
 */
/**
 * Class RecordProfit
 * @package FxLib\Record
 */
class RecordProfitFirstPeak
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
    private $costStart;
    /**
     * @var
     */
    private $posClose;

    /**
     * @var
     */
    private $revMax = 0;
    /**
     * @var
     */
    private $posMax;

    /**
     * @var
     */
    private $volume;
    /**
     * @var
     */
    private $position;

    /**
     * @var
     */
    private $peakNum;
    /**
     * @var
     */
    private $closed;

    /**
     * Peak constructor.
     *
     * @param $record
     */
    public function __construct($record)
    {
        list($this->date, $this->time, $this->costOpen, , , , $this->volume, $this->position, $this->peakNum)
            = $record;
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
        return $this->costOpen * 10000;
    }

    /**
     * @param $cost
     * @param $position
     */
    public function setMax($cost, $position)
    {
        if ($this->revMax < round($cost - $this->getCostStart())) {
            $this->revMax = round($cost - $this->getCostStart());
            $this->posMax = round($position - $this->getPosition());
        }
    }


    /**
     * @return mixed
     */
    public function isClosed()
    {
        return $this->closed;
    }

    /**
     * @return mixed
     */
    public function getCostStart()
    {
        return $this->costStart;
    }

    /**
     * @param mixed $costStart
     */
    public function setCostStart($costStart)
    {
        $this->costStart = $costStart;
    }

    /**
     * @return mixed
     */
    public function getPosClose()
    {
        return $this->posClose;
    }

    /**
     * @param mixed $posClose
     */
    public function setPosClose($posClose)
    {
        $this->posClose = $posClose;
    }


    /**
     *
     */
    public function close()
    {
        $this->closed = true;
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
            $this->getCost(),
            $this->costStart,


            $this->posMax,
            $this->revMax,

            $this->volume,
            $this->position,
            $this->posClose,
            $this->peakNum
        ];
    }
}