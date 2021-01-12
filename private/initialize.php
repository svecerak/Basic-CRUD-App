<?php
    require 'db_credentials.php';
    require "functions.php";
    require 'classes/Entry.class.php';
    require 'classes/Errors.class.php';

$mysqli  = new mysqli(
    DB_SERVER, 
    DB_USERNAME, 
    DB_PASS, 
    DB_NAME
);

if(!$mysqli) {
    die("error" . $mysqli->connect->error);
} 


// Instantiate an entry

$entry = new Entry($mysqli);




