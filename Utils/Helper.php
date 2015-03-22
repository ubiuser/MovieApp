<?php

namespace Utils;

abstract class Helper {
    public final static function isValidInt($class, $int)
    {
        if (!is_int($int)) die("Invalid id in " . $class . ": " . $int);
    }

    public final static function isValidString($class, $string)
    {
        if (!is_string($string)) die("Invalid string in " . $class .  ": " . $string);
    }

    public final static function isValidDate($class, $date, $format = 'Y-m-d')
    {
        $dt = \DateTime::createFromFormat($format, $date);
        if (!($dt && $dt->format($format) == $date)) die("Invalid date format in " . $class .  ": " . $date);
    }

    public final static function isValidRuntime($class, $runtime)
    {
        self::isValidDate($class, $runtime, 'H:i');
    }
}