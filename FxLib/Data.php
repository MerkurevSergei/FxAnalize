<?php

namespace FxLib;


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
     * @var bool|\Generator|resource
     */
    private $handle;

    /**
     * Data constructor.
     *
     * @param $file
     * @param $fileFormatted
     * @param $mode
     *
     * @throws \Error
     */
    public function __construct($file, $fileFormatted, $mode)
    {
        if (file_exists($fileFormatted)) {
            $this->handle = fopen($fileFormatted, $mode);
        } elseif (file_exists($file)) {
            $this->handle = $this->createFormatFile($file, $fileFormatted,
                $mode);
        } else {
            throw new \Error('Файл не открыт');
        }
    }

    /**
     * @param $file
     * @param $fileFormatted
     * @param $mode
     *
     * @return bool|\Generator|resource
     */
    private function createFormatFile($file, $fileFormatted, $mode)
    {
        echo('Форматируем данные...');
        $oldHandle = fopen($file, 'r');
        $handle = fopen($fileFormatted, 'w+');


        while (($data = fgetcsv($oldHandle, 60, ",")) !== false) {
            $volume = array_pop($data);
            $volume = str_pad($volume, 10, "0", STR_PAD_LEFT);
            $data[] = $volume;
            fputcsv($handle, $data);
        }

        fclose($oldHandle);
        fclose($handle);
        $handle = fopen($fileFormatted, $mode);
        echo('Готово!   ');
        return $handle;
    }

    /**
     * @return \Generator
     */
    public function next()
    {
        while (($data = fgetcsv($this->handle, 1000, ",")) !== false) {
            yield $data;
        }
    }
}
