<?php

namespace Actor;

set_include_path(get_include_path() . PATH_SEPARATOR . '../');
spl_autoload_extensions('.php');
spl_autoload_register();

use \Base\BaseSingletonFactory;
use Exception;

class ActorSingletonFactory extends BaseSingletonFactory
{
    private static $id = 0;

    public function create($name, $birthday, $arg3 = null)
    {
        try {
            return new Actor(self::$id++, $name, $birthday);
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }
    }
}
