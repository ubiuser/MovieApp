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

    final public function getId() { return $this->id; }

    abstract protected function getAll();
    final protected function _getAll($objVars)
    {
        $valueArray = array();
        foreach ($objVars as $var => $value)
            $valueArray[$var] = $value;

        return json_encode($valueArray, JSON_PRETTY_PRINT);
    }
}
