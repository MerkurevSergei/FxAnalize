<?php
return [
    'Mappers' => [
        'MapperIBP' => [
            'initGapV' => 5,
            'startNumberPeak' => 1,
            'maxSeqPeaks' => 14,
            'peakFallGapH' => 64,
            'peakBtDistH' => 320
        ],
        'MapperLEP' => [
            'initGapV' => 3,
            'fixGapV' => 3,
            'logPeriod' => 320
        ]
    ],
    'Appraisers' => [
        'AppraiserIBP' => [
            'startNumberPeak' => 1,
            'distAppraised' => 1440,
            'spread' => 2
        ],
        'AppraiserIBPFirstPeak' => [
            'startNumberPeak' => 1,
            'peakFallGapH' => 64,
            'distAppraised' => 2880,
            'spread' => 2
        ],
        'AppraiserLEP' => [
            'distAppraised' => 7200,
            'spread' => 2
        ]

    ]


];