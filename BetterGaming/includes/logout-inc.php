<?php

// Logs user out (unsets and destroys session data)

session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
exit();
