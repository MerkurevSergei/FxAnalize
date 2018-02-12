<?php
/**
 * Created by PhpStorm.
 * User: SergMers
 * Date: 12.02.2018
 * Time: 15:29
 */

namespace FxLib;


/**
 * Class Peak
 *
 * @package FxLib
 */
class Peak
{
    /**
     * @var int
     */
    private $peak;
    private $type;
    private $steps = 0;
    private $revenue = 0;

    private $dist = 0;
    private $diff = 0;

    /**
     * Peak constructor.
     *
     * @param $point
     */
    public function __construct($point, $type, $dist, $diff)
    {
        $this->peak = $point * 10000;
        $this->dist = $dist;
        $this->diff = $diff;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getPeak()
    {
        return $this->peak;
    }

    /**
     * @return int
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    public function closed($point)
    {
        $this->steps++;
        if ($this->type == 'down') {
            $this->revenue = $point * 10000 - $this->peak;
        } else {
            $this->revenue = $this->peak - $point * 10000;
        }

        if ($this->revenue < $this->diff || $this->steps > $this->dist)  {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * @return int
     */
    public function getDist()
    {
        return $this->dist;
    }

    /**
     * @return int
     */
    public function getDiff()
    {
        return $this->diff;
    }


}