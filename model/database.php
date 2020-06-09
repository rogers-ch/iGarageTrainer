<?php

/*

INSERT INTO igarage_user
VALUES (NULL, 'Admin', 'Admin', 'Admin', '@dm1n', 'advanced')

 */

$home = str_replace("public_html", "", $_SERVER['DOCUMENT_ROOT']);

require_once $home . "config.php";

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
