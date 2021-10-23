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
            'city' => 'Лобня',
            'str' => 'Деповская ул., 15',
            'sid' => 66319,
            'airCmsId' => 749,
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