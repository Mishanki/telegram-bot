<?php

namespace app\modules\v1\controllers;

use app\modules\v1\actions\hook\SetHookAction;
use app\modules\v1\actions\hook\UnsetHookAction;
use app\modules\v1\actions\manager\HookManagerAction;
use app\modules\v1\core\ApiController;

class HookController extends ApiController
{
    public function actions(): array
    {
        return [
            'set' => [
                'class' => SetHookAction::class,
            ],
            'unset' => [
                'class' => UnsetHookAction::class,
            ],
            'manager' => [
                'class' => HookManagerAction::class
            ]
        ];
    }

}