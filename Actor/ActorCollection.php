<?php

namespace Actor;


class ActorCollection
{
    private $list = array(); // indexed by the unique Actor ids
    private $factory;

    public function __construct($actorFactory)
    {
        $this->factory = $actorFactory;
    }

    public function addActor($name, $birthday)
    {
        $newActor = $this->factory->create($name, $birthday);
        $this->list[$newActor->getId()] = $newActor;
    }

    public function removeActor($id)
    {
        unset($this->list[$id]);
    }

    public function getItem($index)
    {
        if (array_key_exists($index, $this->list))
            return $this->list[$index];
        else
            return [$index, "ACTOR MISSING", "0001-01-01"];
    }

    public function getList()
    {
        return $this->list;
    }
}
