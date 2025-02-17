<?php
session_start();

// Destroy the session
session_destroy();

// Destroy the cookies
setcookie("user_id", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");

// Redirect to login page
header("Location: login.php");
exit();
?>