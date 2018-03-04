<?php
namespace FxLib;


class RecordWriter
{
    private $file;

    public function __construct($filePath, $mode)
    {
        $this->file = new \SplFileObject($filePath, $mode);
        $this->file->setFlags(\SplFileObject::READ_CSV);
    }


    public function write(array $rawRecord)
    {
        $this->file->fputcsv($rawRecord);
    }
}