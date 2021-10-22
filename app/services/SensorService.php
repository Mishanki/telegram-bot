<?php

namespace app\services;

use app\models\dictionary\MeasurementDictionary as MD;
use Exception;

class SensorService extends SensorBaseService
{
    /* @var $cacheFile string */
    private $cacheFile = './cache.json';
    /* @var $cacheExp int */
    private $cacheExp = 45;
    /* @var $header $string */
    private $header = 'Средняя концентрация взвешенных частиц PM 2.5 '.MD::MEASUREMENT_PM_RU.' за последние 5 минут';
    /**
     * @return string
     */
    public function getCacheFile(): string
    {
        return $this->cacheFile;
    }

    /**
     * @return int
     */
    public function getCacheExp(): int
    {
        return time() - $this->cacheExp;
    }

    /**
     * @return mixed
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getMessage(): string
    {
        if($data = $this->getCacheMessageData($this->getCacheFile(), $this->getCacheExp())) {
            return $this->formatter($data, $this->getHeader());
        }

        $data = $this->getData(getenv('SENSOR_COMMUNITY_HOST'));
        if (empty($data['data'])) {
            return 'Data is not found';
        }
        $this->setCacheMessageData($this->getCacheFile(), $data);

        return $this->formatter($data, $this->getHeader());
    }
}