<?php

namespace Base;

include_once '\Utils\Helper.php';
use Utils\Helper;

abstract class BaseEntity
{
    protected $id;

    protected function __construct($id)
    {
        Helper::isValidInt(get_called_class(), $id);

        $this->id = $id;
    }

    public final function getId() { return $this->id; }

    protected abstract function getAll();
    protected final function _getAll($objVars)
    {
        $valueArray = array();
        foreach ($objVars as $var => $value)
        {
            $valueArray[$var] = $value;
        }

        return json_encode($valueArray, JSON_PRETTY_PRINT);
    }
}
