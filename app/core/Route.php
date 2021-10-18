<?php

namespace app\core;

use Dotenv\Dotenv;

class Route
{
    public function run()
    {
        echo '<pre>';
        print_r($_ENV);
        echo '</pre>';

        $this->init();

        echo getenv('TELEGRAM_CHAT_ID');
    }

    private function init()
    {
        var_dump(dirname(__DIR__, 2))
        (Dotenv::createUnsafeImmutable(dirname(__DIR__, 2)))->load();
    }
}