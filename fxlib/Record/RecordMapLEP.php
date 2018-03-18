<?php

namespace FxLib\Record;


/**
 * Class Record
 *
 * @package FxLib
 */
class RecordMapLEP
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
     * @var int
     */
    private $volume;
    /**
     * @var int
     */
    private $type;
    /**
     * @var
     */
    private $cost;
    /**
     * @var
     */
    private $position;
    /**
     * @var int
     */
    private $maxCost;
    /**
     * @var int
     */
    private $maxPos;
    /**
     * @var int
     */
    private $minCost;
    /**
     * @var int
     */
    private $minPos;


    /**
     * RecordMapLEP constructor.
     * @param $rawRecord
     */
    public function __construct(array $rawRecord)
    {
        list($this->date,
            $this->time,
            $this->volume,
            $this->position,
            $this->cost,
            $this->type,
            $this->maxPos,
            $this->maxCost,
            $this->minPos,
            $this->minCost
            ) = $rawRecord;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate(int $date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getMaxCost(): int
    {
        return $this->maxCost;
    }

    /**
     * @param int $maxCost
     */
    public function setMaxCost(int $maxCost)
    {
        $this->maxCost = $maxCost;
    }

    /**
     * @return int
     */
    public function getMaxPos(): int
    {
        return $this->maxPos;
    }

    /**
     * @param int $maxPos
     */
    public function setMaxPos(int $maxPos)
    {
        $this->maxPos = $maxPos;
    }

    /**
     * @return int
     */
    public function getMinCost(): int
    {
        return $this->minCost;
    }

    /**
     * @param int $minCost
     */
    public function setMinCost(int $minCost)
    {
        $this->minCost = $minCost;
    }

    /**
     * @return int
     */
    public function getMinPos(): int
    {
        return $this->minPos;
    }

    /**
     * @param int $minPos
     */
    public function setMinPos(int $minPos)
    {
        $this->minPos = $minPos;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        $row = [];
        $row[] = $this->date;
        $row[] = $this->time;
        $row[] = $this->volume;
        $row[] = $this->position;
        $row[] = $this->cost;
        $row[] = $this->type;
        $row[] = $this->maxPos;
        $row[] = $this->maxCost;
        $row[] = $this->minPos;
        $row[] = $this->minCost;
        return $row;
    }
}