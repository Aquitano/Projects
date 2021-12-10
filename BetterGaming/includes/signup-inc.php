<?php

// Checks if it was entered via submitting of information on register page

if (isset($_POST["submit"])) {

    // Getting inputs from Input fields

    $name = $_POST["name"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    // Checking if any input is empty


    if (emptyInputSignup($name, $email, $pwd, $pwdRepeat) !== false) {
        header("Location: ../account.php?error=emptyinput&site=register");
        exit();
    }

    // Checking if entered email is valid

    if (invalidEmail($email) !== false) {
        header("Location: ../account.php?error=invalidemail&site=register");
        exit();
    }

    // Checking if the two entered passwords match

    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("Location: ../account.php?error=nomatch&site=register");
        exit();
    }

    // Checking if user if entered email already exists

    if (emailExists($con, $email) !== false) {
        header("Location: ../account.php?error=emailtaken&site=register");
        exit();
    }

    // Checking if password meets security standards

    if (pwdSecurity($pwd) !== false) {
        header("Location: ../account.php?error=security?site=register");
        exit();
    }

    // Adding user to database

    createUser($con, $name, $email, $pwd);
} else {
    header("Location: ../account.php&site=register");
    exit();
}
