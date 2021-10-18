<?php

namespace app\modules\v1\controllers;

use app\modules\v1\actions\manager\HookManagerAction;
use app\modules\v1\core\ApiController;

class ManagerController extends ApiController
{
    public function actions(): array
    {
        return [
            'hook' => [
                'class' => HookManagerAction::class
            ]
        ];
    }

}