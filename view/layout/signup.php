<form action="signup" method="post">
    <label for="firstname">First name</label>
    <p></p>
    <input type="text" name="firstname" required autocomplete="given-name" id="firstname">
    <p></p>
    <label for="lastname">Last name</label>
    <p></p>
    <input type="text" name="lastname" required autocomplete="family-name" id="lastname">
    <p></p>
    <label for="email">Email</label>
    <p></p>
    <input type="email" name="email" required autocomplete="email" id="email">
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
</form>
<a href="login">Login instead</a>