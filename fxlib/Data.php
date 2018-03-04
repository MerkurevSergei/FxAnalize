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
     * @var bool|\Generator|resource
     */
    private $file;
    /**
     * @var bool|string
     */
    private $filePath;
    /**
     * @var
     */
    private $mode;

    /**
     * @var SplFileObject
     */
    private $tempfile;
    /**
     * @var string
     */
    private $tempfilePath;

    /**
     * Data constructor.
     *
     * @param     $file
     * @param     $mode
     *
     * @throws Error
     */
    public function __construct($file, $mode)
    {
        $this->mode = $mode;

        // Запоминаем пути к файлам
        $this->filePath = realpath($file);
        $path_parts = explode(DIRECTORY_SEPARATOR, realpath($file));
        array_pop($path_parts);
        $this->tempfilePath = implode(DIRECTORY_SEPARATOR, $path_parts)
            . DIRECTORY_SEPARATOR . 'temp.csv';

        // Открываем файлы
        if (file_exists($this->filePath)) {
            $this->file = new SplFileObject($this->filePath, $this->mode);

            $this->file->setFlags(SplFileObject::READ_CSV);

            $this->tempfile = new SplFileObject($this->tempfilePath, 'w+');
            $this->file->setFlags(SplFileObject::READ_CSV);
        } else {
            throw new Error('Файл не открыт');
        }
        $this->file->current();
    }

    /**
     * @return bool
     */
    public function eof()
    {
        return $this->file->eof();
    }

    /**
     *
     */
    public function current()
    {
        $data = $this->file->current();
        return $data;
    }

    /**
     * @return array|bool|mixed|string
     */
    public function next()
    {
        if ($this->eof()) {
            return false;
        }
        $this->file->next();
        return $this->current();
    }

    /**
     * @return \Generator
     */
    public function records()
    {
        while (!$this->eof()) {
            yield $this->file->key() => $this->file->current();
            $this->next();
        }
    }

    /**
     *
     */
    public function rewind()
    {
        $this->file->rewind();
        $this->current();
    }

    /**
     * @param $position
     */
    public function seek($position)
    {
        $this->file->seek($position);
        $this->current();
    }

    /**
     * @param int $line
     */
    public function cut($line = null)
    {
        if (isset($line)) {
            $this->seek($line);
        }
        $this->flush();
        $this->swap();
    }

    /**
     *
     */
    private function flush()
    {
        foreach ($this->records() as $key => $record) {
            if (empty($record)) {
                continue;
            }
            $this->tempfile->fputcsv($record);
        }
    }

    /**
     * @throws Error
     */
    private function swap()
    {
        unset($this->file);
        unset($this->tempfile);
        unlink($this->filePath);
        rename($this->tempfilePath, $this->filePath);

        if (file_exists($this->filePath)) {
            $this->file = new SplFileObject($this->filePath, $this->mode);
            $this->file->setFlags(splFileObject::READ_CSV);
            $this->tempfile = new SplFileObject($this->tempfilePath, 'w+');
            $this->file->setFlags(SplFileObject::READ_CSV);
        } else {
            throw new Error('Файл не открыт');
        }
    }
}
