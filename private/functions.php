<?php

function isValidId($id) {
    return (isset($_GET[$id]) && !empty(trim($_GET[$id]))) ;
}

function isPostRequest() {
    return $_SERVER['REQUEST_METHOD'] == "POST";
}

function sanitizedString($input) {
    $result = trim($_POST[$input]);
    return $result;
}

function redirectTo($location) {
    header("Location:" . $location);
    exit;
}

function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo htmlspecialchars($_POST[$name]);
    }
}

function escaped($string="") {
    return htmlspecialchars($string);
  }


