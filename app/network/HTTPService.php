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