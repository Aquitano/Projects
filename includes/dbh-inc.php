<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
include 'variables.php';

$con = mysqli_connect($var_host, $var_username, $var_pas, $var_db);
mysqli_set_charset($con, "utf8mb4");

if (!$con) {
    error_log("Database connection failed: " . mysqli_connect_error());
    die("A database error occurred. Please try again later.");
}
