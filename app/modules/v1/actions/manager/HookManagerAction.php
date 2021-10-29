<?php

namespace app\modules\v1\actions\manager;

use app\core\Bot;
use app\modules\v1\core\Action;
use app\services\ManagerService;
use app\services\MessageService;

class HookManagerAction extends Action
{
    /* @var $manager ManagerService */
    public $manager;

    public function init()
    {
        $this->manager = Bot::$container->get(ManagerService::class);
    }

    public function run(): bool
    {
        $msg = file_get_contents('php://input');
        $msg = json_decode($msg, true);
        $msg = json_encode($msg, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        /* @var $message MessageService */
        $message = Bot::$container->get(MessageService::class);
        $message->sendMessageByChatId($msg);

        $this->manager->hook();

        return true;
    }
}
