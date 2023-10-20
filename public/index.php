<?php

// Check if user is logged in
session_start();

// Create session token each session

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (
    !isset($_SESSION['userid']) &&
    $_GET['page'] !== "login" &&
    $_GET['page'] !== "signup" &&
    $_GET['page'] !== "logout" &&
    $_GET['page'] !== "404"
) {
    header("Location: /login");
    exit();
}


// Require html and database
require_once("../helper.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="images/favicon.png">
    <link rel="stylesheet" href="style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teddy Cloud</title>
</head>

<body>
    <?php
    // Check which page to display
    switch ($_GET['page']) {
        case "login":
            require_once("../components/Login.class.php");
            require_once("../view/layout/login.php");
            if (!empty($_POST)) {
                // Prevent cross site request forgery attacks
                if (!empty($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
                    $login = new Login($_POST['email'], $_POST['password']);
                } else {
                    echo "<p>Cross site request forgery (CSRF) is not allowed</p>";
                }
            }
            break;
        case "signup":
            require_once("../components/Signup.class.php");
            require_once("../view/layout/signup.php");
            if (!empty($_POST)) {
                // Prevent cross site request forgery attacks
                if (!empty($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
                    $signup = new Signup($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['confirmpass']);
                } else {
                    echo "<p>Cross site request forgery (CSRF) is not allowed</p>";
                }
            }
            break;
        case "logout":
            require_once('../view/layout/logout.php');
            break;
        case "index.php":
            require_once('../components/Files.class.php');
            require_once('../view/layout/navbar.php');
            if (!empty($_FILES)) {
                $fileupload = new Files();
            }
            break;
        case "404":
            require_once("../view/layout/404.php");
            break;
        default:
            header("location: /404");
            break;
    }

    ?>
</body>

</html>