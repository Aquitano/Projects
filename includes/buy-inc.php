<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'dbh-inc.php';
require_once 'functions-inc.php';

// Verify user is logged in.
if (!isset($_SESSION["userid"])) {
    header("Location: ../account.php?error=mustlogin&site=login");
    exit();
}

if (isset($_POST["total"])) {
    $user = sanitizeInt($_SESSION["userid"]);
    $total = filter_var($_POST["total"], FILTER_VALIDATE_FLOAT);
    $payment = sanitizeInt($_POST["payment"]);

    // Validate inputs.
    if ($user === null || $total === false || $total < 0 || $payment === null || $payment < 0 || $payment > 2) {
        header("Location: ../cart.php?error=invalidinput");
        exit();
    }

    checkout($con, $user, $total, $payment);
} else {
    header("Location: ../cart");
    exit();
}
