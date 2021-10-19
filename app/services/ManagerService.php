<?php

namespace app\services;

use app\commands\StartCommand;
use app\network\HTTPService;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class ManagerService
{
    /* @var $http HTTPService */
    public $http;

    public function __construct()
    {
        $this->http = new HTTPService();
    }

    /**
     * @param string $msg
     * @return false|string
     */
    public function sendSimpleMessage(string $msg = "test")
    {
        return $this->http->sendMessage($msg);
    }

    public function hook()
    {
        try {
            // Create Telegram API object
            $telegram = new Telegram(getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_USER_NAME'));

//            $result = Request::sendMessage([
//                'chat_id' => getenv('TELEGRAM_CHAT_ID'),
//                'text'    => 'Your utf8 text 😜 ...',
//            ]);

            $telegram->addCommandClass(StartCommand::class);

            // Handle telegram webhook request
            $telegram->handle();
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
             echo $e->getMessage();
        }
    }
}