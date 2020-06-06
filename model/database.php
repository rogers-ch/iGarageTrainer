<?php

/*

CREATE TABLE user (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    age INT,
	username VARCHAR(100),
    password VARCHAR(100);

)

CREATE TABLE premiumUser (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    age INT,
	username VARCHAR(100),
    password VARCHAR(100);
    fitnessLevel

)

//NEEDS Edits
INSERT INTO user (food, meal, condiments)
VALUES ('sandwich', 'breakfast', 'sriracha, mayonnaise');

 */

$home = $_SERVER['home'];
require_once "/home/chrogers/config.php";

class Database
{

    private $_dbh;

    function __construct()
    {
        //Connect to database with PDO
        try {

            //Instantiate a database object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo 'Connected to database!';

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }



}
