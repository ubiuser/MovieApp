<?php

namespace Movie;

include_once '\Utils\Helper.php';
include_once '\Base\BaseEntity.php';

use Utils\Helper;
use Base\BaseEntity;

class Movie extends BaseEntity
{
    private $title;
    private $runtime;
    private $release;
    private $cast = array();

    public function __construct($id, $title, $release, $runtime)
    {
        parent::__construct($id);

        Helper::isValidString(__CLASS__, $title);
        Helper::isValidDate(__CLASS__, $release);
        Helper::isValidRuntime(__CLASS__, $runtime);

        $this->title = $title;
        $this->release = $release;
        $this->runtime = $runtime;
    }

    public function getTitle() { return $this->title; }

    public function getRuntime() { return $this->runtime; }

    public function getRelease() { return $this->release; }

    public function getAll()
    {
        return $this->_getAll(get_object_vars($this));
    }

    public function addActorIdList($actorList)
    {
        $this->cast = array_unique(array_merge($this->cast, $actorList));
    }

    private function getCastDetails($actorCollection)
    {
        $actorDetailedObjList = array();
        foreach ($this->cast as $key => $value)
        {
            array_push($actorDetailedObjList, $actorCollection->getItem($value));
        }

        return $actorDetailedObjList;
    }

    public function getCastOrderedList($actorCollection)
    {
        $actorObjList = $this->getCastDetails($actorCollection);

        usort($actorObjList, function($a, $b)
        {
            if (method_exists($a, "getBirthday") and method_exists($b, "getBirthday")) // check if Actor object exists
            {
                if ($a->getBirthday() == $b->getBirthday())
                {
                    return 0;
                }
                return ($a->getBirthday() < $b->getBirthday()) ? 1 : -1;
            }
        });


        $actorJSONList = array();
        foreach ($actorObjList as $key => $value)
        {
            if (method_exists($value, "getAll"))
                array_push($actorJSONList, $value->getAll());
            else
                array_push($actorJSONList, json_encode($value, JSON_PRETTY_PRINT)); // remove this to exclude missing actors from final result list
        }

        return $actorJSONList;
    }
}
