<?php

namespace app\core;

use Dotenv\Dotenv;

class Route
{
    public function run()
    {
        $this->init();

        echo getenv('TELEGRAM_CHAT_ID');
    }

    private function init()
    {
        if (file_exists('.env')) {
            (Dotenv::createUnsafeImmutable(dirname(__DIR__, 2)))->load();
        }
    }
}