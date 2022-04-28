<?php

namespace app\services;

use app\commands\GenericCommand;
use app\commands\InfoCommand;
use app\commands\Pm1Command;
use app\commands\Pm24Command;
use app\commands\PmCommand;
use app\commands\StartCommand;
use app\commands\WeatherCommand;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class ManagerService
{
    public function hook()
    {
        try {
            $telegram = new Telegram(getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_USER_NAME'));

            $telegram->addCommandClass(StartCommand::class);
            $telegram->addCommandClass(PmCommand::class);
            $telegram->addCommandClass(Pm1Command::class);
            $telegram->addCommandClass(Pm24Command::class);
            $telegram->addCommandClass(WeatherCommand::class);
            $telegram->addCommandClass(GenericCommand::class);
            $telegram->addCommandClass(InfoCommand::class);

            $telegram->enableLimiter([
                'enabled' => true,
            ]);

            $telegram->handle();
        } catch (TelegramException $e) {
             echo $e->getMessage();
        }
    }
}