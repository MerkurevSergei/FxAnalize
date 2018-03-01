<?php
/**
 * Created by PhpStorm.
 * User: SergMers
 * Date: 12.02.2018
 * Time: 15:29
 */

namespace FxLib;


/**
 * Class Record
 *
 * @package FxLib
 */
class Record
{
    /**
     * -1 - bottom peak, 0 - not peak, 1 - top peak
     *
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
    private $cost;

    /**
     * @var
     */
    private $volume;

    /**
     * @var
     */
    private $position;

    /**
     * @var int
     */
    private $peakType = 0;


    /**
     * Peak constructor.
     *
     * @param $recordParts
     */
    public function __construct($recordParts)
    {
        list($this->date, $this->time, $this->cost, , , , $this->volume)
            = $recordParts[0];

        $this->position = $recordParts[0]['line'];
        $this->setPeakType($recordParts);
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
    public function getPosition()
    {
        return $this->position;
    }


    /**
     * @return mixed
     */
    public function getPeakType()
    {
        return $this->peakType;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            $this->date,
            $this->time,
            $this->cost,
            $this->volume,
            $this->position
        ];
    }

    /**
     * @return bool
     */
    public function isPeak()
    {
        if ($this->peakType != 0) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isBottomPeak()
    {
        if ($this->peakType == -1) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isUpperPeak()
    {
        if ($this->peakType == 1) {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @param $recordParts
     */
    private function setPeakType($recordParts)
    {
        list(, , $cost0) = $recordParts[0];
        list(, , $cost1) = $recordParts[1];
        $lasttrend = $recordParts[0]['trend'];
        if ($cost0 < $cost1 && $lasttrend == -1) {
            $this->peakType--;
        }
        elseif ($cost0 > $cost1 && $lasttrend == 1) {
            $this->peakType++;
        }
    }

}