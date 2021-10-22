<?php

namespace app\services;

use app\models\dictionary\MeasurementDictionary as MD;

class SensorPm1Service extends SensorBaseService
{
    /* @var $cacheFile string */
    private $cacheFile = './cache1.json';
    /* @var $cacheExp int */
    private $cacheExp = 45;
    /* @var $header $string */
    private $header = 'Средняя концентрация взвешенных частиц PM 2.5 '.MD::MEASUREMENT_PM_RU.' за последний час';
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

    public function getMessage(): string
    {
        return $this->getMsg(getenv('SENSOR_COMMUNITY_HOST_HISTORY_1H'));
    }
}