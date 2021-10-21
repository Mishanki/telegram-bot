<?php

namespace app\services;

use app\utils\ThresholdUtils;

class AirCMSService
{
    public $sensors = [
        1 => [
            'city' => 'Лобня',
            'str' => 'ул. Юности, 1',
            'sid' => 741,
        ],
        [
            'city' => 'Лобня',
            'str' => 'ул. Борисова, 14',
            'sid' => 745,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Ленинградская ул., 5/2с1',
            'sid' => 219,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Новое шоссе, 12',
            'sid' => 515,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'пр-т Ракетостроителей, 5',
            'sid' => 589,
        ],
        [
            'city' => 'Долгопрудный',
            'str' => 'Долгопрудная аллея, 15к5',
            'sid' => 442,
        ]
    ];

    public function getDevices()
    {
        $data = file_get_contents(getenv('AIRCMS_API_HOST').'?devices');

        echo '<pre>';
        print_r($data);
        echo '</pre>';

        return [];
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMessage(): string
    {
        try {
            $data = $this->getData();

            return $this->formatter($data);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param array $data
     * @return string
     */
    private function formatter(array $data): string
    {
        foreach ($data as $senId => $item) {
            foreach ($this->sensors as $num => $sensor) {
                if ($sensor['sid'] == $senId) {
                    $item['city'] = $sensor['city'] ?? null;
                    $item['str'] = $sensor['str'] ?? null;
                    $msg[$num] = $item;
                }
            }
        }

        ksort($msg);

        $type = 'мкг/ куб. м.';
        $resultMsg = 'Мониторинг воздуха.' . PHP_EOL . PHP_EOL;
        $tmpCity = null;
        foreach ($msg as $item) {

            if(empty($tmpCity) || $tmpCity && $tmpCity != $item['city'] . $item['str']) {
                $tmpCity = $item['city'] . $item['str'];
                $resultMsg .= '*'.$item['city'] . ', ' . $item['str'].'*' . PHP_EOL;
            }

            $resultMsg .= 'PM 2.5  -  ' . ThresholdUtils::markdownPm25($item['sds_p2']) . ' ' . $type . PHP_EOL;
            $resultMsg .= 'PM 10   -  ' . ThresholdUtils::markdownPm10($item['sds_p1']) . ' ' . $type . PHP_EOL;
            $resultMsg .= 'Темп-ра  -  ' . $item['ds18b20_temperature'] . ' °C' . PHP_EOL;
            $resultMsg .= 'Влаж-ть  -  ' . $item['humidity'] . ' %' . PHP_EOL;
            $resultMsg .= 'Давл-е  -  ' . $item['pressure'] . ' мм рт. ст.'. PHP_EOL;
            $resultMsg .= 'Ветер   -  ' . $this->windDirectionTranslate($item['wind_direction']) . ', ' . $item['wind_speed'] . ' м/с'. PHP_EOL;


            $resultMsg .=  PHP_EOL;

        }

        $resultMsg .= 'Отправьте боту @PmLobnyaBot в личном сообщении /help';
//        $resultMsg .= PHP_EOL. PHP_EOL;
//        $resultMsg .= 'https://aircms.online/' . PHP_EOL;

        return $resultMsg;
    }

    /**
     * @param string $direction
     * @return string
     */
    private function windDirectionTranslate(string $direction): string
    {
        switch ($direction)
        {
            case 'n':
                $direction = 'с';
                break;
            case 'e':
                $direction = 'в';
                break;
            case 's':
                $direction = 'ю';
                break;
            case 'w':
                $direction = 'з';
                break;
            case 'sw':
                $direction = 'юз';
                break;
            case 'se':
                $direction = 'юв';
            case 'nw':
                $direction = 'сз';
                break;
            case 'ne':
                $direction = 'св';
                break;
            default:
                break;
        }

        return mb_strtoupper($direction);
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getData(): array
    {
        if(!$json = file_get_contents(getenv('AIRCMS_API_HOST').'?T=0')) {
            throw new \Exception('Json is empty');
        }

        $ids = $this->getIds();
        $data = json_decode($json, true);

        if (empty($data['data'])) {
            throw new \Exception('Data is not found');
        }

        foreach ($data['data'] ?? [] as $item) {
            $id = $item['device_id'] ?? null;
            if (in_array($id, $ids)) {
                $tsTime = (time() - $item['ts']);
                $item['time'] = date('H:i:s', $tsTime);

                $result[$id] = $item;
            }
        }

        return $result ?? [];
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