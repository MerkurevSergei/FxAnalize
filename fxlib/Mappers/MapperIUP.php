<?php

namespace FxLib\Mappers;


use FxLib\Record;

class MapperIUP
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