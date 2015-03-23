<?php

namespace Base;

abstract class BaseSingletonFactory
{
    final public static function getInstance()
    {
        static $instance = null;
        if (null === $instance)
            $instance = new static();

        return $instance;
    }

    final public function __construct()
    {
    }

    abstract protected function create($name, $date, $time);
}
