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
            'str' => 'ул. Катюшки, 34А',
            'sid' => 66348,
            'airCmsId' => 750,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Борисова, 14',
            'sid' => 66091,
            'airCmsId' => 745,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. 40 лет Октября, 16',
            'sid' => null,
            'airCmsId' => 751,
        ],
        [
            'city' => 'Лобня',
            'str' => 'Деповская ул., 15',
            'sid' => 66319,
            'airCmsId' => 749,
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