<?php

/**
 * Class Validate
 * Contains the validation methods for the iGarageTrainer web application
 * @author Corey Rogers <crogers25@mail.greenriver.edu> and Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version 1.0
 */
class Validate
{
    //Validation for first sign-up page
    /**
     * @param $name
     * @return bool
     */
    function validName($name)
    {
        $name = str_replace(" ", "", $name);

        return !empty($name) && ctype_alpha($name);
    }

    // ensure the age input is between 18 and 118

    /**
     * @param $age
     * @return bool
     */
    function validAge($age)
    {

        return is_numeric($age) && ($age >= 18 && $age <= 118);
    }

    //ensure the length of username between 5 and 15
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

    // ensure the password contains one of special chars "!, @, #, $, %"
    //length of password between 8 and 20, contains both lower and upper case letter
    function validPassword($password)
    {
        $isValid = true;
        $specialChars = array('!','@','#','$','%');
        foreach($specialChars as $char)
        {
            if(strpos($password,$char) == 0)
            {
                $isValid = false;

            }
        }

        if(strlen($password)<8 && strlen($password)>20)
        {
            $isValid = false;
        }
        if(strtoupper($password)==$password)
        {
            $isValid = false;
        }
        if(strtolower($password)==$password)
        {
            $isValid = false;
        }
        else
        {
            return true;
        }
    }

    // ensure the confirm password is identical to the password
    function validCpassword($password,$Cpassword)
    {
        if($password!=$Cpassword)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    // ending of validation for first sign up page

    //validation for second signup page

    function validEquip($equipment)
    {
        $equipments = getEquip();
        return in_array($equipment, $equipments);
    }

    function validLevel($level)
    {
        $levels = getLevel();
        return in_array($level, $levels);
    }


}