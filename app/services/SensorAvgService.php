<?php

namespace app\services;

use DateTimeZone;
use Exception;

class SensorAvgService
{
    public $sensors = [
        1 => [
            'city' => 'Лобня',
            'str' => 'ул. Юности, 1',
            'sid' => 65998,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Борисова, 14',
            'sid' => 66091,
        ],
        [
            'city' => 'Хлебниково',
            'str' => 'Ленинградская ул., 5/2С',
            'sid' => 32407,
        ],
        [
            'city' => 'Хлебниково',
            'str' => 'Новое шоссе, 12',
            'sid' => 53559,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'пр-т Ракетостроителей, 5',
            'sid' => 58146,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Долгопрудная аллея, 15К5',
            'sid' => 49089,
        ]
    ];

    public function getMessage(): string
    {
        $file = './avg_cache.json';
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file),true);
            if ($data['time'] > (time() - 45)) {
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
     * @throws Exception
     */
    private function formatter(array $data): string
    {
        $type = 'µg/m³';
        $msg[0] = 'Данные PM 2.5, среднее значение за 1 час:';

        foreach ($data['data'] as $senId => $items) {
            foreach ($items as $time => $v) {
                foreach ($this->sensors as $num => $sensor) {
                    if ($sensor['sid'] == $senId) {
                        $msg[$num][$time] = [
                            'city' => $sensor['city'],
                            'str' => $sensor['str'],
                            'value' => $v,
                        ];
//                        break 2;
                    }
                }
            }
        }

        ksort($msg);

        $result = '';
        foreach ($msg as $items) {
            if (!is_array($items)) {
                $result .= $items . PHP_EOL . PHP_EOL;
              continue;
            }
            $tmp = '';
            foreach ($items as $time => $item) {

                if (empty($tmp) || !empty($tmp) && $tmp != $item['city'] . $item['str']) {
                    $tmp = $item['city'] . $item['str'];
                    $result .= $item['city'] . ', ' . $item['str'] . PHP_EOL;
                }

                $dateObj = new \DateTime($time.'UTC');
                $dateObj->setTimezone(new DateTimeZone('Europe/Moscow'));
                $result .=  $dateObj->format('H:i:s') . ' - ' . $item['value'] . ' ' . $type . PHP_EOL;
            }
            $result .= PHP_EOL;
        }

        $result .= 'Отправьте боту @PmLobnyaBot в личном сообщении /history и он пришлёт Вам среднее значение за 1 час.' . PHP_EOL. PHP_EOL;
        $result .= 'https://aircms.online/' . PHP_EOL;

        return $result;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getData(): array
    {
        if(!$json = file_get_contents(getenv('SENSOR_COMMUNITY_HOST_HISTORY'))) {
            throw new Exception('Json is empty');
        }

        $ids = $this->getIds();
        $data = json_decode($json, true);
        $result = [];
        foreach ($data as $item) {
            $id = $item['sensor']['id'] ?? null;
            $time = $item['timestamp'] ?? null;
            $pmVal = $item['sensordatavalues'][1]['value'] ?? null;
            if (in_array($id, $ids)) {
                if (!empty($result[$id])) {
//                    continue;
                }
                $result['data'][$id][$time] = $pmVal;
            }
        }

        $result['time'] = time();

        return $result;
    }

    /**
     * @return array
     */
    private function getIds(): array
    {
        foreach ($this->sensors as $item) {
            $ids[] = $item['sid'];
        }

        return $ids ?? [];
    }
}