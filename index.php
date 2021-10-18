<?php

use app\core\Route;

require_once 'vendor/autoload.php';

try {
    (new Route())->run();
} catch (\Throwable $e) {
    echo $e->getMessage();
}
