<h1>Login</h1>
<hr />
<div id="loginform">
    <form action="content/checkLogin.php" method="POST">
        <p>
            <label>Benutzername:</label>
            <input type="text" name="username" maxlength="30">
        </p>
        <p>
            <label>Passwort:</label>
            <input type="password" name="password" maxlength="30">
        </p>
        <p>
            <button type="submit" name="go" value="los">Login</button>
        </p>
    </form>
</div>
