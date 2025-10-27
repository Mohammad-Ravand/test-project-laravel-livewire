<?php

namespace App\Helpers;

class PersianHelper
{
    private static $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    private static $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    public static function toPersianNumbers($string)
    {
        return str_replace(self::$englishNumbers, self::$persianNumbers, $string);
    }

    public static function toEnglishNumbers($string)
    {
        return str_replace(self::$persianNumbers, self::$englishNumbers, $string);
    }

    public static function convertPersianDate($persianDate)
    {
        // Convert Persian numbers to English
        $englishDate = self::toEnglishNumbers($persianDate);

        // Basic validation format YYYY/MM/DD
        if (!preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $englishDate)) {
            throw new \InvalidArgumentException('Invalid Persian date format. Expected: YYYY/MM/DD');
        }

        return $englishDate;
    }

    public static function convertPersianTime($persianTime)
    {
        // Convert Persian numbers to English
        $englishTime = self::toEnglishNumbers($persianTime);

        // Basic validation format HH:MM
        if (!preg_match('/^\d{2}:\d{2}$/', $englishTime)) {
            throw new \InvalidArgumentException('Invalid Persian time format. Expected: HH:MM');
        }

        // Validate hour and minute ranges
        list($hour, $minute) = explode(':', $englishTime);
        if ($hour > 23 || $minute > 59) {
            throw new \InvalidArgumentException('Invalid time values. Hour should be 0-23, minute should be 0-59');
        }

        return $englishTime;
    }
}
