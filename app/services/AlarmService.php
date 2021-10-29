<?php

namespace app\services;

use app\models\dictionary\MeasurementDictionary as MD;
use app\services\objects\SensorPmObject;
use app\utils\Utils;

class AlarmService
{
    /**
     * @param array $data
     * @return null|string
     */
    public function getAlarmMessage(array $data): ?string
    {
        $data = $this->getData($data);
        foreach ($data as $num => $item) {
            if (!$this->isAlarmItem($item)) {
                unset($data[$num]);
                continue;
            }
        }

        return $this->formatter($data);
    }

    /**
     * @param array $data
     * @return null|string
     */
    private function formatter(array $data): ?string
    {
        $msg = 'Средняя концентрация взвешенных частиц PM 2.5' . PHP_EOL . PHP_EOL;
        foreach ($data as $item) {
            $msg .= '*'.$item['city'] . ', ' . $item['str'] . '*';
            $msg .= ' - ' . $item['sds_p2'] . ' ' .  MD::MEASUREMENT_PM_RU . PHP_EOL;
        }

        return $data ? $msg : null;
    }

    /**
     * @param array $item
     * @return bool
     */
    private function isAlarmItem(array $item): bool
    {
        if (Utils::isPm25Alarm24($item['sds_p2'])) {
            return true;
        }

        return false;
    }

    /**
     * @param array $data
     * @return array
     */
    private function getData(array $data): array
    {
        foreach ($data as $senId => $item) {
            foreach ((new SensorPmObject())->getSensors() as $num => $sensor) {
                if ($sensor['airCmsId'] == $senId) {
                    $item['city'] = $sensor['city'] ?? null;
                    $item['str'] = $sensor['str'] ?? null;
                    $msg[$num] = $item;
                }
            }
        }

        return $msg;
    }
}