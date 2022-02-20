<?php

namespace App\Helper;

/**
 * Class DateHelper
 * @package App\Helper
 */
class DateHelper
{
    const PHP_STANDARD_FORMAT = "d.m.Y H:i:s";
    const DATE_TIME_ZONE = "Europe/Minsk";

    /**
     * Method parses int|string and returns DateTime object or FALSE in the case of unsupported data
     * @param int|string $value
     * @return \DateTime|bool
     */
    public static function parseFromInt($value)
    {
        try {
            $date = date(self::PHP_STANDARD_FORMAT, $value);
            $date = \DateTime::createFromFormat(
                self::PHP_STANDARD_FORMAT,
                $date
            );
            $date->setTimezone(new \DateTimeZone(self::DATE_TIME_ZONE));
            $result = $date;
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}
