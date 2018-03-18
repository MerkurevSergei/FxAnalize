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
class RecordProfit
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
    private $rev1max;
    /**
     * @var
     */
    private $pos1max;
    /**
     * @var
     */
    private $pos1;
    /**
     * @var
     */
    private $rev3max;
    /**
     * @var
     */
    private $pos3max;
    /**
     * @var
     */
    private $pos3;
    /**
     * @var
     */
    private $rev5max;
    /**
     * @var
     */
    private $pos5max;
    /**
     * @var
     */
    private $pos5;
    /**
     * @var
     */
    private $rev7max;
    /**
     * @var
     */
    private $pos7max;
    /**
     * @var
     */
    private $pos7;
    /**
     * @var
     */
    private $rev9max;
    /**
     * @var
     */
    private $pos9max;
    /**
     * @var
     */
    private $pos9;
    /**
     * @var
     */
    private $revMax;
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
     * @param mixed $pos1
     */
    public function setPos1($pos1)
    {
        $this->pos1max = $this->posMax;
        $this->rev1max = $this->revMax;
        $this->pos1 = $pos1;
    }


    /**
     * @param mixed $pos3
     */
    public function setPos3($pos3)
    {
        $this->pos3max = $this->posMax;
        $this->rev3max = $this->revMax;
        $this->pos3 = $pos3;
    }

    /**
     * @param mixed $pos5
     */
    public function setPos5($pos5)
    {
        $this->pos5max = $this->posMax;
        $this->rev5max = $this->revMax;
        $this->pos5 = $pos5;
    }


    /**
     * @param mixed $pos7
     */
    public function setPos7($pos7)
    {
        $this->pos7max = $this->posMax;
        $this->rev7max = $this->revMax;
        $this->pos7 = $pos7;
    }

    /**
     * @param mixed $pos9
     */
    public function setPos9($pos9)
    {
        $this->pos9max = $this->posMax;
        $this->rev9max = $this->revMax;
        $this->pos9 = $pos9;
    }

    /**
     * @return mixed
     */
    public function getPos1()
    {
        return $this->pos1;
    }

    /**
     * @return mixed
     */
    public function getPos3()
    {
        return $this->pos3;
    }

    /**
     * @return mixed
     */
    public function getPos5()
    {
        return $this->pos5;
    }

    /**
     * @return mixed
     */
    public function getPos7()
    {
        return $this->pos7;
    }

    /**
     * @return mixed
     */
    public function getPos9()
    {
        return $this->pos9;
    }


    /**
     * @param $cost
     * @param $position
     */
    public function setMax($cost, $position)
    {
        if ($this->revMax < round($cost - $this->getCost())) {
            $this->revMax = round($cost - $this->getCost());
            $this->posMax = $position;
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
            $this->costOpen,

            $this->pos1max,
            $this->rev1max,
            $this->pos1,

            $this->pos3max,
            $this->rev3max,
            $this->pos3,

            $this->pos5max,
            $this->rev5max,
            $this->pos5,

            $this->pos7max,
            $this->rev7max,
            $this->pos7,

            $this->pos9max,
            $this->rev9max,
            $this->pos9,

            $this->posMax,
            $this->revMax,

            $this->volume,
            $this->position,
            $this->peakNum
        ];
    }
}