<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["submit"])) {

    $email = trim($_POST["email"]);
    $pwd = $_POST["pwd"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    // CSRF validation
    if (!isset($_POST["csrf_token"]) || !validateCsrfToken($_POST["csrf_token"])) {
        header("Location: ../account.php?error=csrf&site=login");
        exit();
    }

    if (emptyInputLogin($email, $pwd) !== false) {
        header("Location: ../account.php?error=emptyinput&site=login");
        exit();
    }

    loginUser($con, $email, $pwd);
} else {
    header("Location: ../account.php?site=login");
    exit();
}
