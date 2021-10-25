<?php

namespace app\network;

use Longman\TelegramBot\Entities\Keyboard;

class HTTPService
{
    /**
     * @param string $msg
     * @return false|string
     */
    public function sendMessage(string $msg)
    {
        return file_get_contents($this->getBotWithToken().'?'.http_build_query([
            'chat_id' => getenv('TELEGRAM_CHAT_ID'),
            'text' => $msg,
            'parse_mode' => 'markdown',
        ]));


    }

    private function getInlineKeyboard(): string
    {
        return json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'pm', 'callback_data' => 'pm'],
                    ['text' => 'pm1', 'callback_data' => 'pm1'],
                    ['text' => 'pm24', 'callback_data' => 'pm24'],
                    ['text' => 'weather', 'callback_data' => 'weather'],
                ]
            ]
        ]);
    }

    private function getReplyKeyboard(): string
    {
        return json_encode([
            "keyboard" => [
                [
                    ["text" => "/pm"],
                    ["text" => "/pm1"],
                    ["text" => "/pm24"],
                    ["text" => "/weather"],
                    ["text" => "/info"],
                ]
            ],
            "one_time_keyboard" => false,
            "resize_keyboard" => true
        ]);
    }

    /**
     * @param string $msg
     * @param string $chatId
     * @return false|string
     */
    public function sendMessageChatId(string $msg, string $chatId)
    {
        return file_get_contents($this->getBotWithToken().'?'.http_build_query([
                'chat_id' => $chatId,
                'text' => $msg,
                'parse_mode' => 'markdown',
            ]));
    }

    /**
     * @return string
     */
    private function getBotWithToken(): string
    {
        return str_replace('<token>', getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_BOT_URL'));
    }

}