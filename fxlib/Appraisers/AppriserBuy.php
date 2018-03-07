<?php

namespace FxLib\Appraisers;

use FxLib\DI;

class AppriserBuy
{
    public function __construct(DI $di)
    {
        $this->options = $di->getOptions()['Strategies']['StrategyIBP'];
        $this->data = $di->getData();
        $this->writer = $di->getWriter();
    }

    public function start()
    {
        foreach ($this->data->records() as $key => $record) {
            if (!$this->cursor) {
                $this->cursor = $this->data->getRecord(0);
                $this->peakNumber = 0;
                $this->stage = self::STAGE_INIT;
            }
            $this->notify($record);
        }
    }

    private function reset()
    {
        $this->peakNumber = 0;
        $this->stage = self::STAGE_INIT;
        $this->data->seek($this->cursor);
    }

    /**
     * @param Record $record
     *
     */
    private function notify(Record $record)
    {
        call_user_func([$this, $this->stage], $record);
    }

    /**
     * @param Record $record
     */
    private function init(Record $record)
    {
        $gapV = $this->options['initGapV'];
        if ($this->cursor->getCost() < $record->getCost()) {
            $this->cursor = $record;
        } elseif ($this->cursor->getCost() - $record->getCost() >= $gapV) {
            $this->cursor = $record;
            $this->stage = self::STAGE_FIND;
            $this->find($record);
        }
    }

}