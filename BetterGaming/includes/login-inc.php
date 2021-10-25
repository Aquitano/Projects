<?php
// Checks if it was entered via submitting of login on login page

if (isset($_POST["submit"])) {

    // Getting inputs from Input fields


    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    // Checking if any input is empty

    if (emptyInputLogin($email, $pwd) !== false) {
        header("Location: ../account.php?error=emptyinput&site=login");
        exit();
    }

    // Checks if valid information was entered and logs user in

    loginUser($con, $email, $pwd);
} else {
    header("Location: ../account.php&site=login");
    exit();
}
