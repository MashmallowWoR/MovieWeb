DROP TABLE MovieGenre;
DROP TABLE MovieDirector;
DROP TABLE MovieActor;
DROP TABLE Review;
DROP TABLE MaxPersonID;
DROP TABLE MaxMovieID;
DROP TABLE Movie;
DROP TABLE Actor;
DROP TABLE Director;

CREATE TABLE Movie
	(id 	INT CHECK (id>=0), /* Movie ID cannot be a negative number */
	 title 		VARCHAR(100) NOT NULL,  /* Every movie must have a title */
	 year 		INT CHECK (year>1500), /* Year of the movie must later than 1500 */
	 rating		VARCHAR(10),
	 company 	VARCHAR(50),
	 PRIMARY KEY (id) /* Every movie has a unique identification number */ 
	) ENGINE = INNODB; 
CREATE TABLE Actor
	(id		INT CHECK (id>=0), /* Actor ID cannot be a negative number */
	 last		VARCHAR(20),
	 first		VARCHAR(20),
	 sex		VARCHAR(6),
	 dob		DATE NOT NULL, /* Every actor must have a date of birth */
	 dod		DATE,
	 PRIMARY KEY (id) /* Every actor has a unique identification number */
	) ENGINE = INNODB;
CREATE TABLE Director
	(id		INT CHECK (id>=0), /* Director ID cannot be a negative number */
	 last	VARCHAR(20),
	 first	VARCHAR(20),
	 dob	DATE NOT NULL,  /* Every director must have a date of birth */
	 dod	DATE,
	 PRIMARY KEY (id) /* Every director has a unique identification number */
	) ENGINE = INNODB;
CREATE TABLE MovieGenre
	(mid		INT,
	 genre		VARCHAR(20),
	 PRIMARY KEY (mid, genre), /* The combination of movie and genre is unique */
	 FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE /* The movie on MovieGenre table must be on the Movie table */
	) ENGINE = INNODB;
CREATE TABLE MovieDirector
	(mid		INT,
	 did		INT,
	 PRIMARY KEY (mid,  did), /* The combination of movie and director is unique */
	 FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE, /* The movie on MovieDirector table must be on the Movie table */
	 FOREIGN KEY(did) REFERENCES Director(id) ON DELETE CASCADE /* The director on MovieDirector table must be on the Director table */
	) ENGINE = INNODB;
CREATE TABLE MovieActor
	(mid		INT,
	 aid		INT,
	 role		VARCHAR(50),
	 PRIMARY KEY (mid,  aid, role), /* The combination of movie, actor and role is unique */
	 FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE, /* The movie on MovieActor table must be on the Movie table */
	 FOREIGN KEY(aid) REFERENCES Actor(id) ON DELETE CASCADE  /* The actor on MovieActor table must be on the Actor table */
	) ENGINE = INNODB;
CREATE TABLE Review
	(name		VARCHAR(20),
	 time       TIMESTAMP,
	 mid		INT,
	 rating		INT CHECK(rating>=0 AND rating<=5), /* review rating must be between 0 and 5 */
	 comment	VARCHAR(500),
	 PRIMARY KEY (name, time), /* For each person, one review at one time point */
	 FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE /* The movie being reviewed is in the Movie table */
	) ENGINE = INNODB;
CREATE TABLE MaxPersonID
	(id		INT,
	 PRIMARY KEY (id) /* Must have an ID, Max ID assigned to all persons */
	) ENGINE = INNODB;
CREATE TABLE MaxMovieID
	(id		INT,
	 PRIMARY KEY (id) /* Must have an ID, Max ID assigned to all movies */
	) ENGINE = INNODB;
