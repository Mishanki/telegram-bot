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
        $msg = file_get_contents('php://input');
        $msg = json_decode($msg, true);

        $data['last_name'] = $msg['message']['from']['last_name'] ?? null;
        $data['first_name'] = $msg['message']['from']['first_name'] ?? null;
        $data['username'] = $msg['message']['from']['username'] ?? null;
        $data['text'] = $msg['message']['text'] ?? null;
        $data = json_encode($data, JSON_PRETTY_PRINT);

        $this->manager->sendSimpleMessage($data);

        $this->manager->hook();

//        $data = $this->sensor->getMessage();

        return '';
    }
}
