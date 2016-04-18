<div class="title-content">
	<h1>Create Account</h1>
</div>
<div id="loginform" class="single-content">
    <form action="content/checkNewAccount.php" method="POST">
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
		<p>Bitte gib folgende Zahl unten ein: <span class="captcha"><img src="content/captcha.php" /></span></p>
		<p>
			<input name="captcha" type="text">
		</p>
		
        <p>
            <input type="submit" name="go" value="Erstellen">
        </p>
        </p>
    </form>
	<p>&nbsp;</p>
</div>