<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["submit"])) {

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    // CSRF validation
    if (!isset($_POST["csrf_token"]) || !validateCsrfToken($_POST["csrf_token"])) {
        header("Location: ../account.php?error=csrf");
        exit();
    }

    // Verify user is logged in.
    if (!isset($_SESSION["userid"])) {
        header("Location: ../account.php?error=mustlogin&site=login");
        exit();
    }

    $add_line = sanitizeString($_POST["add_line"]);
    $city = sanitizeString($_POST["city"]);
    $postal = sanitizeString($_POST["postal"]);
    $country = sanitizeString($_POST["country"]);
    $phone = sanitizeString($_POST["phone"]);

    if (emptyDetails($add_line, $city, $postal, $country) !== false) {
        header("Location: ../account.php?error=emptyinput");
        exit();
    }

    addDetails($con, $phone, $add_line, $city, $postal, $country);
} else {
    header("Location: ../account.php?site=login");
    exit();
}
