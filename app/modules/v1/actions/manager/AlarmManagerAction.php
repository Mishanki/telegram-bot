<?php

namespace app\modules\v1\actions\manager;

use app\core\Bot;
use app\modules\v1\core\Action;
use app\services\AirCMSService;
use app\services\AlarmService;
use app\services\ManagerService;

class AlarmManagerAction extends Action
{
    /* @var $alarmService AlarmService */
    public $alarmService;

    /* @var $manageService ManagerService */
    public $manageService;

    /* @var $airCmsService AirCMSService */
    public $airCmsService;

    public function init(): void
    {
        $this->alarmService = Bot::$container->get(AlarmService::class);
        $this->manageService = Bot::$container->get(ManagerService::class);
        $this->airCmsService = Bot::$container->get(AirCMSService::class);
    }

    public function run(): bool
    {
        try {
            if($msg = $this->alarmService->getAlarmMessage($this->airCmsService->getData())) {
                $this->manageService->sendSimpleMessageByChatId($msg, getenv('TELEGRAM_INFO_CHANNEL_ID'));
                echo '+';
            }
        } catch (\Throwable $e) {
            echo PHP_EOL . '['. date('Y-m-d H:i:s') . '] ' . $e->getMessage() . PHP_EOL;
        }

        return true;
    }
}
