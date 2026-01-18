<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["submit"])) {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    // CSRF validation
    if (!isset($_POST["csrf_token"]) || !validateCsrfToken($_POST["csrf_token"])) {
        header("Location: ../account.php?error=csrf&site=register");
        exit();
    }

    if (emptyInputSignup($name, $email, $pwd, $pwdRepeat) !== false) {
        header("Location: ../account.php?error=emptyinput&site=register");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("Location: ../account.php?error=invalidemail&site=register");
        exit();
    }

    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("Location: ../account.php?error=nomatch&site=register");
        exit();
    }

    if (emailExists($con, $email) !== false) {
        header("Location: ../account.php?error=emailtaken&site=register");
        exit();
    }

    $pwdError = pwdSecurity($pwd);
    if ($pwdError !== false) {
        header("Location: ../account.php?error=security&pwderr=" . $pwdError . "&site=register");
        exit();
    }

    createUser($con, $name, $email, $pwd);
} else {
    header("Location: ../account.php?site=register");
    exit();
}
