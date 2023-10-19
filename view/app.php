<?php

require_once("../components/Database.class.php");

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
    switch (true) {
        case $_GET['page'] == "login":
            require_once("../components/Login.class.php");
            require_once("layout/login.php");
            if (!empty($_POST)) {
                // Prevent cross site request forgery attacks
                if (!empty($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
                    $login = new Login($_POST['email'], $_POST['password']);
                } else {
                    echo "<p>Cross site request forgery (CSRF) is not allowed</p>";
                }
            }
            break;
        case $_GET['page'] == "signup":
            require_once("../components/Signup.class.php");
            require_once("layout/signup.php");
            if (!empty($_POST)) {
                // Prevent cross site request forgery attacks
                if (!empty($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
                    $signup = new Signup($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['confirmpass']);
                } else {
                    echo "<p>Cross site request forgery (CSRF) is not allowed</p>";
                }
            }
            break;
        case $_GET['page'] == "logout":
            require_once('layout/logout.php');
            break;
        default:
            require_once('../components/Files.class.php');
            require_once('layout/navbar.php');
            if (!empty($_FILES)) {
                $fileupload = new Files();
            }
            break;
    }
    ?>
</body>

</html>