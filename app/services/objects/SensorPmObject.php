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
            'sid' => 66355,
            'airCmsId' => 751,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Калинина, 32',
            'sid' => 43445,
            'airCmsId' => 368,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Текстильная, 18',
            'sid' => 66480,
            'airCmsId' => 754,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Деповская, 15',
            'sid' => 66319,
            'airCmsId' => 749,
        ],
        [
            'city' => 'Коломна',
            'str' => 'ул. Добролюбова, 17',
            'sid' => 71947,
            'airCmsId' => 850,
        ],
        [
            'city' => 'Коломна, д. Настасьино',
            'str' => 'ул. Витольдина, 60',
            'sid' => 66929,
            'airCmsId' => 767,
        ],
        [
            'city' => 'Коломна, д. Малое Карасёво',
            'str' => 'ул. Прудная, 12А',
            'sid' => 66959,
            'airCmsId' => 725,
        ],
    ];

    /**
     * @return array[]
     */
    public function getSensors(): array
    {
        return $this->sensors;
    }
}