<?php

namespace FxLib;


class DI
{
    private $data;
    private $options;
    private $writer;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getData(): Data
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData(Data $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getWriter(): RecordWriter
    {
        return $this->writer;
    }

    /**
     * @param mixed $writer
     */
    public function setWriter(RecordWriter $writer)
    {
        $this->writer = $writer;
    }

}