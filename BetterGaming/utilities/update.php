<?php

// Prevents script from being executed
if (count(get_included_files()) == 1) exit("Direct access not permitted.");

// Starts script
session_start();

require_once '../includes/dbh-inc.php';

for ($x = 0; $x <= 72; $x++) {
    $sql = "UPDATE order_item SET product_code = ? WHERE id = ?";

    $statement = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../input.php?error=statment");
        exit();
    }

    $str = rand();
    $result = strtoupper(substr(md5($str), 0, 15));
    echo $result;
    mysqli_stmt_bind_param($statement, "si", $result, $x);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
}

echo "Success!";

exit();
