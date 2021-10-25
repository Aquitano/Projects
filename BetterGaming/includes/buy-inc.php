<?php

session_start();

require_once 'dbh-inc.php';
require_once 'functions-inc.php';

if (isset($_POST["total"])) {
    $user = $_SESSION["userid"];
    $total = $_POST["total"];
    $payment = $_POST["payment"];

    checkout($con, $user, $total, $payment);
} else {
    header("Location: ../cart");
    exit();
}
