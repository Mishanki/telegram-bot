<?php

namespace app\cli;

use app\core\Container;
use Dotenv\Dotenv;
use Exception;

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

date_default_timezone_set('Europe/Moscow');

if (file_exists('./.env')) {
    (Dotenv::createUnsafeImmutable('./'))->load();
}

Container::init();

if (count($argv) !== 3) {
    throw new Exception('Cli error');
}

$class = __NAMESPACE__.'\\'.$argv[1];
$obj = new $class();
$obj->{$argv[2]}();

// php app/cli/cli.php AlertCli run
