<?php

//SELECT SHA1(password) FROM users WHERE username = ?

$home = str_replace("public_html", "", $_SERVER['DOCUMENT_ROOT']);

require_once $home . "config.php";


/**
 * Class Database
 * Contains the methods for reading from and writing to the database for the iGarage Trainer project.
 *
 * @author      Corey Rogers <crogers25@mail.greenriver.edu>
 * @author      Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version     1.0
 */
class Database
{

    private $_dbh;

    /**
     * Database constructor.
     */
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


    /**
     * Writes a user's information to the database when a new user account is created
     * @param $user a User or PremiumUser object
     */
    function writeUser($user)
    {
        //var_dump($user);


        //Write the user's information to the igarage_user table
        //1. Define the query
        $sql = "INSERT INTO igarage_user (user_id, firstName, lastName, username, password, fitness_level)
                VALUES (:user_id, :firstName, :lastName, :username, SHA1(:password), :fitness_level)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $null = NULL;

        $statement->bindParam(':user_id', $null);
        $statement->bindParam(':firstName', $user->getFName());
        $statement->bindParam(':lastName', $user->getLName());
        $statement->bindParam(':username', $user->getUserName());
        $statement->bindParam(':password', $user->getPassword());

        if(get_class($user) == 'PremiumUser') {

            $statement->bindParam(':fitness_level', $user->getFitnessLevel());

        } else {

            $statement->bindParam(':fitness_level', $null);

        }

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)
        $sql = "SELECT LAST_INSERT_ID()";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //Set the user's UserNum to the user_id from the database
        $user->setUserNum($result['LAST_INSERT_ID()']);


