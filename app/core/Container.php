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
use app\services\MessageService;
use app\services\SensorBaseService;
use app\services\SensorPm1Service;
use app\services\SensorPm24Service;
use app\services\SensorService;

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
        $container->add(SensorService::class)->addArgument(MainHTTPServiceInterface::class);
        $container->add(SensorPm1Service::class)->addArgument(MainHTTPServiceInterface::class);
        $container->add(SensorPm24Service::class)->addArgument(MainHTTPServiceInterface::class);
        $container->add(AirCMSService::class)->addArgument(MainHTTPServiceInterface::class);
        $container->add(MessageService::class)->addArgument(MainHTTPServiceInterface::class);
        $container->add(ManagerService::class);

        // network
        $container->add(MainHTTPServiceInterface::class, MainHTTPService::class)->addArgument(MainHTTPInterface::class);
        $container->add(MainHTTPInterface::class, MainHTTP::class);

        return $container;
    }
}