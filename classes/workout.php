<?php


/**
 * Class Workout
 * Stores information associated with a workout.
 *
 * @author      Corey Rogers <crogers25@mail.greenriver.edu> and Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version     1.0
 */
class Workout
{
    private $_workout_id;
    private $_user_id;
    private $_exercises;
    private $_date;

    /**
     * Workout constructor.
     * @param $workout_id
     * @param $user_id
     * @param $exercises
     * @param $date
     */
    public function __construct($workout_id, $user_id, $exercises, $date)
    {
        $this->_workout_id = $this->setWorkoutId($workout_id);
        $this->_user_id = $this->setUserId($user_id);
        $this->_exercises = $this->setExercises($exercises);
        $this->_date = $this->setDate($date);
    }

    /**
     * Get the workout id for this Workout
     * @return mixed the workout id
     */
    public function getWorkoutId()
    {
        return $this->_workout_id;
    }

    /**
     * Set the workout id
     * @param mixed $workout_id
     */
    public function setWorkoutId($workout_id)
    {
        $this->_workout_id = $workout_id;
    }

    /**
     * Get the user id for this Workout
     * @return mixed the user id
     */
    public function getUserId()
    {
        return $this->_user_id;
    }

    /**
     * Set the user id for this Workout
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
    }

    /**
     * Get the exercises in this Workout
     * @return mixed an Array of Exercises
     */
    public function getExercises()
    {
        return $this->_exercises;
    }

    /**
     * Set the Exercises for this Workout
     * @param mixed $exercises an array of exercises for this Workout
     */
    public function setExercises($exercises)
    {
        $this->_exercises = $exercises;
    }

    /**
     * Get the date for this Workout
     * @return mixed the workout date
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * Set the date for this Workout
     * @param mixed $date the workout date
     */
    public function setDate($date)
    {
        $this->_date = $date;
    }


}