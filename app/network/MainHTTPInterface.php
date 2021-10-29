<?php

namespace app\network;

interface MainHTTPInterface
{
    public function sendMessage(string $msg, string $chatId);

    public function getDataFromUrl(string $host, ?array $data = null);
}