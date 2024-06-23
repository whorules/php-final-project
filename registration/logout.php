<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
session_destroy();

setcookie('username', '', time() - 3600, "/");

header('location: login.php');
?>
