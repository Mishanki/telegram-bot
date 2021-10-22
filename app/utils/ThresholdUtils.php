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

    /**
     * @param float $val
     * @return string
     */
    public static function windPowerBeaufort(float $val): string
    {
        switch ($val) {
            case $val == 0:
                $name = 'штиль';
                break;
            case $val > 0 && $val < 1.6:
                $name = 'тихий';
                break;
            case $val >= 1.6 && $val <= 3.3:
                $name = 'легкий';
                break;
            case $val >= 3.4 && $val <= 5.4:
                $name = 'слабый';
                break;
            case $val >= 5.5 && $val <= 7.9:
                $name = 'умеренный';
                break;
            case $val >= 8 && $val <= 10.7:
                $name = 'свежий';
                break;
            case $val >= 10.8 && $val <= 13.8:
                $name = 'сильный';
                break;
            case $val >= 13.9 && $val <= 17.1:
                $name = 'крепкий';
                break;
            case $val >= 17.2 && $val <= 20:
                $name = 'очень крепкий';
                break;
            case $val >= 20.8 && $val <= 24.4:
                $name = 'шторм';
                break;
            case $val >= 24.5 && $val <= 28.4:
                $name = 'сильный шторм';
                break;
            case $val >= 28.5 && $val <= 32.6:
                $name = 'жестокий шторм';
                break;
            case $val > 32.6:
                $name = 'ураган';
                break;
        }

        return $name;
    }

}
