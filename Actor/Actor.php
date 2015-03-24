<?php

namespace Actor;

set_include_path(get_include_path() . PATH_SEPARATOR . '../');
spl_autoload_extensions('.php');
spl_autoload_register();

use \Utils\Helper;
use \Base\BaseEntity;
use Exception;

class Actor extends BaseEntity
{
    private $name;
    private $birthday;

    public function __construct($id, $name, $birthday)
    {
        parent::__construct($id);

        try {
            Helper::isValidString($name);
            Helper::isValidDate($birthday);
        } catch (Exception $e) {
            throw new Exception("Error in " . __CLASS__ . " object creation; " . $e->getMessage());
        }

        $this->name = $name;
        $this->birthday = new \DateTime($birthday);

        if (Helper::getAge($this->getBirthday()) <= 0)
            throw new Exception("Error in " . __CLASS__ . "; Actor must be older than 0 year!", 1);
    }

    public function getBirthday()
    {
        if (!is_null($this->birthday))
            return Helper::getFormattedDate($this->birthday);
        else
            return null;
    }

    public function setBirthday($year, $month, $day)
    {
        try {
            Helper::isValidInt($year);
            Helper::isValidInt($month);
            Helper::isValidInt($day);
            $age = Helper::getAge((string)$year . "-" . (string)$month . "-" . (string)$day);
            if ($age > 0)
                $this->birthday->setDate($year, $month, $day);
            else
                throw new Exception("Actor must be older than 0 years!", 1);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        try {
            Helper::isValidString($name);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }

        $this->name = $name;
    }

    public function clear()
    {
        $this->name = null;
        $this->birthday = null;
    }

    public function jsonSerialize()
    {
        return ['id' => $this->id, 'name' => $this->name, 'birthday' => $this->getBirthday()];
    }
}
