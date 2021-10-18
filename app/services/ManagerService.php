<?php

namespace app\services;

use app\network\HTTPService;
use Longman\TelegramBot\Request;

class ManagerService
{
    /* @var $http HTTPService */
    public $http;

    public function __construct()
    {
        $this->http = new HTTPService();
    }

    public function sendSimpleMessage(string $msg = "test")
    {
        return $this->http->sendMessage($msg);
    }
}