<?php

namespace FxLib\Mappers;


use FxLib\RecordRaw;

class MapperIUP
{
    private $options;
    private $records = [];
    public function __construct(Array $options)
    {
        $this->options = $options;
    }
    public function  notify(RecordRaw $record) {
        $this->records[] = $record;
    }
}