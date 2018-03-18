<?php


namespace FxLib\Data;

use \Error;

/**
 * Class ArrayData
 * @package FxLib\Data
 */
class ArrayData
{

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $config = [];
    /**
     * @var bool|null|resource
     */
    private $handle = null;


    /**
     * Data constructor.
     * @param $path
     * @param $mode
     * @param $config
     * @throws Error
     */
    public function __construct($path, $mode, $config)
    {
        $this->handle = fopen($path, $mode);
        $this->config = $config;
        while (!feof($this->handle)) {
            $row = fgetcsv($this->handle, $this->config['maxRowLength'], $this->config['delimeter']);
            if (!$row) {
                continue;
            }
            $record = new $this->config['type']($row);
            $this->data[$record->getPosition()] = $record;
        }
    }


    public function exist($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return false;
        }

    }

    /**
     * @param $record
     */
    public function write($record)
    {
        fputcsv($this->handle, $record->toArray());
    }

    /**
     *
     */
    public function __destruct()
    {
        fclose($this->handle);
    }
}