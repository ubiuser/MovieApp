<?php

namespace Utils;

set_include_path(get_include_path() . PATH_SEPARATOR . '../');
spl_autoload_extensions('.php');
spl_autoload_register();

use Exception;

abstract class Helper {
    final public static function isValidInt($int)
    {
        if (!is_int($int))
            throw new Exception("Invalid integer: " . $int, 1);
    }

    final public static function isValidString($string)
    {
        if (!is_string($string))
            throw new Exception("Invalid string: " . $string, 1);
    }

    final public static function isValidRuntime($runtime)
    {
        self::isValidDate($runtime, 'H:i');
    }

    final public static function isValidDate($date, $format = 'Y-m-d')
    {
        $dt = \DateTime::createFromFormat($format, $date);
        if (!($dt && $dt->format($format) == $date))
            throw new Exception("Invalid date / format: " . $date . " / " . $format, 1);
    }

    final public static function getFormattedDate(\DateTime $dt)
    {
        return $dt->format('Y-m-d');
    }

    final public static function getFormattedTime(\DateTime $dt)
    {
        return $dt->format('H:i');
    }

    final public static function getAge($dateString)
    {
        try {
            if (!is_null($dateString))
                self::isValidDate($dateString);
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }

        $now = new \DateTime();
        $then = new \DateTime($dateString);

        return (int)$then->diff($now)->format('%r%Y');
    }
}