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
    $exerciseArray = $GLOBALS['db']->getSixExerciseData($user);

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
