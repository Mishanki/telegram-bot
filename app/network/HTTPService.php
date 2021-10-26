<?php

namespace app\network;

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