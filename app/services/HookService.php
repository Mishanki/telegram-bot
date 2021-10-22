<?php

namespace app\services;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class HookService
{
    /**
     * @return string
     */
    public function setHook(): string
    {
        try {
            // Create Telegram API object
            $telegram = new Telegram(getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_USER_NAME'));

            // Set webhook
            $result = $telegram->setWebhook(getenv('TELEGRAM_HOOK_URL'));
            if ($result->isOk()) {
                return $result->getDescription();
            }
        } catch (TelegramException $e) {
            // log telegram errors
             return $e->getMessage();
        }

        return 'Error while set hook';
    }

    /**
     * @return string
     */
    public function unsetHook(): string
    {
        try {
            // Create Telegram API object
            $telegram = new Telegram(getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_USER_NAME'));

            // Unset / delete the webhook
            $result = $telegram->deleteWebhook();

            return $result->getDescription();
        } catch (TelegramException $e) {
            return $e->getMessage();
        }
    }
}