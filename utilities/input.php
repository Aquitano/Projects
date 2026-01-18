<?php

// This script can create random product keys and add them to the database (table: product_unused_keys) according to the available stock of every game. 
// (This script should only be used for a demo of this shop)

// Prevents script from being executed
if (count(get_included_files()) == 1) exit("Direct access not permitted.");

// Starts script
session_start();

require_once 'includes/dbh-inc.php';
require_once 'functions/search.php';

$search = new DB();
$data = $search->viewData();

foreach ($data as $i) {
    $game = $i["id"];

    for ($x = 0; $x <= $i["available_stock"]; $x++) {
        $sql = "INSERT INTO product_unused_codes (`product_key`, `product_id`) VALUES (?, ?)";

        $statement = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            header("Location: ../input.php?error=statment");
            exit();
        }

        $str = rand();
        $result = strtoupper(substr(md5($str), 0, 15));
        mysqli_stmt_bind_param($statement, "si", $result, $game);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }
}

echo "Success!";

exit();
