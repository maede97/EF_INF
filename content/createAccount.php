<h1>Create Account</h1>
<hr />
<div id="loginform">
    <form action="http://localhost/EF_INF/content/checkNewAccount.php" method="POST">
        <p>
            <label>Benutzername:</label>
            <input type="text" name="username" maxlength="30">
        </p>
        <p>
            <label>Passwort:</label>
            <input type="password" name="password" maxlength="30">
        </p>
        <p>
            <label>Passwort wiederholen:</label>
            <input type="password" name="password2" maxlength="30">
        </p>
        <p>
            <button type="submit" name="go" value="los">Login</button>
        </p>
    </form>
</div>