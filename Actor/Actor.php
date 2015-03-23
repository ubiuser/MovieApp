<?php

namespace Actor;

include_once '\Utils\Helper.php';
include_once '\Base\BaseEntity.php';

use Utils\Helper;
use Base\BaseEntity;

class Actor extends BaseEntity
{
    private $name;
    private $birthday;

    public function __construct($id, $name, $birthday)
    {
        parent::__construct($id);

        Helper::isValidString(__CLASS__, $name);
        Helper::isValidDate(__CLASS__, $birthday);

        $this->name = $name;
        $this->birthday = $birthday;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getAll()
    {
        return $this->_getAll(get_object_vars($this));
    }
}
