<?php

include_once '\Movie\MovieSingletonFactory.php';
include_once '\Actor\ActorSingletonFactory.php';
include_once '\Actor\ActorCollection.php';

use Movie\MovieSingletonFactory;
use Actor\ActorSingletonFactory;
use Actor\ActorCollection;

// create Movie factory and add Movies
$movieFactory = MovieSingletonFactory::getInstance();
$movie1 = $movieFactory->create("Movie_0", "2000-01-01", "01:15");
$movie2 = $movieFactory->create("Movie_1", "2000-01-02", "02:00");

// create ActorCollection and add Actors
$actorFactory = ActorSingletonFactory::getInstance();
$actorCollection1 = new ActorCollection($actorFactory);
$actorCollection1->addActor("Actor_0", "2001-02-01"); // id = 0
$actorCollection1->addActor("Actor_1", "2001-02-02"); // id = 1
$actorCollection1->addActor("Actor_2", "2001-02-03"); // id = 2
$actorCollection1->removeActor(1); // id of Actor_2
$actorCollection1->addActor("Actor_3", "2001-02-04"); // id = 3

$movie1->addActorIdList([0, 3]); // add id of Actors
$movie1->addActorIdList([2]); // add id of Actors
$movie1->addActorIdList([1]); // Actor_1 has been removed!!!

echo "<b>movie2 object:</b><br />";
var_dump($movie2);
echo "all (JSON): " . $movie2->getAll() . "<br />";
echo "cast desc ordered by age: <br />";
var_dump($movie2->getCastOrderedList($actorCollection1));
echo "<br />";

echo "<b>movie1 object:</b><br />";
var_dump($movie1);
echo "<b>Test movie1 public methods</b><br />";
echo "id: " . $movie1->getId() . "<br />";
echo "title: " . $movie1->getTitle() . "<br />";
echo "release: " . $movie1->getRelease() . "<br />";
echo "runtime: " . $movie1->getRuntime() . "<br />";
echo "all (JSON): " . $movie1->getAll() . "<br />";
echo "cast desc ordered by age: <br />";
var_dump($movie1->getCastOrderedList($actorCollection1));
echo "<br />";

echo "<b>actorCollection1 object:</b><br />";
var_dump($actorCollection1);
echo "<b>Test actorCollection1 get methods</b><br />";
echo "id 0: <br />";
var_dump($actorCollection1->getItem(0));
echo "<br />";
echo "id 1: (Actor has been removed from list)<br />";
var_dump($actorCollection1->getItem(1));
echo "<br />";
echo "id 2: <br />";
var_dump($actorCollection1->getItem(2)); // Actor_2 has been removed
echo "<br />";
echo "id 3: <br />";
var_dump($actorCollection1->getItem(3));
echo "<br />";
echo "complete stored list: <br />";
var_dump($actorCollection1->getList());
echo "<br />";
