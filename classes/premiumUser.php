<?php

class PremiumUser extends User
{
    private $_equipment;
    private $_fitnessLevel;

    public function __construct($_fName, $_lName, $_userName, $_password,$_age)
    {
        parent::__construct($_fName, $_lName, $_userName, $_password,$_age);


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
