<?php
function getEquip()
{
        return array("dumbbells","kettlebells","resistance bands","chairs","pull-up bar","no equipment");

}

function getLevel()
{
    return array("beginner","intermediate","advanced");

}

/*
 * Returns six Exercise objects
 */
function getSixExercises($user)
{
    //Get exercise data for six exercises from the database
    $exerciseArray = $GLOBALS['db']->readSixExerciseData($user);

    //Create an array for the Exercise objects
    $objectArray = array();

    //Create Exercise objects using the data from the database
    foreach($exerciseArray as $exercise) {
        $exerciseObj = new Exercise($exercise['exercise_name'], $exercise['description'],
            $exercise['difficulty'], $exercise['muscle_group'], $exercise['equipment']);

        $exerciseObj->setExerciseId($exercise['exercise_id']);

        array_push($objectArray, $exerciseObj);

    }

    //echo print_r($objectArray);

    return $objectArray;

}

function getWorkoutHistory($user)
{
    //Get the user's workouts for the last two weeks
    $workoutsArray = $GLOBALS['db']->readWorkouts($user);

    //Create an array for the Workout objects
    $workoutObjArray = array();

    //Create Workout objects using the data from the database
    foreach($workoutsArray as $workout) {

        //echo print_r($workout);

        /*
         Array ( [workout_id] => 2
                 [Date] => June 15th, 2020
                 [exerciseIds] => Array ( [0] => 8 [1] => 12 [2] => 28 [3] => 14 [4] => 24 [5] => 27 ) ) 1
         Array ( [workout_id] => 3
                 [Date] => June 15th, 2020
                 [exerciseIds] => Array ( [0] => 10 [1] => 24 [2] => 8 [3] => 24 [4] => 10 [5] => 28 ) ) 1
         */

        $exerciseArray = array();
        $exerciseObjArray = array();

        $exerciseIds = $workout['exerciseIds'];

        //Get the exercise data for the workout
        foreach($exerciseIds as $exerciseId) {
            //echo print_r($exerciseId);

            $exercise = $GLOBALS['db']->readExercise($exerciseId);

            //echo print_r($exercise);

            array_push($exerciseArray, $exercise);

        }

        //Create Exercise objects using the $exerciseArray
        foreach($exerciseArray as $exercise) {
            $exerciseObj = new Exercise($exercise['exercise_name'], $exercise['description'],
                $exercise['difficulty'], $exercise['muscle_group'], $exercise['equipment']);

            $exerciseObj->setExerciseId($exercise['exercise_id']);

            array_push($exerciseObjArray, $exerciseObj);

        }


        $workoutObj = new Workout($user->getUserNum(), $exerciseObjArray);

        $workoutObj->setWorkoutId($workout['workout_id']);
        $workoutObj->setDate($workout['Date']);

        array_push($workoutObjArray, $workoutObj);

    }

    //echo print_r($workoutObjArray);

    return $workoutObjArray;


}
