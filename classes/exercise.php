<?php


/**
 * Class Exercise
 * Stores information associated with an Exercise.
 *
 * @author      Corey Rogers <crogers25@mail.greenriver.edu> and Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version     1.0
 */
class Exercise
{
    private $_exercise_id;
    private $_exercise_name;
    private $_description;
    private $_difficulty;
    private $_muscleGroup;
    private $_equipment;

    /**
     * Exercise constructor.
     * @param $exercise_name
     * @param $description
     * @param $difficulty
     * @param $muscleGroup
     * @param $equipment
     */
    public function __construct($exercise_name, $description, $difficulty, $muscleGroup, $equipment)
    {
        $this->setExerciseId(NULL);
        $this->setExerciseName($exercise_name);
        $this->setDescription($description);
        $this->setDifficulty($difficulty);
        $this->setMuscleGroup($muscleGroup);
        $this->setEquipment($equipment);
    }


    /**
     * Get the exercise id for this Exercise
     * @return mixed exercise id
     */
    public function getExerciseId()
    {
        return $this->_exercise_id;
    }

    /**
     * Set the exercise id for this Exercise
     * @param mixed $exercise_id
     */
    public function setExerciseId($exercise_id)
    {
        $this->_exercise_id = $exercise_id;
    }

    /**
     * Get the exercise name for this Exercise
     * @return mixed exercise name
     */
    public function getExerciseName()
    {
        return $this->_exercise_name;
    }

    /**
     * Set the exercise name for this Exercise
     * @param mixed $exercise_name
     */
    public function setExerciseName($exercise_name)
    {
        $this->_exercise_name = $exercise_name;
    }

    /**
     * Get the description for this Exercise
     * @return mixed description
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Set the description for this Exercise
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * Get the difficulty for this Exercise
     * @return mixed difficulty
     */
    public function getDifficulty()
    {
        return $this->_difficulty;
    }

    /**
     * Set the difficulty for this Exercise
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->_difficulty = $difficulty;
    }

    /**
     * Get the muscle group for this Exercise
     * @return mixed muscle group
     */
    public function getMuscleGroup()
    {
        return $this->_muscleGroup;
    }

    /**
     * Set the muscle group for this Exercise
     * @param mixed $muscleGroup
     */
    public function setMuscleGroup($muscleGroup)
    {
        $this->_muscleGroup = $muscleGroup;
    }

    /**
     * Get the equipment for this Exercise
     * @return Array of equipment
     */
    public function getEquipment()
    {
        return $this->_equipment;
    }

    /**
     * Set the equipment for this Exercise
     * @param Array $equipment
     */
    public function setEquipment($equipment)
    {
        $this->_equipment = $equipment;
    }


}