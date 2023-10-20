<?php

if (!empty($_SESSION['userid'])) {
    header("location: ./");
    exit();
}

?>

<form action="login" method="post">
    <label for="email">Email</label>
    <p></p>
    <input type="email" autocomplete="email" <?php if (!empty($_SESSION['email'])) echo "value='" . htmlspecialchars($_SESSION['email']) . "'"; ?> required name="email" id="email">
    <p></p>
    <label for="password">Password</label>
    <p></p>
    <input type="password" required name="password" id="password">
    <p></p>
    <button type="submit">Confirm Login</button>
    <input type="text" <?php echo "value='" . $_SESSION["token"] . "'" ?> hidden name="token" id="token">
</form>
<a href="signup">Sign up instead</a>

<?php

if (!empty($_SESSION['errorslogin'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }
}

?>