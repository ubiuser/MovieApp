<?php

namespace Movie;

include_once '\Base\BaseSingletonFactory.php';
include_once 'Movie.php';

use Base\BaseSingletonFactory;

class MovieSingletonFactory extends BaseSingletonFactory
{
    private static $id = 0;

    public function create($name, $date, $runtime)
    {
        return new Movie(self::$id++, $name, $date, $runtime);
    }
}
