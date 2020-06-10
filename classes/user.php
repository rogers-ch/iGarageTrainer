<?php

/**
 * Class User
 * Stores information associated with a user.
 *
 * @author      Corey Rogers <crogers25@mail.greenriver.edu> and Chunhai Yang <cyang21@mail.greenriver.edu>
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
     * @param $_fName string first name
     * @param $_lName string last name
     * @param $_userName the user name
     * @param $_password the password
     */
    public function __construct($_fName, $_lName, $_userName, $_password)
    {
        $this->setFName($_fName);
        $this->setLName($_lName);
        $this->setUserName($_userName);
        $this->setPassword($_password);
        $this->setUserNum(NULL);

    }

    /**
     * @return first name
     */
    public function getFName()
    {
        return $this->_fName;
    }

    /**
     * @param last name
     */
    public function setFName($fName)
    {
        $this->_fName = $fName;
    }

    /**
     * @return last name
     */
    public function getLName()
    {
        return $this->_lName;
    }

    /**
     * @param last name
     */
    public function setLName($lName)
    {
        $this->_lName = $lName;
    }

    /**
     * @return the user name
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * @param  $userName the user name
     */
    public function setUserName($userName)
    {
        $this->_userName = $userName;
    }

    /**
     * @return the password
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param  $password the password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return the userNum
     */
    public function getUserNum()
    {
        return $this->_userNum;
    }

    /**
     * @param  $_userNum the userNum in the database
     */
    public function setUserNum($_userNum)
    {
        $this->_userNum = $_userNum;
    }




}
