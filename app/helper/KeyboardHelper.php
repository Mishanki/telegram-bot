<?php

namespace app\helper;

class KeyboardHelper
{
    public static function getKeyboard(): string
    {
        return json_encode([
            "keyboard" => [
                [
                    ["text" => "/pm"],
                    ["text" => "/pm1"],
                    ["text" => "/pm24"],
                    ["text" => "/weather"],
                    ["text" => "/info"],
                ]
            ],
            "one_time_keyboard" => false,
            "resize_keyboard" => true
        ]);
    }
}
