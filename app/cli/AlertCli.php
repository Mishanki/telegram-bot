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
                $manager->sendSimpleMessageByChatId($msg, getenv('TELEGRAM_INFO_CHANNEL_ID'));
                echo '+';
            } else {
                echo '.';
            }

            sleep(180);
        }
    }
}
