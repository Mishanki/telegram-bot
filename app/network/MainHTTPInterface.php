<?php

namespace app\network;

interface MainHTTPInterface
{
    public function sendMessage(string $msg, string $chatId);

    public function send(array $data);

    public function getDataFromUrl(string $host, ?array $data = null);

    public function getBotWithToken(): string;
}