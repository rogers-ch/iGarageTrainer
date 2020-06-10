<?php


/**
 * Class PremiumUser
 * Stores information associated with a premium user.
 *
 * @author      Corey Rogers <crogers25@mail.greenriver.edu> and Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version     1.0
 */
class PremiumUser extends User
{
    private $_equipment;
    private $_fitnessLevel;


    /**
     * PremiumUser constructor.
     * @param $_fName
     * @param $_lName
     * @param $_userName
     * @param $_password
     */
    public function __construct($_fName, $_lName, $_userName, $_password)
    {
        parent::__construct($_fName, $_lName, $_userName, $_password);


    }

    /**
     * @return mixed
     */
    public function getEquipment()
    {
        return $this->_equipment;
    }

    /**
     * @param mixed $equipment
     */
    public function setEquipment($equipment)
    {
        $this->_equipment = $equipment;
    }

    /**
     * @return mixed
     */
    public function getFitnessLevel()
    {
        return $this->_fitnessLevel;
    }

    /**
     * @param mixed $fitnessLevel
     */
    public function setFitnessLevel($fitnessLevel)
    {
        $this->_fitnessLevel = $fitnessLevel;
    }


}
