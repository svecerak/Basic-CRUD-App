<?php

class Entry {

    // Instance variables

    private $connection;
    private $errorArray = [];


    // Class Constructor

    public function __construct($connection) {
        $this->connection = $connection;
        $this->errorArray = [];
    }


    // Check for errors, return error message if detected 

    public function getError($error) {
        if(!in_array($error, $this->errorArray)) {
            $error = '';
        }
        return "<span class='errorMessage'>$error</span>";
    }

    // Validate Name

    function validateName($name) {
        if (empty($name)) {
           $this->errorArray[] = Errors::$emptyName;
        } elseif (!filter_var($name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
            $this->errorArray[] = Errors::$invalidName;
        } else {
            return $name;
        }
    }

    // Validate Address

    function validateAddress($address) {
        $regex = '/^[a-zA-Z0-9-. ]+$/';

        if (empty($address)) {
            $this->errorArray[] = Errors::$emptyAddress;
        } else if (!preg_match($regex, $address)) {
            $this->errorArray[] = Errors::$invalidAddress;
        } else {
            return $address;
        }
    }
    
    // Validate Salary

    function validateSalary($salary) {
        if (empty($salary)) {
            $this->errorArray[] = Errors::$emptySalary;
        } elseif (!ctype_digit($salary)) {
            $this->errorArray[] = Errors::$invalidSalary;
        } else {
            return $salary;
        }
    }


}

