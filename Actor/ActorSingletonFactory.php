<?php

namespace Actor;

include_once '\Base\BaseSingletonFactory.php';
include_once 'Actor.php';

use Base\BaseSingletonFactory;

class ActorSingletonFactory extends BaseSingletonFactory
{
    private static $id = 0;
    public function create($name, $birthday, $arg3 = null)
    {
        return new Actor(self::$id++, $name, $birthday);
    }
}
