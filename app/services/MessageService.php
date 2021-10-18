<?php

namespace app\services;

use Longman\TelegramBot\Request;

class MessageService
{
    public function sendMessage(): string
    {
        $result = Request::sendMessage([
            'chat_id' => getenv('TELEGRAM_CHAT_ID'),
            'text'    => 'Your utf8 text 😜 ...',
        ]);

        return '';
    }
}