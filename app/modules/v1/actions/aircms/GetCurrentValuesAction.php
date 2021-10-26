<?php

namespace app\modules\v1\actions\aircms;

use app\modules\v1\core\Action;
use app\services\AirCMSService;
use Exception;

class GetCurrentValuesAction extends Action
{
    /* @var $service AirCMSService */
    public $service;

    public function init()
    {
        $this->service = new AirCMSService();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return $this->service->getMessage();
    }
}
