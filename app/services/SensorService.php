<?php

namespace app\services;

use Exception;

class SensorService
{
    public $sensors = [
        'Катюшки' => [
            65998
        ],
        'Лобня Сити' => [
            66091
        ],
    ];

    public function getMessage(): string
    {
        $data = $this->getData();

        return $this->formatter($data);
    }

    /**
     * @param array $data
     * @return string
     */
    private function formatter(array $data): string
    {
        $msg = 'PM 2.5:' . PHP_EOL;
        foreach ($data as $item => $value) {
            $msg .= ' - '. $item . ': ' . $value . PHP_EOL;
        }

        return $msg;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getData(): array
    {
        foreach ($this->sensors as $district => $ids) {
            foreach ($ids as $id) {
                if (!$json = file_get_contents(getenv('SENSOR_COMMUNITY_HOST'). $id .'/')) {
                    throw new Exception('Json is empty');
                }
                $temp = json_decode($json, true);
                if(!$val = $temp[0]['sensordatavalues'][1]['value'] ?? null) {
                    continue;
                }
                $data[$district] = $val;
            }
        }

        return $data ?? [];
    }
}