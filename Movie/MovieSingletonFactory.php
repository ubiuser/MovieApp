<?php

namespace Movie;

set_include_path(get_include_path() . PATH_SEPARATOR . '../');
spl_autoload_extensions('.php');
spl_autoload_register();

use \Base\BaseSingletonFactory;
use Exception;

class MovieSingletonFactory extends BaseSingletonFactory
{
    private static $id = 0;

    public function create($name, $date, $runtime)
    {
        try {
            return new Movie(self::$id++, $name, $date, $runtime);
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }
    }
}
