<?php

namespace app\modules\v1\actions\hook;

use app\modules\v1\core\Action;
use app\services\HookService;
use app\services\MessageService;

class HookAction extends Action
{
    /* @var $service HookService */
    public $service;

    /* @var $message MessageService */
    public $message;

    public function init()
    {
        $this->service = new HookService();
        $this->message = new MessageService();
    }

    public function run(): bool
    {
        $url = 'https://api.telegram.org/bot'.getenv('TELEGRAM_BOT_TOKEN').'/sendMessage?chat_id='.getenv('TELEGRAM_CHAT_ID').'&text=Hello';

        return file_get_contents($url);
    }
}
