<?php

namespace app\core;

use Dotenv\Dotenv;

class Route
{
    public function run()
    {
        $this->init();


    }

    private function init()
    {
        if (file_exists('./.env')) {
            (Dotenv::createUnsafeImmutable('./'))->load();
        }
    }
}