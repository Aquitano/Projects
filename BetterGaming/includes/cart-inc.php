<?php

session_start();

require_once 'dbh-inc.php';
require_once 'functions-inc.php';

if (isset($_GET["addcart"])) {
    $game = $_GET["addcart"];
    $quantity = $_GET["quantity"];
    $user = $_SESSION["userid"];

    addCart($con, $game, $user, $quantity);
} else {
    if (isset($_POST["cid"])) {
        $id = $_POST["cid"];
        $quantity = $_POST["quantity"];
        $user = $_SESSION["userid"];

        updateQuantity($con, $id, $user, $quantity);
    } else {
        if (isset($_GET["removecart"])) {

            $game = $_GET["removecart"];
            $user = $_SESSION["userid"];

            removeCart($con, $game, $user);
        } else {
            header("Location: ../cart");
            exit();
        }
    }
}
