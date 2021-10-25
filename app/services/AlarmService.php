<?php

namespace app\services;

use app\models\dictionary\MeasurementDictionary as MD;
use app\services\objects\SensorPmObject;
use app\utils\ThresholdUtils;

class AlarmService
{
    /* @var $airCMSService AirCMSService */
    public $airCMSService;

    /**
     * AlarmService constructor.
     * @param AirCMSService $airCMSService
     */
    public function __construct(AirCMSService $airCMSService)
    {
        $this->airCMSService = $airCMSService;
    }

    /**
     * @return null|string
     * @throws \Exception
     */
    public function getAlarmMessage(): ?string
    {
        $data = $this->getData();
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
        if (ThresholdUtils::isPm25Alarm24($item['sds_p2'])) {
            return true;
        }

        return false;
    }

    private function getData() {
        $data = $this->airCMSService->getData();
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