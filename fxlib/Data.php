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
    private $data = [];
    private $partN = 0;
    private $config = [];
    private $handle = null;


    public function __construct($path, $mode, $config)
    {
        $this->config = $config;
        if (file_exists($path)) {
            $this->handle = fopen($path, $mode);
        } else {
            throw new Error('Файл ' . $path . ' не открыт');
        }
    }

    public function records()
    {
        while (($this->data = $this->getPart()) !== false) {
            foreach ($this->data as $key => $record) {
                echo '<pre>';
                $st = [];
                $st[] = $record;
                $st[] = $key;
                print_r($st);
                print_r($this->arrayKey($record->getPosition()));
                echo '<pre>';
            }
            $this->partN++;
        }
    }
//    /**
//     * @return \Generator
//     */
//    public function records()
//    {
//        while (!$this->eof()) {
//            yield $this->file->key() => $this->file->current();
//            $this->next();
//        }
//    }
//
//    /**
//     *
//     */
//    public function rewind()
//    {
//        $this->file->rewind();
//        $this->current();
//    }
//
//    /**
//     * @param $position
//     */
//    public function seek($position)
//    {
//        $this->file->seek($position);
//        $this->current();
//    }

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
            $row = fgetcsv($this->handle, $this->config['maxRowSize'], $this->config['delimeter']);
            if ($row === false) {
                break;
            }
            $row[] = $this->fileKey($i);
            $data[] = new Record($row);
        }
        return $data;
    }

    private function fileKey ($arrayKey) {
        return $arrayKey + $this->partN*$this->config['sizePart'];
    }
    private function arrayKey($fileKey) {
        return $fileKey%$this->config['sizePart'];
    }
    public function __destruct()
    {
        fclose($this->handle);
    }

}
