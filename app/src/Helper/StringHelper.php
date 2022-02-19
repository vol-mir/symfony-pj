<?php

namespace App\Helper;

/**
 * Class StringHelper
 * @package App\Helper
 */
class StringHelper
{
    /**
     * @param string $str
     * @return bool
     */
    public static function emptyStr(string $str): bool
    {
        return is_string($str) && strlen(trim($str)) === 0;
    }
}
