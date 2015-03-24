<?php

spl_autoload_extensions('.php');
spl_autoload_register();

use \Movie\MovieSingletonFactory;
use \Actor\ActorDB;

// create Movie factory and add Movies
$movieFactory = MovieSingletonFactory::getInstance();
$movie0 = $movieFactory->create("Movie_0", "2000-01-01", "01:15");
$movie1 = $movieFactory->create("Movie_1", "2000-01-02", "02:00");

// create ActorDB and add Actors
$actorDB = new ActorDB();
$actorDB->addActor("Actor_0", "2000-02-01"); // id = 0
$actorDB->addActor("Actor_1", "2001-02-02"); // id = 1
$actorDB->addActor("Actor_2", "2002-02-03"); // id = 2
$actorDB->removeActor(1); // id of Actor_1
$actorDB->addActor("Actor_3", "2001-02-04"); // id = 3

// assign Actor DB to Movie
$movie0->assignActorDB($actorDB);

// create characters in Movie: (actorId, role)
$movie0->addCharacter(0, "R0");
$movie0->addCharacter(1, "R1");
$movie0->addCharacter(2, "R2");
$movie0->addCharacter(2, "R22"); // this actor plays two characters in the movie
$movie0->addCharacter(3, "R3");

// this will show the incrementing unique id of Movie entities
echo "<b>movie1 object:</b><br />";
var_dump($movie1);
echo "<b>movie1 all public data in JSON: </b><br />";
echo $movie1->getAllJSON() . "<br />";
echo "<br />";

// more details about Movie entity
echo "<b>movie0 object:</b><br />";
var_dump($movie0);
echo "<b>Test movie0 public methods:</b><br />";
echo "<b>id: </b>" . $movie0->getId() . "<br />";
echo "<b>title: </b>" . $movie0->getTitle() . "<br />";
echo "<b>release: </b>" . $movie0->getRelease() . "<br />";
echo "<b>runtime: </b>" . $movie0->getRuntime() . "<br />";
echo "<b>all (JSON): </b><br />";
echo $movie0->getAllJSON() . "<br />";
echo "<b>cast desc ordered by age: </b><br />";
var_dump($movie0->getCastOrderedList());
echo "<br />";

// ActorDB
echo "<b>actorDB object:</b><br />";
var_dump($actorDB);
echo "<b>Test actorDB get methods:</b><br />";
echo "<b>id 0: </b><br />";
var_dump($actorDB->getActorObj(0));
echo "<br />";
echo "<b>id 1: (Actor has been removed from list)</b><br />";
var_dump($actorDB->getActorObj(1));
echo "<br />";
echo "<b>id 2: </b><br />";
var_dump($actorDB->getActorObj(2));
echo "<br />";
echo "<b>id 3: </b><br />";
var_dump($actorDB->getActorObj(3));
echo "<br />";
echo "<b>complete stored list: </b><br />";
var_dump($actorDB->getList());
echo "<br />";

echo "DONE";