<!--Neuen Account-Form-->
<script type="text/javascript">
    //Lädt das Captcha neu
    function reloadImage() {
        document.getElementById("captcha_picture").src = "content/captcha.php?" + new Date().getTime();
    }
</script>
<div class="title-content">
    <h1>Create Account</h1>
</div>
<div id="loginform" class="single-content">
    <form action="content/checkNewAccount.php" method="POST">
        <p>
            <label>Benutzername:</label>
            <input type="text" name="username" placeholder="Benutzername" maxlength="30">
        </p>
        <p>
            <label>Passwort:</label>
            <input type="password" name="password" placeholder="Passwort" maxlength="30">
        </p>
        <p>
            <label>Passwort wiederholen:</label>
            <input type="password" name="password2" placeholder="Passwort" maxlength="30">
        </p>
        <p>
            Bitte gib folgenden Code unten ein:
            <span class="captcha" id="captcha_span" onclick="reloadImage()">
                <img id="captcha_picture" src="content/captcha.php" />
            </span>
        </p>
        <p>
            <input name="captcha" type="text" placeholder="Captcha">
        </p>

        <p>
            <input type="submit" name="go" value="Erstellen">
        </p>
        </p>
    </form>
    <p>&nbsp;</p>
</div>