<?php
return [
    'Raw' => [
        'sizePart' => 500000,
        'sizeCache' => 10000,
        'maxRowLength' => 70,
        'delimeter' => ','
    ],
    'MapLEP' => [
        'type' => 'FxLib\Record\RecordMapLEP',
        'maxRowLength' => 75,
        'delimeter' => ','
    ],
    'Map' => [
        'type' => 'FxLib\Record\RecordMap',
        'maxRowLength' => 75,
        'delimeter' => ','
    ],
    'Profit' => [
        'type' => 'FxLib\Record\RecordProfit',
        'maxRowLength' => 160,
        'delimeter' => ','
    ],
    'ProfitFirstPeak' => [
        'type' => 'FxLib\Record\RecordProfitFirstPeak',
        'maxRowLength' => 160,
        'delimeter' => ','
    ],
    'ProfitLEP' => [
        'type' => 'FxLib\Record\RecordProfitLEP',
        'maxRowLength' => 85,
        'delimeter' => ','
    ],
    'PrePeak' => [
        'type' => 'FxLib\Record\RecordProfit',
        'maxRowLength' => 160,
        'delimeter' => ','
    ],
    'NeuroData' => [
        'type' => 'FxLib\Record\RecordProfit',
        'maxRowLength' => 160,
        'delimeter' => ','
    ]
];