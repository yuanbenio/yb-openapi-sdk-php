<?php
namespace Yuanben;

class Util {

    public static function toCamel($value)
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));
        $string = str_replace(' ', '', $value);

        return lcfirst($string);
    }
}
