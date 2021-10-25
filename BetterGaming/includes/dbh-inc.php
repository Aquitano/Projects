<?php

if(count(get_included_files()) ==1) exit("Direct access not permitted.");

// Connecting to database and checking if connection was successfully established

$host = '';
$dbname = '';
$user = '';
$password = '';

$con = mysqli_connect($host, $user, $password, $dbname);

if (!$con) {
    die("Could not connect to MySQL - " . mysqli_connect_error());
}
