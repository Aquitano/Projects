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

$user = sanitizeInt($_SESSION["userid"]);
if ($user === null) {
    header("Location: ../account.php?error=mustlogin&site=login");
    exit();
}

if (isset($_GET["addcart"])) {
    $game = sanitizeInt($_GET["addcart"]);
    $quantity = sanitizeInt($_GET["quantity"]);

    if ($game === null || $quantity === null || $quantity < 1 || $quantity > 100) {
        header("Location: ../cart.php?error=invalidinput");
        exit();
    }

    addCart($con, $game, $user, $quantity);
} elseif (isset($_POST["cid"])) {
    $id = sanitizeInt($_POST["cid"]);
    $quantity = sanitizeInt($_POST["quantity"]);

    if ($id === null || $quantity === null || $quantity < 1 || $quantity > 100) {
        header("Location: ../cart.php?error=invalidinput");
        exit();
    }

    updateQuantity($con, $id, $user, $quantity);
} elseif (isset($_GET["removecart"])) {
    $game = sanitizeInt($_GET["removecart"]);

    if ($game === null) {
        header("Location: ../cart.php?error=invalidinput");
        exit();
    }

    removeCart($con, $game, $user);
} else {
    header("Location: ../cart");
    exit();
}
