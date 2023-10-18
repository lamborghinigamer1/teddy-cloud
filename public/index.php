<?php

// Check if user is logged in
session_start();

// Create session token each session

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (empty($_SESSION['userid']) && $_GET['page'] !== "login" && $_GET['page'] !== "signup" && $_GET['page'] !== "logout") {
    header("location:" . $_SERVER['REQUEST_URI'] . "login");
    exit();
}

// Require html and database
require_once("../helper.php");

?>