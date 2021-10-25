<?php

namespace app\services;

use app\models\dictionary\MeasurementDictionary;
use app\services\objects\SensorPmObject;
use app\utils\ThresholdUtils;
use DateTimeZone;
use Exception;

class SensorBaseService
{
    /**
     * @param string $host
     * @return string
     * @throws Exception
     */
    public function getMsg(string $host): string
    {
        if($data = $this->getCacheMessageData($this->getCacheFile(), $this->getCacheExp())) {
            return $this->formatter($data, $this->getHeader());
        }

        $data = $this->getData($host);
        if (empty($data['data'])) {
            return 'Data is not found';
        }
        $this->setCacheMessageData($this->getCacheFile(), $data);

        return $this->formatter($data, $this->getHeader());
    }
    /**
     * @param string $cacheFile
     * @param int $exp
     * @return array|null
     */
    public function getCacheMessageData(string $cacheFile, int $exp): ?array
    {
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile),true);
            if ($data['time'] > $exp && !empty($data['data'])) {
                return $data;
            }
        }

        return null;
    }

    /**
     * @param string $cacheFile
     * @param array $data
     * @return bool
     */
    public function setCacheMessageData(string $cacheFile, array $data): bool
    {
        return file_put_contents($cacheFile, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @param string $host
     * @return array
     * @throws Exception
     */
    public function getData(string $host): array
    {
        if(!$json = file_get_contents($host)) {
            throw new Exception('Json is empty');
        }

        $ids = $this->getIds();
        $data = json_decode($json, true);
        $result = [];
        foreach ($data as $item) {
            $id = $item['sensor']['id'] ?? null;
            if (!$id) {
                continue;
            }
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
     * @param array $data
     * @param string $header
     * @return string
     * @throws Exception
     */
    public function formatter(array $data, string $header): string
    {
        $msg[0] = $header;

        foreach ($data['data'] as $senId => $items) {
            foreach ($items as $time => $v) {
                foreach ((new SensorPmObject())->getSensors() as $num => $sensor) {
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

                if (empty($tmp) || !empty($tmp) && $tmp != $item['str']) {
                    $tmp = $item['str'];
                    $result .= '*'. $item['str'].'*' ;
                }

                $dateObj = new \DateTime($time.'UTC');
                $dateObj->setTimezone(new DateTimeZone('Europe/Moscow'));
                $result .=  '  -  ' . ThresholdUtils::markdownPm25($item['value']) . ' ' . MeasurementDictionary::MEASUREMENT_PM_RU . PHP_EOL;
            }
            $result .= PHP_EOL;
        }

        $result .= file_get_contents('app/tpl/footer');

        return $result;
    }

    /**
     * @return array
     */
    private function getIds(): array
    {
        foreach ((new SensorPmObject())->getSensors() as $item) {
            $ids[] = $item['sid'];
        }

        return $ids ?? [];
    }
}