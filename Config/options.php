<?php
return [
    'Data' => [
        'EURUSD1MRaw' => ROOT.'/data/EURUSD/EURUSD1.csv'
    ],
    'System' => [
        'dataSize' => 500000
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