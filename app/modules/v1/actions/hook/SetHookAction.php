<?php

namespace app\modules\v1\actions\hook;

use app\core\Bot;
use app\modules\v1\core\Action;
use app\services\HookService;

class SetHookAction extends Action
{
    /* @var $service HookService */
    public $service;

    public function init()
    {
        $this->service = Bot::$container->get(HookService::class);
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->service->setHook();
    }
}
