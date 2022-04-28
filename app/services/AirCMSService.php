<?php

namespace app\services;

use app\models\dictionary\MeasurementDictionary;
use app\network\MainHTTPServiceInterface;
use app\services\objects\SensorPmObject;
use app\utils\Utils;
use Exception;

class AirCMSService
{
    /* @var $httpService MainHTTPServiceInterface */
    public $httpService;

    /**
     * AirCMSService constructor.
     * @param MainHTTPServiceInterface $httpService
     */
    public function __construct(MainHTTPServiceInterface $httpService)
    {
        $this->httpService = $httpService;
    }

    /**
     * @return string
     * @throws Exception
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
            foreach ((new SensorPmObject())->getSensors() as $num => $sensor) {
                if ($sensor['airCmsId'] == $senId) {
                    $item['city'] = $sensor['city'] ?? null;
                    $item['str'] = $sensor['str'] ?? null;
                    $msg[$num] = $item;
                }
            }
        }

        ksort($msg);

        $type = MeasurementDictionary::MEASUREMENT_PM_RU;
        $resultMsg = 'Общий мониторинг воздуха' . PHP_EOL . PHP_EOL;
        $tmpCity = null;
        foreach ($msg as $item) {

            if(empty($tmpCity) || $tmpCity && $tmpCity != $item['city'] . $item['str']) {
                $tmpCity = $item['city'] . $item['str'];
                $resultMsg .= '*'.$item['city'] . ', ' . $item['str'].'*' . PHP_EOL;
            }

            $resultMsg .= 'PM 2.5  -  ' . Utils::markdownPm25($item['sds_p2']) . ' ' . $type . PHP_EOL;
            $resultMsg .= 'PM 10   -  ' . Utils::markdownPm10($item['sds_p1']) . ' ' . $type . PHP_EOL;
            $resultMsg .= 'Темп-ра  -  ' . $item['ds18b20_temperature'] . ' °C' . PHP_EOL;
            $resultMsg .= 'Влаж-ть  -  ' . $item['humidity'] . ' %' . PHP_EOL;
            $resultMsg .= 'Давл-е  -  ' . $item['pressure'] . ' мм рт. ст.'. PHP_EOL;
//            $resultMsg .= 'Ветер ('.Utils::windPowerBeaufort($item['wind_speed']).')  -  ' . Utils::windDirectionTranslate($item['wind_direction']) . ', ' . $item['wind_speed'] . ' м/с'. PHP_EOL;

            $resultMsg .=  PHP_EOL;

        }

        $resultMsg .= file_get_contents('app/tpl/menu');

        return $resultMsg;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getData(): array
    {
        if(!$json = $this->httpService->request(getenv('AIRCMS_API_HOST'), ['T'=>0])) {
            throw new Exception('Json is empty');
        }

        $ids = $this->getIds();
        $data = json_decode($json, true);

        if (empty($data['data'])) {
            throw new Exception('Data is not found');
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
        foreach ((new SensorPmObject())->getSensors() as $item) {
            $ids[] = $item['airCmsId'];
        }

        return $ids ?? [];
    }
}