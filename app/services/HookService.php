<?php

namespace app\services;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class HookService
{
    public function setHook(): string
    {
        try {
            // Create Telegram API object
            $telegram = new Telegram(getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_USER_NAME'));

            // Set webhook
            $result = $telegram->setWebhook(getenv('TELEGRAM_HOOK_URL'));
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            // log telegram errors
             echo $e->getMessage();
        }

        return 'string';
    }
}