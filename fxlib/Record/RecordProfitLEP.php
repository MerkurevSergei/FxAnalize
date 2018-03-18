<?php

namespace FxLib\Record;

/**
 * Class Record
 *
 * @package FxLib
 */
class RecordProfitLEP extends RecordMapLEP
{
    /**
     * @var mixed
     */
    private $distProfit = 0;
    /**
     * @var mixed
     */
    private $profit = 0;
    /**
     * @var mixed
     */
    private $distEnd = 0;
    /**
     * @var
     */
    private $closed = false;

    /**
     * RecordMapLEP constructor.
     * @param $rawRecord
     */
    public function __construct(array $rawRecord)
    {
        parent::__construct($rawRecord);
        $this->distEnd = array_pop($rawRecord);
        $this->profit = array_pop($rawRecord);
        $this->distProfit = array_pop($rawRecord);
    }

    /**
     * @return mixed
     */
    public function getDistProfit()
    {
        return $this->distProfit;
    }

    /**
     * @param mixed $distProfit
     */
    public function setDistProfit($distProfit)
    {
        $this->distProfit = $distProfit;
    }

    /**
     * @return mixed
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @param mixed $profit
     */
    public function setProfit($profit)
    {
        $this->profit = $profit;
    }

    /**
     * @return mixed
     */
    public function getDistEnd()
    {
        return $this->distEnd;
    }

    /**
     * @param mixed $distEnd
     */
    public function setDistEnd($distEnd)
    {
        $this->distEnd = $distEnd;
    }

    /**
     * @param $cost
     * @param $position
     */
    public function setMax($cost, $position)
    {
        if ($this->profit < $this->getType() *  round($this->getCost() - $cost)) {
            $this->profit = $this->getType() *  round($this->getCost() - $cost);
            $this->distProfit = round($position - $this->getPosition());
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
     * @return array
     */
    public function toArray()
    {
        $row = parent::toArray();
        $row[] = $this->distProfit;
        $row[] = $this->profit;
        $row[] = $this->distEnd;
        return $row;
    }
}