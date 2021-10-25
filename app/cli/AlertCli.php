<?php

namespace app\cli;

use app\services\AirCMSService;
use app\services\AlarmService;
use app\services\ManagerService;

class AlertCli
{
    public function run()
    {
        while (true) {
            $service = new AlarmService(new AirCMSService());
            $manager = new ManagerService();

            if($msg = $service->getAlarmMessage()) {
                $manager->sendSimpleMessage($msg);
                echo '+';
            } else {
                echo '.';
            }

            sleep(180);
        }
    }
}
