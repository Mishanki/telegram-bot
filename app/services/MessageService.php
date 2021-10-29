<?php

namespace app\services;

use app\network\MainHTTPServiceInterface;

class MessageService
{
    /* @var $httpService MainHTTPServiceInterface */
    public $httpService;

    /**
     * ManagerService constructor.
     * @param MainHTTPServiceInterface $httpService
     */
    public function __construct(MainHTTPServiceInterface $httpService)
    {
        $this->httpService = $httpService;
    }

    /**
     * @param string $msg
     * @param string|null $chatId
     * @return mixed
     */
    public function sendMessageByChatId(string $msg, ?string $chatId = null)
    {
        return $this->httpService->sendMessageToChat($msg, $chatId);
    }
}
