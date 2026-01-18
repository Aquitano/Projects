<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID to prevent session fixation.
session_regenerate_id(true);

// Clear all session data.
$_SESSION = [];

// Destroy the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session.
session_destroy();

header("Location: ../index.php");
exit();
