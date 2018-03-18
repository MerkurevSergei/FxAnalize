<?php

namespace FxLib;

use FxLib\Data\ArrayData;
use FxLib\Data\BigData;

class DI
{
    private $dataBase;
    private $dataHelp;
    private $options;
    private $dataOut;

    public function __construct()
    {
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
    public function getDataBase() : BigData
    {
        return $this->dataBase;
    }

    /**
     * @param mixed $dataBase
     */
    public function setDataBase(BigData $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    /**
     * @return mixed
     */
    public function getDataHelp() : ArrayData
    {
        return $this->dataHelp;
    }

    /**
     * @param mixed $dataHelp
     */
    public function setDataHelp(ArrayData $dataHelp)
    {
        $this->dataHelp = $dataHelp;
    }

    /**
     * @return mixed
     */
    public function getDataOut() : ArrayData
    {
        return $this->dataOut;
    }

    /**
     * @param mixed $dataOut
     */
    public function setDataOut(ArrayData $dataOut)
    {
        $this->dataOut = $dataOut;
    }



}