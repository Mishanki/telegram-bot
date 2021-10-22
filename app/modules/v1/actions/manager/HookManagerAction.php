<?php

namespace app\modules\v1\actions\manager;

use app\modules\v1\core\Action;
use app\services\AirCMSService;
use app\services\ManagerService;
use app\services\SensorService;
use app\services\SensorPm24Service;

class HookManagerAction extends Action
{
    /* @var $manager ManagerService */
    public $manager;

    public function init()
    {
        $this->manager = new ManagerService();
    }

    public function run(): string
    {
        $msg = file_get_contents('php://input');
        $msg = json_decode($msg, true);
        $msg = json_encode($msg, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        $this->manager->sendSimpleMessage($msg);
        $this->manager->hook();

//        $data = (new SensorService())->getMessage();
//        $data = (new AirCMSService())->getMessage();
//        $this->manager->sendSimpleMessage($data);
//        echo $data;

        return '';
    }
}
