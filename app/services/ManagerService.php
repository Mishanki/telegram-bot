<?php

namespace app\services;

use app\commands\GenericCommand;
use app\commands\HelpCommand;
use app\commands\InfoCommand;
use app\commands\Pm24Command;
use app\commands\PmCommand;
use app\commands\StartCommand;
use app\commands\WeaherCommand;
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

            $telegram->addCommandClass(StartCommand::class);
            $telegram->addCommandClass(PmCommand::class);
            $telegram->addCommandClass(Pm24Command::class);
            $telegram->addCommandClass(WeaherCommand::class);
            $telegram->addCommandClass(GenericCommand::class);
            $telegram->addCommandClass(HelpCommand::class);
            $telegram->addCommandClass(InfoCommand::class);

            $telegram->enableLimiter([
                'enabled' => true,
            ]);

            // Handle telegram webhook request
            $telegram->handle();
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
             echo $e->getMessage();
        }
    }
}