<?php

namespace app\modules\v1\actions\manager;

use app\modules\v1\core\Action;
use app\services\ManagerService;

class HookManagerAction extends Action
{
    /* @var $manager ManagerService */
    public $manager;

    public function init()
    {
        $this->manager = new ManagerService();
    }

    public function run(): bool
    {
        $this->manager->hook();

        return true;
    }
}
