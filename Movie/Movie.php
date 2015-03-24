<?php

namespace Movie;

set_include_path(get_include_path() . PATH_SEPARATOR . '../');
spl_autoload_extensions('.php');
spl_autoload_register();

use \Utils\Helper;
use \Base\BaseEntity;
use \Actor\ActorDB;
use Exception;

class Movie extends BaseEntity
{
    private $title;
    private $runtime;
    private $release;
    private $cast = array();
    private $actorDB;

    public function __construct($id, $title, $release, $runtime, ActorDB $actorDB = null)
    {
        parent::__construct($id);

        try {
            Helper::isValidString($title);
            Helper::isValidDate($release);
            Helper::isValidRuntime($runtime);
        } catch (Exception $e) {
            throw new Exception("Error in " . __CLASS__ . " object creation; " . $e->getMessage());
        }

        $this->title = $title;
        $this->release = new \DateTime($release);
        $this->runtime = new \DateTime($runtime);
        $this->actorDB = $actorDB;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        try {
            Helper::isValidString($title);
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }

        $this->title = $title;
    }

    public function assignActorDB(ActorDB $actorDB)
    {
        $this->actorDB = $actorDB;
    }

    public function addCharacter($actorId, $role)
    {
        try {
            Helper::isValidInt($actorId);
            Helper::isValidString($role);

            // role must be unique in Movie
            foreach ($this->cast as $key => $value)
                if ($value['role'] == $role) {
                    throw new Exception("Role already exists: " . $role);
                }
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }

        $this->cast[] = ["actorId" => $actorId, "role" => $role];
    }

    public function getCastOrderedList()
    {
        try {
            $actorObjList = $this->getCastDetails();
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }

        usort($actorObjList, function($a, $b)
        {
            if (!is_null($a->getBirthday()) and !is_null($b->getBirthday())) {
                if ($a->getBirthday() == $b->getBirthday())
                    return 0;

                return ($a->getBirthday() < $b->getBirthday()) ? -1 : 1;
            }
        });

        // we have the full list ordered in $actorObjList
        // calculate age and return only [name, age] without duplicates
        $finalList = array();

        foreach ($actorObjList as $key => $value) {
            $name = $value->getName();
            $age = Helper::getAge($value->getBirthday());

            if (!is_null($name) and $age > 0)
                $finalList[] = ['actorName' => $value->getName(), 'age' => Helper::getAge($value->getBirthday())];
        }

        return array_map("unserialize", array_unique(array_map("serialize", $finalList)));
    }

    private function getCastDetails()
    {
        if (is_null($this->actorDB))
            throw new Exception("No actor database found!");

        $actorDetailedObjList = array();
        foreach ($this->cast as $key => $value) {
            $actorObj = $this->actorDB->getActorObj($value["actorId"]);
            if (!is_null($actorObj))
                $actorDetailedObjList[] = $actorObj;
        }

        return $actorDetailedObjList;
    }

    public function jsonSerialize()
    {
        try {
            return ['id' => $this->id, 'title' => $this->title, 'release' => $this->getRelease(), 'runtime' => $this->getRuntime(), 'cast' => $this->getCharacters()];
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }
    }

    public function getRelease()
    {
        return Helper::getFormattedDate($this->release);
    }

    public function setRelease($year, $month, $day)
    {
        try {
            Helper::isValidInt($year);
            Helper::isValidInt($month);
            Helper::isValidInt($day);
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }

        // future release announcements are valid -> no need to check 'age'
        $this->release->setDate($year, $month, $day);
    }

    public function getRuntime()
    {
        return Helper::getFormattedTime($this->runtime);
    }

    public function setRuntime($hour , $minute)
    {
        try {
            Helper::isValidInt($hour);
            Helper::isValidInt($minute);
        } catch (Exception $e) {
            var_dump("Exception at " . __FILE__ . ":" . __LINE__ . " => " . $e->getMessage());
            exit;
        }

        $this->runtime->setTime($hour, $minute);
    }

    private function getCharacters()
    {
        $characters = array();

        foreach ($this->cast as $key => $value) {
            $characters[] = ['actorName' => $this->getActorName($value['actorId']),
                            'role' => $value['role']];
        }

        return $characters;
    }

    private function getActorName($id)
    {
        if (is_null($this->actorDB))
            throw new Exception("No actor database found!");

        $actor = $this->actorDB->getActorObj($id);

        if (!is_null($actor))
            return $actor->getName();
        else
            return "MISSING";
    }
}
