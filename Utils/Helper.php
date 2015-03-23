<?php

namespace Utils;

abstract class Helper {
    final public static function isValidInt($class, $int)
    {
        if (!is_int($int))
            die("Invalid id in " . $class . ": " . $int);
    }

    final public static function isValidString($class, $string)
    {
        if (!is_string($string))
            die("Invalid string in " . $class .  ": " . $string);
    }

    final public static function isValidDate($class, $date, $format = 'Y-m-d')
    {
        $dt = \DateTime::createFromFormat($format, $date);
        if (!($dt && $dt->format($format) == $date))
            die("Invalid date format in " . $class .  ": " . $date);
    }

    final public static function isValidRuntime($class, $runtime)
    {
        self::isValidDate($class, $runtime, 'H:i');
    }
}