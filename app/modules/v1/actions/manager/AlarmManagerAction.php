<?php

namespace app\modules\v1\actions\manager;

use app\modules\v1\core\Action;
use app\services\AirCMSService;
use app\services\AlarmService;
use app\services\ManagerService;

class AlarmManagerAction extends Action
{
    /* @var $alarm AlarmService */
    public $alarm;

    /* @var $manager ManagerService */
    public $manager;

    public function init()
    {
        $this->alarm = new AlarmService(new AirCMSService());
        $this->manager = new ManagerService();
    }

    public function run(): string
    {
        $msg = $this->alarm->getAlarmMessage();

        $this->manager->sendSimpleMessage($msg);

        return '';
    }
}
