<?php

namespace FxLib\Strategies;


use FxLib\Record;

class StrategyIUP
{
    private $options;
    private $records = [];
    public function __construct(Array $options)
    {
        $this->options = $options;
    }
    public function  notify(Record $record) {
        $this->records[] = $record;

    }
}