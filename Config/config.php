<?php
return [
    'Data' => [
        'EURUSD1MRaw' => ROOT.'/data/EURUSD/EURUSD1.csv'
    ],
    'Fxlib' => [
        'Data' => [
            'sizePart' => 50000,
            'sizeCache' => 10000,
        ]

    ],
    'Stategies' => [
        'StrategyIBP' => [
            'factor' => 10000,
            'initGapV' => 1,
            'startNumberPeak' => 2,
            'maxSeqPeaks' => 14,
            'peakFallGapH' => 15,
            'peakBtDistH' => 600
        ]
    ]

];