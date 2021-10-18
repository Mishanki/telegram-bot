<?php

namespace app\modules\v1\actions\manager;

use app\modules\v1\core\Action;
use app\services\ManagerService;
use app\services\SensorService;

class HookManagerAction extends Action
{
    /* @var $manager ManagerService */
    public $manager;

    /* @var $sensor SensorService */
    public $sensor;

    public function init()
    {
        $this->manager = new ManagerService();
        $this->sensor = new SensorService();
    }

    public function run(): string
    {
        $msg = $this->sensor->getMessage();

        return $this->manager->sendSimpleMessage($msg);

//        return $this->manager->hook();
    }
}
