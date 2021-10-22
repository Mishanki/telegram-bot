<?php

namespace app\services\objects;

class SensorPmObject
{
    public $sensors = [
        1 => [
            'city' => 'Лобня',
            'str' => 'ул. Юности, 1',
            'sid' => 65998,
            'airCmsId' => 741,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Борисова, 14',
            'sid' => 66091,
            'airCmsId' => 745,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Ленинградская ул., 5/2c1',
            'sid' => 32407,
            'airCmsId' => 219,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Новое шоссе, 12',
            'sid' => 53559,
            'airCmsId' => 515,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'пр-т Ракетостроителей, 5',
            'sid' => 58146,
            'airCmsId' => 589,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Долгопрудная аллея, 15к5',
            'sid' => 49089,
            'airCmsId' => 442,
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