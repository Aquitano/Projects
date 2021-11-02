<?php

session_start();

// Checks if it was entered via submitting of details on details page

if (isset($_POST["submit"])) {

    // Getting inputs from Input fields

    $add_line = $_POST["add_line"];
    $city = $_POST["city"];
    $postal = $_POST["postal"];
    $country = $_POST["country"];
    $phone = $_POST["phone"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    // Checking if any input is empty (except for Telephone number -> it's optional)

    if (emptyInputLogin($add_line, $city, $postal, $country) !== false) {
        header("Location: ../account.php?error=emptyinput&site=login");
        exit();
    }

    // Adding Details to database

    addDetails($con, $phone, $add_line, $city, $postal, $country);
} else {
    header("Location: ../account.php&site=login");
    exit();
}
