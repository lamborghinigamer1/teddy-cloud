<?php

// Check if user is logged in
session_start();

if (empty($_SESSION['userid']) && $_GET['page'] !== "login" && $_GET['page'] !== "signup" && $_GET['page'] !== "logout") {
    header("location: /login");
    exit();
}

require_once("../components/Createdb.php");
require_once("../helper.php");
require_once("../components/Database.class.php");

// require html
require_once("../view/app.php");

?>