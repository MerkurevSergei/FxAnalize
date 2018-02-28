<?php

namespace FxLib\Strategies;


use FxLib\Record;

class StrategyIBP
{
    const STAGE_INIT = 'init';
    const STAGE_START = 'start';
    const STAGE_FIND = 'find';
    const STAGE_RESET = 'reset';

    /**
     * @var array
     * KEY DESCRIPTION:
     * factor - multiplier for rate
     * initGapH
     * initGapV
     * peakFrontH - init stage horizontal gap,
     * peakFrontV - init stage vertical gap,
     * peakFallH - init stage horizontal gap,
     * peakFallV - init stage vertical gap
     */
    private $options;
    private $records = [];
    private $stage;


    /** STRATEGY VARIABLES */

    public function __construct(Array $options)
    {
        $this->options = $options;
        $this->stage = self::STAGE_INIT;
    }

    public function notify(Record $record)
    {
        $record->setCost($record->getCost() * $this->options['factor']);
        $this->records[] = $record;
        $this->run();
    }

    private function run()
    {
        call_user_func([$this, $this->stage]);
    }

    private function init()
    {
        $gapV = $this->options['initGapV'];
        $firstRecord = reset($this->records);
        $lastRecord = end($this->records);
        if ($lastRecord->getCost() - $firstRecord->getCost() > 0) {
            array_shift($this->records);
        } elseif ($firstRecord->getCost() - $lastRecord->getCost() >= $gapV) {
            $this->records = [$lastRecord];
            $this->stage = self::STAGE_START;
        }
    }

    private function start()
    {
        echo 'Hello;';
    }
}