<?php
include 'variables.php';
if(count(get_included_files()) ==1){ exit("Direct access not permitted.");}

// Connecting to database and checking if connection was successfully established

$con = mysqli_connect($var_host, $var_username, $var_pas, $var_db);
mysqli_set_charset($con, "utf8mb4");

if (!$con) {
    die("Could not connect to MySQL - " . mysqli_connect_error());
}
