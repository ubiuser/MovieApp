<?php

namespace Base;

set_include_path(get_include_path() . PATH_SEPARATOR . '../');
spl_autoload_extensions('.php');
spl_autoload_register();

use \Utils\Helper;
use Exception;

abstract class BaseEntity implements \JsonSerializable
{
    protected $id;

    protected function __construct($id)
    {
        try {
            Helper::isValidInt($id);
        } catch (Exception $e) {
            throw new Exception("Error in " . get_called_class() . " object creation; " . $e->getMessage());
        }

        $this->id = $id;
    }

    final public function getId()
    {
        return $this->id;
    }

    final public function getAllJSON()
    {
        return json_encode($this);
    }

    abstract public function jsonSerialize();
}
