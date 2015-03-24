<?php

namespace Actor;

set_include_path(get_include_path() . PATH_SEPARATOR . '../');
spl_autoload_extensions('.php');
spl_autoload_register();

use \Utils\Helper;
use Exception;

class ActorDB
{
    private $list = array(); // indexed by the unique Actor ids
    private $factory;

    public function __construct()
    {
        $this->factory = ActorSingletonFactory::getInstance();
    }

    public function addActor($name, $birthday)
    {
        try {
            Helper::isValidString($name);
            Helper::isValidDate($birthday);
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }

        $newActor = $this->factory->create($name, $birthday);
        $this->list[$newActor->getId()] = $newActor;
    }

    public function removeActor($id)
    {
        try {
            Helper::isValidInt($id);
            if (array_key_exists($id, $this->list)) {
                $this->list[$id]->clear();
            }
            else
                throw new Exception("Actor ID does not exist in list!");
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }
    }

    public function getActorObj($index)
    {
        if (array_key_exists($index, $this->list))
            return $this->list[$index];
        else
            return null;
    }

    public function getList()
    {
        return $this->list;
    }
}
