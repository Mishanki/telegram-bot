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

            try {
                $msg = $service->getAlarmMessage();
            } catch (\Throwable $e) {
                $msg = null;
                echo PHP_EOL . '['. date('Y-m-d H:i:s') . '] ' . $e->getMessage() . PHP_EOL;
            }

            if($msg) {
                $manager->sendSimpleMessageByChatId($msg, getenv('TELEGRAM_INFO_CHANNEL_ID'));
                echo '+';
            } else {
                echo '.';
            }

            sleep(300);
        }
    }
}
