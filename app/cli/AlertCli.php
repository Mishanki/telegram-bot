<?php

namespace app\cli;

use app\core\Bot;
use app\services\AirCMSService;
use app\services\AlarmService;
use app\services\MessageService;

class AlertCli
{
    /* @var $alarmService AlarmService */
    public $alarmService;

    /* @var $messageService MessageService */
    public $messageService;

    /* @var $airCmsService AirCMSService */
    public $airCmsService;

    public function init(): void
    {
        $this->alarmService = Bot::$container->get(AlarmService::class);
        $this->messageService = Bot::$container->get(MessageService::class);
        $this->airCmsService = Bot::$container->get(AirCMSService::class);
    }

    public function run()
    {
        $this->init();
        while (true) {
            try {
                if($msg = $this->alarmService->getAlarmMessage($this->airCmsService->getData())) {
                    $this->messageService->sendMessageByChatId($msg, getenv('TELEGRAM_INFO_CHANNEL_ID'));
                    echo '+';
                }
            } catch (\Throwable $e) {
                echo PHP_EOL . '['. date('Y-m-d H:i:s') . '] ' . $e->getMessage() . PHP_EOL;
            }

            sleep(300);
        }
    }
}
