<?php
return [
    'Data' => [
        'EURUSD1MRaw' => ROOT.'/data/EURUSD/EURUSD1.csv',
        'EURUSD1MMap' => ROOT.'/data/EURUSD/EURUUSD1MapIBP.csv',
    ],
    'Fxlib' => [
        'Data' => [
            'sizePart' => 500000,
            'sizeCache' => 10000,
            'maxRowLength' => 60,
            'delimeter' => ','
        ]

    ],
    'Mappers' => [
        'MapperIBP' => [
            'initGapV' => 5,
            'startNumberPeak' => 1,
            'maxSeqPeaks' => 14,
            'peakFallGapH' => 64,
            'peakBtDistH' => 320
        ]
    ]

];