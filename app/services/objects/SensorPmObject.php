<?php

namespace app\services\objects;

class SensorPmObject
{
    public $sensors = [
        1 => [
            'city' => 'Лобня',
            'str' => 'ул. Юности, 1',
            'sid' => 65998,
            'sidInternal' => 741,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Борисова, 14',
            'sid' => 66091,
            'sidInternal' => 745,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Ленинградская ул., 5/2c1',
            'sid' => 32407,
            'sidInternal' => 219,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Новое шоссе, 12',
            'sid' => 53559,
            'sidInternal' => 515,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'пр-т Ракетостроителей, 5',
            'sid' => 58146,
            'sidInternal' => 589,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Долгопрудная аллея, 15к5',
            'sid' => 49089,
            'sidInternal' => 442,
        ]
    ];

    /**
     * @return array[]
     */
    public function getSensors(): array
    {
        return $this->sensors;
    }
}