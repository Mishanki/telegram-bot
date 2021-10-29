<?php

namespace app\modules\v1\actions\manager;

use app\core\Bot;
use app\modules\v1\core\Action;
use app\services\ManagerService;

class HookManagerAction extends Action
{
    /* @var $manager ManagerService */
    public $manager;

    public function init()
    {
        $this->manager = Bot::$container->get(ManagerService::class);
    }

    public function run(): bool
    {
        $this->manager->hook();

        return true;
    }
}