        //Write the user's equipment to the equipment_line table if this is a premium user
        if(get_class($user) == 'PremiumUser') {

            //Get the user's equipment
            $equipmentArray = $user->getEquipment();

            //Add each piece of equipment to the equipment_line table with the user's id
            foreach ($equipmentArray as $equipment) {

                //1. Define the query
                $sql = "INSERT INTO equipment_line (user_id, equip_id)
                VALUES (:user_id, :equip_id)";

                //2. Prepare the statement
                $statement = $this->_dbh->prepare($sql);

                //3. Bind the parameters

                //Get the equip_id for each piece of equipment the user has (separate SQL query)
                $innerStmt = $this->_dbh->prepare("SELECT * FROM equipment WHERE equip_name=?");
                $innerStmt->execute([$equipment]);
                $equipID = $innerStmt->fetch();
                $equipID = $equipID['equip_id'];

                $statement->bindParam(':user_id', $user->getUserNum());
                $statement->bindParam(':equip_id', $equipID);


                //4. Execute the statement
                $statement->execute();

            }

            unset($equipment);

        }


    }


    /**
     * Checks to see if a given username exists in the igarage_user table
     * @param $username the username submitted by the user
     * @return bool whether the username exists in the igarage_user table
     */
    function checkUserName($username)
    {
        //Check to see if given username exists in the igarage_user table
        //1. Define the query
        $sql = "SELECT username FROM igarage_user WHERE username = :username LIMIT 1";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':username', $username);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)

        $result = $statement->fetch();
        //echo print_r($result);
        $result = $result['username'];
        //echo $result;

        //echo ((strcmp($result, $username)) == 0);

        //Return true if the Strings are equal, otherwise return false
        // Note: strcmp returns 0 if the Strings are the same - need this comparison since mySQL is not case sensitive
        return ((strcmp($result, $username)) == 0);

    }


    /**
     * Checks to see if a given password matches the stored password for the username provided
     * @param $username the username from the user
     * @param $password the password from the user
     * @return bool true if the password matches the saved password for the username, otherwise false
     */
    function checkPassword($username, $password)
    {
        //Check to see if given password matches the stored password for the username provided
        //1. Define the query
        $sql = "SELECT EXISTS(SELECT * FROM igarage_user WHERE username = :username and password = SHA1(:password)) as 'exists'";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $password);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)

        $result = $statement->fetch();
        //echo print_r($result);
        $result = $result['exists'];
        //echo $result;
        return $result;


    }


    /**
     * Reads a user's information from the database and returns and array with the User's information
     * @param $username the username for the user
     * @return an array with the user's information
     */
    function readUser($username)
    {
        //Get the user's information from the igarage_user table based on $username

        //1. Define the query
        $sql = "SELECT * FROM igarage_user WHERE username = :username";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':username', $username);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Set result to the the associative array for the user
        $user = $result[0];
        //echo print_r($user);

        //Check to see if this is a premium user, and if so get the user's equipment list
        if ($user['fitness_level'] != NULL) {

            //echo print_r($user);

            $user_id = $user['user_id'];

            //Get equipment list and add it to the user's array
            $user['equipment'] = $this->readUserEquip($user_id);

        }

        //echo print_r($user);
        return $user;

    }

    /*
     * Reads the equipment for a Premium User from the database
     * @return an array of the user's equipment
     */
    private function readUserEquip($user_id) {

        //Get an array of all the equip_id numbers associated with this user's user_id in the equipment_line table

        //1. Define the query
        $sql = "SELECT * FROM equipment_line WHERE user_id = :user_id";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':user_id', $user_id);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //echo print_r($result);

        //Create an array of the equip_ids from $result
        $equipIDs = array();

        foreach ($result as $row) {
            array_push($equipIDs, $row['equip_id']);
        }

        //echo print_r($equipIDs);

        //Get an array of all equipment for the user using the the user_id and equip_id
        $equipment = array();

        foreach ($equipIDs as $equipID) {
            //1. Define the query
            $sql = "SELECT equip_name FROM equipment WHERE equip_id = :equip_id";

            //2. Prepare the statement
            $statement = $this->_dbh->prepare($sql);

            //3. Bind the parameters

            $statement->bindParam(':equip_id', $equipID);

            //4. Execute the statement
            $statement->execute();

            //5. Process the results (get the primary key generated by the insert statement)

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            array_push($equipment, $result[0]['equip_name']);

        }

        //echo print_r($equipment);

        //Return the array of equipment for the user
        return $equipment;


    }

    /**
     * Writes an exercise to the database
     * @param $exercise an Exercise object
     */
    function writeExercise($exercise)
    {
        //var_dump($exercise);


        //Write the exercise information to the exercise table
        //1. Define the query
        $sql = "INSERT INTO exercise (exercise_id, exercise_name, description, difficulty, muscle_group)
                VALUES (:exercise_id, :exercise_name, :description, :difficulty, :muscle_group)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $null = NULL;

        $statement->bindParam(':exercise_id', $null);
        $statement->bindParam(':exercise_name', $exercise->getExerciseName());
        $statement->bindParam(':description', $exercise->getDescription());
        $statement->bindParam(':difficulty', $exercise->getDifficulty());
        $statement->bindParam(':muscle_group', $exercise->getMuscleGroup());

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)
        $sql = "SELECT LAST_INSERT_ID()";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //Set the exercise_id to the exercise_id from the database
        $exercise->setExerciseId($result['LAST_INSERT_ID()']);


        //Write the exercise equipment to the req_equip_line table

        //Get the exercise equipment
        $equipmentArray = $exercise->getEquipment();

        //Add each piece of equipment to the req_equip_line table with the exercise id
        foreach ($equipmentArray as $equipment) {

            //1. Define the query
            $sql = "INSERT INTO req_equip_line (exercise_id, equip_id)
            VALUES (:exercise_id, :equip_id)";

            //2. Prepare the statement
            $statement = $this->_dbh->prepare($sql);

            //3. Bind the parameters

            //Get the equip_id for each piece of equipment the exercise requires (separate SQL query)
            $innerStmt = $this->_dbh->prepare("SELECT * FROM equipment WHERE equip_name=?");
            $innerStmt->execute([$equipment]);
            $equipID = $innerStmt->fetch();
            $equipID = $equipID['equip_id'];

            $statement->bindParam(':exercise_id', $exercise->getExerciseId());
            $statement->bindParam(':equip_id', $equipID);


            //4. Execute the statement
            $statement->execute();

        }

        unset($equipment);

    }


    /**
     * Gets the database information for six random exercises from the database that match the user's requirements
     * @param $user the user creating the workout
     * @return array of exercise data for six random exercises
     */
    function readSixExerciseData($user)
    {
        //echo print_r($user);

        if(get_class($user) == 'PremiumUser') {

            //For premium user (limit based on fitness level and equipment)

            $result = array();

            $fitness_level = $user->getFitnessLevel();

            if (strcmp($fitness_level, 'beginner') === 0) {
                $fitness_level = 1;
            } else if (strcmp($fitness_level, 'intermediate') === 0) {
                $fitness_level = 2;
            }
            else {
                $fitness_level = 3;
            }

            //echo $fitness_level;

            $userEquipment = $user->getEquipment();

            if (!in_array('no equipment', $userEquipment)) {
                array_push($userEquipment, 'no equipment');
            }

            //echo print_r($userEquipment);

            foreach ($userEquipment as $equipment) {

                //echo $equipment;

                for ($i = 1; $i <= $fitness_level; $i++) {
                    $thisEquipResult = $this->getFitEquipExercises($i, $equipment);
                    $result = array_merge($result, $thisEquipResult);
                }


            }

            //echo print_r($result);

        } else {

            //For regular user (all exercises considered - get all exercises)

            //1. Define the query
            $sql = "SELECT * FROM exercise";

            //2. Prepare the statement
            $statement = $this->_dbh->prepare($sql);

            //3. Bind the parameters - no parameters

            //4. Execute the statement
            $statement->execute();

            //5. Process the results (get the primary key generated by the insert statement)

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        }

        //echo print_r($result);

        //Get six random exercises from the $results array
        $randExercises = array();

        for ($i = 0; $i < 6; $i++) {

            //Generate a random number within the number of results returned by the query
            $randNum = mt_rand(0, sizeof($result) - 1);

            //Put the exercise associated with the random number into the randExercises array
            $randExercises[$i] = $result[$randNum];

            //Get the equipment for each exercise
            $equipment = $this->readExerciseEquip($randExercises[$i]['exercise_id']);

            //Add the equipment to each exercise in the $randExercises array
            $randExercises[$i]['equipment'] = $equipment;

        }

        //echo print_r($randExercises);

        return $randExercises;

    }

    /*
     * Reads all Exercises associated with a specific fitness level and piece of equipment
     * @param $fitness_level
     * @param $equipment
     * @return array Exercises that match the parameters
     */
    private function getFitEquipExercises($fitness_level, $equipment)
    {
        //1. Define the query
        $sql = "SELECT DISTINCT exercise.exercise_id, exercise_name, description, difficulty, muscle_group, 
                equipment.equip_name FROM exercise JOIN req_equip_line ON 
                exercise.exercise_id = req_equip_line.exercise_id JOIN equipment ON 
                req_equip_line.equip_id = equipment.equip_id WHERE (exercise.difficulty = :fitness_level) 
                AND (equipment.equip_name = :equipment_name)";

        /*
        SELECT order_num, order_date, orders.customer_num, customer_name, customer.rep_num,
        last_name AS 'Rep Last Name', first_name AS 'Rep First Name'
        FROM orders JOIN customer ON orders.customer_num = customer.customer_num
        JOIN rep ON customer.rep_num = rep.rep_num
        ORDER BY order_num;

        */

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':fitness_level', $fitness_level);
        $statement->bindParam(':equipment_name', $equipment);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //echo print_r($result);
        return $result;

    }


    /**
     * Gets the database information for an exercise
     * @param $exercise_id the id number for the exercise
     * @return array of exercise data
     */
    function readExercise($exercise_id)
    {

        //Get the exercise information based on the $exercise_id

        //1. Define the query
        $sql = "SELECT * FROM exercise WHERE exercise_id = :exercise_id";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':exercise_id', $exercise_id);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Set result to the the associative array for the exercise
        //echo print_r($result);
        $exercise = $result[0];

        //Get the equipment for the exercise
        $equipment = $this->readExerciseEquip($exercise['exercise_id']);

        //Add the equipment to each exercise in the $randExercises array
        $exercise['equipment'] = $equipment;

        //echo print_r($exercise);

        return $exercise;

    }


    /*
     * Returns an array of equipment for a give exercise
     * @param $exercise_id
     */
    private function readExerciseEquip($exercise_id) {

        //Get an array of all the equip_id numbers associated with this user's user_id in the equipment_line table

        //1. Define the query
        $sql = "SELECT equip_name FROM equipment JOIN req_equip_line ON equipment.equip_id = req_equip_line.equip_id 
                    JOIN exercise ON exercise.exercise_id = req_equip_line.exercise_id WHERE exercise.exercise_id = :exercise_id";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':exercise_id', $exercise_id);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //echo print_r($result);

        //Create an array of the equip_ids from $result
        $equipment = array();

        foreach ($result as $row) {
            array_push($equipment, $row['equip_name']);
        }

        //echo print_r($equipment);

        //Return the array of equipment for the user
        return $equipment;

    }


    /**
     * Writes a Workout to the database
     * @param $workout a Workout object
     */
    function writeWorkout($workout)
    {
        //var_dump($workout);

        //Write the workout information to the workout table
        //1. Define the query
        $sql = "INSERT INTO workout (workout_id, user_id)
                VALUES (:workout_id, :user_id)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $null = NULL;

        $statement->bindParam(':workout_id', $null);
        $statement->bindParam(':user_id', $workout->getUserId());


        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)
        $sql = "SELECT LAST_INSERT_ID()";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //Set the exercise_id to the exercise_id from the database
        $workout->setWorkoutId($result['LAST_INSERT_ID()']);


        //Write the workout's exercises to the workout line table

        //Get the exercises
        $exercisesArray = $workout->getExercises();

        //Set a starting order number variable
        $orderNum = 1;

        //Add each exercise to the workout_line table with the exercise id
        foreach ($exercisesArray as $exercise) {

            //1. Define the query
            $sql = "INSERT INTO workout_line (workout_id, exercise_id, workout_order)
            VALUES (:workout_id, :exercise_id, :workout_order)";

            //2. Prepare the statement
            $statement = $this->_dbh->prepare($sql);

            //3. Bind the parameters

            $statement->bindParam(':workout_id', $workout->getWorkoutId());
            $statement->bindParam(':exercise_id', $exercise->getExerciseId());
            $statement->bindParam(':workout_order', $orderNum);


            //4. Execute the statement
            $statement->execute();

            //Increment $orderNum variable
            $orderNum++;

        }

        unset($exercise);

    }


    /**
     * Reads a User's workouts for the last two weeks from the database and returns an array with
     * the Workout information
     * @param $user
     * @return an array with the last two week's Workouts
     */
    function readWorkouts($user)
    {
        //Get the workout information from the workout table based on the user's id

        //1. Define the query
        $sql = "SELECT workout_id, DATE_FORMAT(date_time, '%M %D, %Y') as 'Date' FROM workout
                WHERE user_id = :user_id AND date_time BETWEEN DATE_SUB(NOW(), INTERVAL 14 DAY) AND NOW();";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':user_id', $user->getUserNum());

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        //echo print_r($results);

        /*
         Array ( [0] => Array ( [workout_id] => 1 [Date] => June 15th, 2020 )
                 [1] => Array ( [workout_id] => 2 [Date] => June 15th, 2020 )
                 [2] => Array ( [workout_id] => 3 [Date] => June 15th, 2020 )
                ) 1
         */

        $workoutsArray = array();

        for ($index = 0; $index < sizeof($results); $index++) {

            //echo print_r($results[$index]);

            /*
             Array ( [workout_id] => 1 [Date] => June 15th, 2020 ) 1

             */

            //Get the six exercise ids for each workout in order
            $exerciseIds = array();

            for ($i = 1; $i <= 6; $i++) {

                //echo $results[$index]['workout_id'];    // 1

                $exerciseIds[$i-1] = $this->readWorkoutLine($results[$index]['workout_id'], $i);

            }

            //echo print_r($exerciseIds);

            $results[$index]['exerciseIds'] = $exerciseIds;

        }

        //echo print_r($results);

        /*
         Array ( [0] => Array ( [workout_id] => 2
                                [Date] => June 15th, 2020
                                [exerciseIds] => Array ( [0] => 8 [1] => 12 [2] => 28 [3] => 14 [4] => 24 [5] => 27 )
                               )
                 [1] => Array ( [workout_id] => 3
                                [Date] => June 15th, 2020
                                [exerciseIds] => Array ( [0] => 10 [1] => 24 [2] => 8 [3] => 24 [4] => 10 [5] => 28 )
                               )
                ) 1
         */

        return $results;


    }


    /*
     * Returns the exercise id for each exercise in a workout
     * @param $workout_id
     * @param $workout_order
     */
    private function readWorkoutLine($workout_id, $workout_order) {

        //Get an array of all the equip_id numbers associated with this user's user_id in the equipment_line table

        //1. Define the query
        $sql = "SELECT exercise_id FROM workout_line WHERE workout_id = :workout_id AND workout_order = :workout_order";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        $statement->bindParam(':workout_id', $workout_id);
        $statement->bindParam(':workout_order', $workout_order);

        //4. Execute the statement
        $statement->execute();

        //5. Process the results (get the primary key generated by the insert statement)

        $result = $statement->fetchAll(PDO::FETCH_NAMED);
        $result = $result[0];

        //echo print_r($result);
        //echo $result['exercise_id'];    // 8

        //Return the exercise id
        return $result['exercise_id'];

    }



}