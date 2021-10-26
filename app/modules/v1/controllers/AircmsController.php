<?php

namespace app\modules\v1\controllers;

use app\modules\v1\actions\aircms\GetCurrentValuesAction;
use app\modules\v1\core\ApiController;

class AircmsController extends ApiController
{
    public function actions(): array
    {
        return [
            'current-values' => [
                'class' => GetCurrentValuesAction::class,
            ]
        ];
    }

}