<?php

namespace FxLib;

use \SplFileObject, \Error;

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
            $this->tempfile->setFlags(SplFileObject::READ_CSV);
        } else {
            throw new Error('Файл не открыт');
        }
        $this->file->current();
    }


    /**
     *
     */
    public function current()
    {
        if ($this->file->valid()) {
            $data = $this->file->current();
            $key = $this->file->key();
            $data['line'] = $key;
            return $data;
        }
        return false;
    }

    public function next()
    {
        $this->file->next();
        return $this->current();
    }

    /**
     * @return \Generator
     */
    public function records()
    {
        while ($this->file->valid()) {
            $record = $this->file->current();
            $record['line'] = $this->file->key();

            $this->file->next();
            yield $this->file->key() => $record;
        }
    }

    /**
     *
     */
    public function rewind()
    {
        $this->file->rewind();
        $this->file->current();
    }

    /**
     * @param $position
     */
    public function seek($position)
    {
        $this->file->seek($position);
        $this->file->current();
    }

    /**
     * @param int $line
     */
    public function cut($line = 0)
    {
        if (isset($line)) {
            $this->file->seek($line);
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
            $this->file->setFlags(SplFileObject::READ_CSV);
            $this->tempfile = new SplFileObject($this->tempfilePath, 'w+');
            $this->tempfile->setFlags(SplFileObject::READ_CSV);
        } else {
            throw new Error('Файл не открыт');
        }
    }
}
