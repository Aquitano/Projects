<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'search.php';

header('Content-Type: application/json');

if (isset($_POST["name"])) {
    $name = trim($_POST['name']);
    $option = filter_var($_POST['option'], FILTER_VALIDATE_INT);

    if ($option === false) {
        $option = 0;
    }

    $con = new DB();
    $data = $con->searchData($name, $option);

    echo json_encode($data);
    exit();
}

if (isset($_POST["user"])) {
    // Only allow users to view their own cart.
    if (!isset($_SESSION["userid"])) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit();
    }

    $requestedId = filter_var($_POST["user"], FILTER_VALIDATE_INT);
    $sessionId = filter_var($_SESSION["userid"], FILTER_VALIDATE_INT);

    // User can only access their own cart.
    if ($requestedId !== $sessionId) {
        http_response_code(403);
        echo json_encode(["error" => "Forbidden"]);
        exit();
    }

    $con = new DB();
    $data = $con->viewCart($sessionId);

    echo json_encode($data);
    exit();
}

http_response_code(400);
echo json_encode(["error" => "Bad request"]);
