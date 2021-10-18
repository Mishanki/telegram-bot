<?php

namespace app\modules\v1\actions\hook;

use app\modules\v1\core\Action;
use app\services\HookService;

class UnsetHookAction extends Action
{
    /* @var $service HookService */
    public $service;

    public function init()
    {
        $this->service = new HookService();
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->service->unsetHook();
    }
}
