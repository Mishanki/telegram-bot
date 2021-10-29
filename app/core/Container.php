<?php

namespace app\core;

use app\network\MainHTTP;
use app\network\MainHTTPInterface;
use app\network\MainHTTPService;
use app\network\MainHTTPServiceInterface;
use app\services\AirCMSService;
use app\services\AlarmService;
use app\services\HookService;
use app\services\ManagerService;

class Container
{
    public static function init()
    {
       Bot::$container = self::add();
    }

    private static function add()
    {
        $container = new \League\Container\Container();

        // services
        $container->add(AlarmService::class);
        $container->add(HookService::class);
        $container->add(AirCMSService::class)->addArgument(MainHTTPServiceInterface::class);
        $container->add(ManagerService::class)->addArgument(MainHTTPServiceInterface::class);

        // network
        $container->add(MainHTTPServiceInterface::class, MainHTTPService::class)->addArgument(MainHTTPInterface::class);
        $container->add(MainHTTPInterface::class, MainHTTP::class);

        return $container;
    }
}