<?php

namespace Base;

abstract class BaseSingletonFactory
{
    final public function __construct()
    {
    }

    final public static function getInstance()
    {
        static $instance = null;
        if (null === $instance)
            $instance = new static();

        return $instance;
    }

    abstract protected function create($name, $date, $time);
}
