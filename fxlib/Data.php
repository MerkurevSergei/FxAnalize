<?php

namespace FxLib;

use \Error;

/**
 * Class Data
 *
 * @package FxLib
 */

/**
 * Class Data
 *
 * @package FxLib
 */
class Data
{
    /**
     * @var
     */
    private $cursorArray;
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var int
     */
    private $partN = 0;
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
        $this->config = $config;
        if (file_exists($path)) {
            $this->handle = fopen($path, $mode);
        } else {
            throw new Error('Файл ' . $path . ' не открыт');
        }
    }

    /**
     * @return \Generator
     */
    public function records()
    {
        $this->data = [];
        $this->partN = 0;
        $this->cursorArray = 0;
        rewind($this->handle);
        while (($this->data = $this->getPart()) !== false) {
            $sizeCache = $this->config['sizeCache'];
            $size = $this->partN ? count($this->data) - $sizeCache : count($this->data);
            for ($this->cursorArray = 0; $this->cursorArray < $size; $this->cursorArray++) {
                yield $this->data[$this->cursorArray]->getPosition() => $this->data[$this->cursorArray];
            }
            $this->partN++;
        }
    }


    public function getRecord($pos) {
        if (!array_key_exists($this->arrayKey($pos),$this->data)) {
            new Error("Выход за границы массива, возможно кэш отсутствует");
        }
        return $this->data[$this->arrayKey($pos)];
    }
    /**
     * @param Record $record
     */
    public function seek(Record $record)
    {
        $this->cursorArray = $this->arrayKey($record->getPosition());
        if (!array_key_exists($this->cursorArray,$this->data)) {
            new Error("Выход за границы массива, возможно кэш отсутствует");
        }
    }

    /**
     * @return array|bool
     */
    private function getPart()
    {
        $data = $this->data;
        $sizePart = $this->config['sizePart'];
        $sizeCache = $this->config['sizeCache'];
        $cacheKeys = range(-1 * $sizeCache, -1);
        if (feof($this->handle)) {
            rewind($this->handle);
            return false;
        }
        if ($this->partN) {
            $data = array_slice($data, -1 * $sizeCache);
            $data = array_combine($cacheKeys, $data);
        }
        for ($i = 0; $i < $sizePart; $i++) {
            $row = fgetcsv($this->handle, $this->config['maxRowLength'], $this->config['delimeter']);
            if (!$row) {
                continue;
            }
            if ($row === false) {
                break;
            }
            $row[] = $this->fileKey($i);
            $data[] = new Record($row);
        }
        return $data;
    }

    /**
     * @param $arrayKey
     * @return int|mixed
     */
    private function fileKey($arrayKey)
    {
        return $arrayKey + $this->partN * $this->config['sizePart'];
    }

    /**
     * @param $fileKey
     * @return int
     */
    private function arrayKey($fileKey)
    {
        return $fileKey - $this->partN*$this->config['sizePart'];
    }

    /**
     *
     */
    public function __destruct()
    {
        fclose($this->handle);
    }

}
