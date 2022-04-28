<?php

namespace app\network;

interface MainHTTPServiceInterface
{
    public function request(string $host, ?array $data = null);

    public function sendMessageToChat(string $msg, ?string $chatId = null);
}