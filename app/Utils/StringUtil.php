<?php

namespace App\Utils;

class StringUtil
{
    /**
     * @param $string
     *
     * @return string
     */
    public static function sanitize($string)
    {
        return escapeshellcmd($string);
    }
}
