<?php

namespace FxLib\Strategies;


use FxLib\Record;

class StrategyIBP
{
    const STAGE_INIT = 'init';
    const STAGE_START = 'start';
    const STAGE_FIND = 1;
    const STAGE_RESET = 2;

    /**
     * @var array
     * KEY DESCRIPTION:
     * PeakFrontH - init stage horizontal gap,
     * PeakFrontV - init stage vertical gap,
     * PeakFallH - init stage horizontal gap,
     * PeakFallV - init stage vertical gap
     */
    private $options;
    private $records = [];
    private $stage;

    public function __construct(Array $options)
    {
        $this->options = $options;
        $this->stage = self::STAGE_INIT;
    }

    public function notify(Record $record)
    {
        $this->records[] = $record;
        $this->run();
    }

    private function run()
    {
        call_user_func([$this, $this->stage]);
    }

    private function init()
    {
        echo 'Hello';
    }
}