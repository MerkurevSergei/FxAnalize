<?php

class FileCsv
{
    public function __construct($file, $mode)
    {
        if (file_exists($file)) {
            $handle = fopen($file, $mode);
            return $handle;
        }
        else
        {
            throw new Error('Файл не открыт');
        }
    }
}