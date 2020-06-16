<?php


/**
 * Class PremiumUser
 * Stores information associated with a premium user.
 *
 * @author      Corey Rogers <crogers25@mail.greenriver.edu>
 * @author      Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version     1.0
 */
class PremiumUser extends User
{
    private $_equipment;
    private $_fitnessLevel;


    /**
     * PremiumUser constructor.
     * @param $fName
     * @param $lName
     * @param $userName
     * @param $password
     */
    public function __construct($fName, $lName, $userName, $password)
    {
        parent::__construct($fName, $lName, $userName, $password);


    }

    /**
     * Get the equipment level for this PremiumUser
     * @return array the user's equipment
     */
    public function getEquipment()
    {
        return $this->_equipment;
    }

    /**
     * Set the equipment for this PremiumUser
     * @param Array $equipment
     */
    public function setEquipment($equipment)
    {
        $this->_equipment = $equipment;
    }

    /**
     * Get the fitness level for this PremiumUser
     * @return String
     */
    public function getFitnessLevel()
    {
        return $this->_fitnessLevel;
    }

    /**
     * Set the fitness level for this PremiumUser
     * @param String $fitnessLevel
     */
    public function setFitnessLevel($fitnessLevel)
    {
        $this->_fitnessLevel = $fitnessLevel;
    }


}
