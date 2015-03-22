Each entity must have a unique identifier.
 - Identifiers are unique for Movie and Actor entities separately. This is ensured by the separate factories. To have globally unique ids, id definition must be moved to the parent base factory.

The Movie entity must hold the title, runtime and release date.
The Actor entity must hold the name and date of birth.
 - both entity types (Movie and Actor) are derived from a base entity class. The base class (BaseEntity) contains common properties and methods, further entity specific details are implemented in the derived classes.

For all properties consider validation of the values.
 - simple rules are used for validation, they can be found in Utils\Helper.php. Values are checked during object creation in the parent and derived constructors.

Each entity must contain a method that returns its data as JSON.
 - a dynamic solution is used here via getAll function. getAll is implemented in both derived entity classes and dynamically queries the actual object's internal variables. The actual JSON list is assembled in parent class's _getAll method based on the dynamic list.

Also provide methods for retrieving the values of each property individually.

Movies must hold a collection of Actors and the characters being portrayed.
 - In this solution we can create Movie objects and ActorCollections. ActorCollections contain Actor objects like a "database". A list of Actors then can be assigned to the Movie objects by their ids. This way the same Actor can be added to multiple Movies (MovieCollection is not implemented, only single Movie objects can be created. Generally it would be something similar than ActorCollection). If an Actor is not found in the given ActorCollection, then 'ACTOR MISSING' and '0001-01-01' will be assigned as name and birthday for the corresponding id.

The Movie entity requires a method of retrieving all Actors ordered by descending age.
 - Function implemented in getCastOrderedList function in Movie.php. Currently an array is returned, where the missing Actors are also listed to notify user about their absence. However the list this way will contain a mixture of arrays (missing Actors) and Actor objects. This can be modified easily be removing the last else statement in the function.