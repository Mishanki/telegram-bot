<?php

namespace app\utils;

use app\models\dictionary\ThresholdDictionary;

class Utils
{
    public static function isPm25Alarm24(float $val): bool
    {
        return $val >= ThresholdDictionary::VOZ_PM_25_UPPER_THRESHOLD_24;
    }

    /**
     * @param float $val
     * @return string
     */
    public static function markdownPm25(float $val): string
    {
        if (Utils::isPm25Alarm24($val)) {
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
        if ($val >= ThresholdDictionary::VOZ_PM_10_UPPER_THRESHOLD_24) {
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
            case $val > 0 && $val <= 0.2:
                $name = 'штиль';
                break;
            case $val >= 0.3 && $val <= 1.5:
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
            case $val >= 17.2 && $val <= 20.7:
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

    /**
     * @param string $direction
     * @return string
     */
    public static function windDirectionTranslate(string $direction): string
    {
        switch ($direction)
        {
            case 'n':
                $direction = 'с';
                break;
            case 'e':
                $direction = 'в';
                break;
            case 's':
                $direction = 'ю';
                break;
            case 'w':
                $direction = 'з';
                break;
            case 'sw':
                $direction = 'юз';
                break;
            case 'se':
                $direction = 'юв';
                break;
            case 'nw':
                $direction = 'сз';
                break;
            case 'ne':
                $direction = 'св';
                break;
            default:
                break;
        }

        return mb_strtoupper($direction);
    }
}
