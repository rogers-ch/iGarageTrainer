<?php

/**
 * Class User
 * Stores information associated with a user.
 *
 * @author      Corey Rogers <crogers25@mail.greenriver.edu>
 * @author      Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version     1.0
 *
 */
class User
{

    private $_fName;
    private $_lName;
    private $_userName;
    private $_password;
    private $_userNum;


    /**
     * User constructor.
     * @param $fName string first name
     * @param $lName string last name
     * @param $userName the user name
     * @param $password the password
     */
    public function __construct($fName, $lName, $userName, $password)
    {
        $this->setFName($fName);
        $this->setLName($lName);
        $this->setUserName($userName);
        $this->setPassword($password);
        $this->setUserNum(NULL);

    }

    /**
     * Get the first name for this User
     * @return String first name
     */
    public function getFName()
    {
        return $this->_fName;
    }

    /**
     * Set the first name for this User
     * @param String first name
     */
    public function setFName($fName)
    {
        $this->_fName = $fName;
    }

    /**
     * Get the last name for this User
     * @return String last name
     */
    public function getLName()
    {
        return $this->_lName;
    }

    /**
     * Set the last name for this User
     * @param String last name
     */
    public function setLName($lName)
    {
        $this->_lName = $lName;
    }

    /**
     * Get the username for this User
     * @return String the user name
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * Set the username for this User
     * @param  $userName String user name
     */
    public function setUserName($userName)
    {
        $this->_userName = $userName;
    }

    /**
     * Get the password for this User
     * @return String the password
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Set the password
     * @param  $password String the password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * Get the userNum for this User
     * @return int the userNum
     */
    public function getUserNum()
    {
        return $this->_userNum;
    }

    /**
     * Set the userNum for this User
     * @param  $_userNum String the userNum in the database
     */
    public function setUserNum($_userNum)
    {
        $this->_userNum = $_userNum;
    }




}
