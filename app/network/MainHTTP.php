<?php

namespace app\network;

class MainHTTP implements MainHTTPInterface
{
    /**
     * @param string $msg
     * @param string $chatId
     * @return false|string
     */
    public function sendMessage(string $msg, string $chatId)
    {
        return $this->send(['chat_id' => $chatId, 'text' => $msg, 'parse_mode' => 'markdown']);
    }

    /**
     * @param string $host
     * @param array|null $data
     * @return false|string
     */
    public function getDataFromUrl(string $host, ?array $data = null)
    {
        return file_get_contents(
            $host,
            false,
            stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ],
            ])
        );
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function send(array $data)
    {
        return file_get_contents($this->getBotWithToken().'?'.http_build_query($data), false,
            stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ],
            ])
        );
    }

    /**
     * @return string
     */
    public function getBotWithToken(): string
    {
        return str_replace('<token>', getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_BOT_URL'));
    }
}