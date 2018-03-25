<?php


namespace FxLib\Neuro;

use FxLib\DI;
use FxLib\Record\RecordMapLEP;
use FxLib\Record\RecordRaw;

class Converter
{
    /**
     * @var \FxLib\Data\BigData|mixed
     */
    private $data;
    private $dataOut;
    private $options;

    private $logPast = [];
    private $logFuture = [];
    private $flagLogP = 0;
    private $flagLogF = 0;

    public function __construct(DI $di)
    {
        $this->options = $di->getOptions();
        $this->data = $di->getDataBase();
        $this->dataOut = $di->getDataOut();
    }

    public function start()
    {
        foreach ($this->data->records() as $key => $record) {
            if (!$this->flagLogF) {
                $this->logFuture[] = $record->getCost();
                $this->flagLogF = count($this->logFuture) >= $this->options['logFSize'];
                continue;
            }
            if (!$this->flagLogP) {
                $this->logPast[] = array_shift($this->logFuture);
                $this->logFuture[] = $record->getCost();
                $this->flagLogP = count($this->logPast) >= $this->options['logPSize'];
                continue;
            }
            array_shift($this->logPast);
            $this->logPast[] = array_shift($this->logFuture);
            $this->logFuture[] = $record->getCost();
            $this->PrepAndWrite($this->logPast, $this->logFuture);
        }
    }

    private function PrepAndWrite($logPast, $logFuture)
    {
        $base = end($logPast);
        $answer = [0, 1, 0];

        array_walk($logPast, function (&$item, $key, $base) {
            $item = round($item -$base);
        }, $base);

        foreach ($logFuture as $value) {
            if ($value-$base >= $this->options['upperBound']) {
                $answer = [1,0,0];
                break;
            }
            if ($base-$value >= $this->options['bottomBound']) {
                $answer = [0,0,1];
                break;
            }

        }
        $str = array_merge($logPast,$answer);
        $this->dataOut->writeArray($str);
    }
}