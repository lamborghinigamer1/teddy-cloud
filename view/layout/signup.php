<?php

if (!empty($_SESSION['userid'])) {
    header("location: /");
    exit();
}

?>

<form action="signup" method="post">
    <label for="firstname">First name</label>
    <p></p>
    <input type="text" <?php if (!empty($_SESSION['firstname'])) echo "value='" . htmlspecialchars($_SESSION['firstname']) . "'"; ?> name="firstname" required autocomplete="given-name" id="firstname">
    <p></p>
    <label for="lastname">Last name</label>
    <p></p>
    <input type="text" <?php if (!empty($_SESSION['lastname'])) echo "value='" . htmlspecialchars($_SESSION['lastname']) . "'"; ?> name="lastname" required autocomplete="family-name" id="lastname">
    <p></p>
    <label for="email">Email</label>
    <p></p>
    <input type="email" <?php if (!empty($_SESSION['email'])) echo "value='" . htmlspecialchars($_SESSION['email']) . "'"; ?> name="email" required autocomplete="email" id="email">
    <p></p>
    <label for="password">Password</label>
    <p></p>
    <input type="password" required name="password" id="password">
    <p></p>
    <label for="password">Confirm Password</label>
    <p></p>
    <input type="password" required name="confirmpass" id="confirmpass">
    <p></p>
    <button type="submit">Confirm Sign up</button>
    <input type="text" <?php echo "value='" . $_SESSION["token"] . "'" ?> hidden name="token" id="token">
</form>
<a href="login">Login instead</a>

<?php

if (!empty($_SESSION['errorssignup'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }
}

?>