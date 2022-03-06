<?php

namespace App\Helper;

/**
 * Class StringHelper
 * @package App\Helper
 */
class StringHelper
{
    /**
     * Empty str
     * @param mixed $str
     * @return bool
     */
    public static function emptyStr($str): bool
    {
        return is_string($str) && trim($str) === '';
    }
    
    /**
     * Get elem str arr
     * @param  array $arr
     * @param  string $key
     * @return string
     */
    public static function getElemStrArr(array $arr, string $key): string
    {
        $value = "-";
        if (array_key_exists($key, $arr) && is_string($arr[$key]) && !self::emptyStr($arr[$key])) {
            $value = $arr[$key];
        }

        return $value;
    }
}
