<?php

namespace app\services;

use Exception;

class SensorService
{
    public $sensors = [
        'Лобня' => [
            'Катюшки' => 65998,
            'Лобня Сити' => 66091,
        ],
        'Хлебниково' => [
            'Ленинградская ул.' => 65545,
        ],
    ];

    public function getMessage(): string
    {
        $file = './cache.json';
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file),true);
            if ($data['time'] > (time() - 30)) {
               return $this->formatter($data);
            }
        }

        $data = $this->getData();
        file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $this->formatter($data);
    }

    /**
     * @param array $data
     * @return string
     */
    private function formatter(array $data): string
    {
        $msg = 'Данные PM 2.5:' . PHP_EOL . PHP_EOL;
        $type = ' µg/m³';
        foreach ($data['data'] ?? [] as $district => $items) {
            foreach ($items as $street => $val) {
                $msg .= ' - '. $district .', '.$street.': '. $val . $type . PHP_EOL;
            }
        }

        return $msg;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getData(): array
    {
        foreach ($this->sensors as $district => $data) {
            foreach ($data as $street => $id) {
                if (!$json = file_get_contents(getenv('SENSOR_COMMUNITY_HOST'). $id .'/')) {
                    throw new Exception('Json is empty');
                }
                $temp = json_decode($json, true);
                if(!$val = $temp[0]['sensordatavalues'][1]['value'] ?? null) {
                    continue;
                }
                $result['data'][$district][$street] = $val;
            }
        }

        $result['time'] = time();

        return $result;
    }
}