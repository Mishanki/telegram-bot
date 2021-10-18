<?php

namespace app\services;

use app\commands\StartCommand;
use app\network\HTTPService;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;

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

            // Enable admin users
//            $telegram->enableAdmins($config['admins']);

            // Add commands paths containing your custom commands
//            $telegram->addCommandsPaths($config['commands']['paths']);
            $telegram->addCommandClass(StartCommand::class);

            // Requests Limiter (tries to prevent reaching Telegram API limits)
//            $telegram->enableLimiter($config['limiter']);

            // Handle telegram webhook request
            $telegram->handle();

        } catch (TelegramException $e) {
            // Log telegram errors
            TelegramLog::error($e);

            // Uncomment this to output any errors (ONLY FOR DEVELOPMENT!)
            return $e->getMessage();
        } catch (\Throwable $e) {
            // Uncomment this to output log initialisation errors (ONLY FOR DEVELOPMENT!)
            return $e->getMessage();
        }

        return 'Error while hook';
    }
}