<?php

namespace app\utils;

class ThresholdUtils
{
    /**
     * @param float $val
     * @return string
     */
    public static function markdownPm25(float $val): string
    {
        if ($val >= 25) {
            $val = '*'.$val.'*';
        }

        return $val;
    }

     /**
     * @param float $val
     * @return string
     */
    public static function markdownPm10(float $val): string
    {
        if ($val >= 50) {
            $val = '*'.$val.'*';
        }

        return $val;
    }

}
