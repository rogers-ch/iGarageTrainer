<?php

/**
 * Class Validate
 * Contains the validation methods for the iGarageTrainer web application
 *
 * @author Corey Rogers <crogers25@mail.greenriver.edu>
 * @author Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version 1.0
 */
class Validate
{
    //Validation for first sign-up page

    /**
     * Checks to make sure name is not empty and is made up of letters
     * @param $name
     * @return bool
     */
    function validName($name)
    {
        $name = str_replace(" ", "", $name);

        return !empty($name) && ctype_alpha($name);
    }


    /**
     * Checks to make sure age is a number between 18 and 118
     * @param $age
     * @return bool
     */
    function validAge($age)
    {

        return is_numeric($age) && ($age >= 18 && $age <= 118);
    }


    /**
     * Checks to make sure username is at least five characters long and no more than 15 characters long
     * @param $userName
     * @return bool
     */
    function validUserName($userName)
    {
        if(preg_match('/^\w{5,15}$/',$userName))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Checks to ensure that password is between 8 and 15 characters long, has at least one uppercase
     * letter, and has at least one of the following special characters: !, @, #, $, %
     * @param $password
     * @return bool
     */
    function validPassword($password)
    {
        $isValid = false;

        //Test for special characters
        $specialChars = array('!','@','#','$','%');
        foreach($specialChars as $char)
        {
            if(strpos($password, $char) !== FALSE)
            {
                $isValid = true;

            }
        }

        //Test for length between 8 and 15
        if(strlen($password) < 8 || strlen($password) > 15)
        {
            $isValid = false;
        }

        //Test to make sure there is at least one capital letter
        if(!preg_match('/[A-Z]/', $password))
        {
            $isValid = false;
        }

        return $isValid;

    }

    /**
     * Checks to make sure the entry from the confirm password field matches the entry from the
     * password field.
     * @param $password
     * @param $Cpassword
     * @return bool
     */
    function validCpassword($password, $Cpassword)
    {
        if($password != $Cpassword)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //Ending of validation for first sign up page

    //Validation for second sign up page

    /**
     * Checks to make sure equipment values provided by the user are valid (checks for spoofing)
     * @param $equipment
     * @return bool
     */
    function validEquip($equipment)
    {
        $equipments = getEquip();

        foreach ($equipment as $equip) {
            if (!in_array($equip, $equipments)) {
                return false;
            }
        }

        return true;

    }

    /**
     * Checks to make sure the fitness level provided by the user is valid (checks for spoofing).
     * @param $level
     * @return bool
     */
    function validLevel($level)
    {
        $levels = getLevel();
        return in_array($level, $levels);
    }


}