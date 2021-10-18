<?php

namespace app\modules\v1\actions\hook;

use app\modules\v1\core\Action;
use app\services\HookService;

class HookAction extends Action
{
    /* @var $service HookService */
    public $service;

    public function init()
    {
        $this->service = new HookService();
    }

    public function run(): string
    {
        return 'hooker';
    }
}
