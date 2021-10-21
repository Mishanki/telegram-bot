<?php

namespace app\modules\v1\actions\aircms;

use app\modules\v1\core\Action;
use app\services\AirCMSService;

class GetDevicesAction extends Action
{
    /* @var $service AirCMSService */
    public $service;

    public function init()
    {
        $this->service = new AirCMSService();
    }

    /**
     * @return array
     */
    public function run(): array
    {
        return $this->service->getDevices();
    }
}
