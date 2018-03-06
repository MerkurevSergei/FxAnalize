<?php
return [
    'Data' => [
        'EURUSD1MRaw' => ROOT.'/data/EURUSD/EURUSD1.csv'
    ],
    'Fxlib' => [
        'Data' => [
            'sizePart' => 4,
            'sizeCache' => 2,
            'maxRowSize' => 60,
            'delimeter' => ','
        ]

    ],
    'Strategies' => [
        'StrategyIBP' => [
            'initGapV' => 1,
            'startNumberPeak' => 2,
            'maxSeqPeaks' => 14,
            'peakFallGapH' => 15,
            'peakBtDistH' => 600
        ]
    ]

];