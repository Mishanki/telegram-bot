<?php

namespace app\network;

class MainHTTPService implements MainHTTPServiceInterface
{
    /* @var $mainHTTP MainHTTPInterface */
    public $mainHTTP;

    /**
     * MainHTTPService constructor.
     * @param MainHTTPInterface $mainHTTP
     */
    public function __construct(MainHTTPInterface $mainHTTP)
    {
        $this->mainHTTP = $mainHTTP;
    }

    /**
     * @param string $host
     * @param array|null $data
     * @return mixed
     */
    public function request(string $host, ?array $data = null)
    {
        return $this->mainHTTP->getDataFromUrl($host);
    }

    /**
     * @param string $msg
     * @param string|null $chatId
     * @return mixed
     */
    public function sendMessageToChat(string $msg, ?string $chatId = null)
    {
        if(!$chatId) {
            $chatId = getenv('TELEGRAM_CHAT_ID');
        }

        return $this->mainHTTP->sendMessage($msg, $chatId);
    }
}