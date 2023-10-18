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
            if(!empty($_POST)){
                $login = new Login($_POST['email'], $_POST['password']);
            }
            break;
        case $_GET['page'] == "signup":
            require_once("../components/Signup.class.php");
            require_once("layout/signup.php");
            if (!empty($_POST)) {
                $signup = new Signup($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['confirmpass']);
            }
            break;
        case $_GET['page'] == "logout":
            require_once('layout/logout.php');
            break;
    }
    ?>
</body>

</html>