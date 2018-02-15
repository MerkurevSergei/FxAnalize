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
    private $file;
    private $curPeak;
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
            $this->file = fopen($fileFormatted, $mode);
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
        $row = 0;
        while (($data = fgetcsv($this->handle, 1000, ",")) !== false) {
            yield $row => $data;
            $row++;
        }
    }

    public function nextPeak() {
        $this->handle->
        $fxrecord0 = null;
        $trendLocalTop = 0;
        $trendLocalBottom = 0;
        $peaks = [];
        // TEMP
        $handleUp = fopen(__DIR__ . '/data/EURUSD/1M/EURUSD1PeakUp.csv', 'w+');
        $handleBottom = fopen(__DIR__ . '/data/EURUSD/1M/EURUSD1PeakBottom.csv',
            'w+');

        $countUp = 0;
        $countBottom = 0;
        $peakUpPre = 0;
        $peakBottomPre = 0;

        foreach ($fxdata->next() as $key => $fxrecord1) {
//        if ($key > 10000) {
//            break;
//        }
            if (!$fxrecord0) {
                $fxrecord0 = $fxrecord1;
                $peakUpPre = $fxrecord1[2];
                $peakBottomPre = $fxrecord1[3];
                continue;
            }

            // BODY
            list($point0, $open0, $max0, $min0, $close0, $vol0) = $fxrecord0;
            list($point1, $open1, $max1, $min1, $close1, $vol1) = $fxrecord1;
            if ($min1 > $min0 && $trendLocalBottom < 0) {

                fputcsv($handleBottom, [$countBottom]);
                $countBottom = 0;
            }
            if ($max1 < $max0 && $trendLocalTop > 0) {
                fputcsv($handleUp, [$countUp]);
                $countUp = 0;
            }

            $countUp++;
            $countBottom++;

            // FOR NEXT STEP
            $trendLocalTop = $max1 - $max0;
            $trendLocalBottom = $min1 - $min0;
            $fxrecord0 = $fxrecord1;
        }
        fclose($handleUp);
        fclose($handleBottom);
    }
}
