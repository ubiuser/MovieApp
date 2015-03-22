<?php

namespace Base;

abstract class BaseSingletonFactory
{
    public final static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }

    public final function __construct() { }

    protected abstract function create($name, $date, $time);
}
