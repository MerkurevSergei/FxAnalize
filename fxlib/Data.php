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
        $this->setData();
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

    private function setData()
    {
        $sizePart = $this->config['sizePart'];
        $sizeCache = $this->config['sizeCache'];
        $cacheKeys = range(-1 * $sizeCache, -1);
        while (!feof($this->handle)) {

            if (count($this->data) >= $sizeCache) {
                $this->data = array_slice($this->data, -1 * $cacheKeys);
                array_combine($cacheKeys, $this->data);
            }
            for ($i = 0; $i < $sizePart; $i++) {
                $row = fgetcsv($this->handle, 60, ",");
                $this->data[] = $row;
            }
        }

        fclose($this->handle);
    }

}
