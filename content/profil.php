<?php
//Den Benutzernamen holen
include("functions.php");
session_start();
if (isset($_SESSION) && isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    $db = new DB();

    $result = $db->selectUsernameFromId($id);
    if (count($result) == 1) {
        $username = $result[0]['username'];
    } else {
        $username = "Error!";
    }

    $theme = getThemeName($db->getTheme($id)[0]['theme']);

    $db->closeConnection();
} else {
    header("Location: ?site=login");
    //Funktioniert nicht --> Endlosschleife?!?
    exit;
}
?>
<script type="text/javascript">
    //Funktion, um das Captcha neu zu laden
    function reloadImage() {
        //Ein neues Captcha laden, bei beiden dasselbe Bild einfügen
        document.getElementById("captcha_picture").src = "content/captcha.php?" + new Date().getTime();
        document.getElementById("captcha_picture2").src = document.getElementById("captcha_picture").src;
    }
</script>
<!--Die Profil-Seite-->
<div class="title-content">
    <h1>Profil</h1>
</div>
<div class="double-content-row">
    <div class="double-content-left">
        <p>Hier steht noch nichts.</p>
        <p>Ausser deinem Benutzernamen:</p>
        <p><b><?php echo $username; ?></b></p>
        <p>Und deine Darstellung:</p>
        <!-- Erster Buchstabe gross -->
        <p><b><?php echo ucfirst($theme); ?></b></p>
    </div>
    <div class="double-content-right">
        <h2>Darstellung wählen</h2>
        <?php
        //Den Spinner für das Theme printen
        $themes = getThemeName("", true);
        echo "<form method='post' name='form' action='content/changeTheme.php'>";
        echo "<select name='theme'>";
        $counter = 0;
        foreach ($themes as $th) {
            echo "<option value=" . $counter;
            $db = new DB();
            if ($db->getTheme($id)[0]['theme'] == $counter) {
                echo " selected";
            }
            $db->closeConnection();
            //Erster Buchstabe des Theme-Namens gross
            echo ">" . ucfirst($th) . "</option>";
            $counter++;
        }
        echo "</select>";
        echo "<input type='submit' value='Ändern'>";
        echo "</form>";
        ?>
    </div>
</div>
<!--Neues Passwort-Form-->	
<div class="double-content-row">
    <div id="newPassForm" class="double-content-left">
        <form action="content/changePassword.php" method="POST">
            <h2>Neues Passwort wählen</h2>
            <p>
                <label>Altes Passwort:</label>
                <input type="password" name="old" placeholder=" Altes Passwort" maxlength="30">
            </p>
            <p>
                <label>Neues Passwort:</label>
                <input type="password" name="new" placeholder="Neues Passwort" maxlength="30">
            </p>
            <p>
                <label>Neues Passwort wiederholen:</label>
                <input type="password" name="new2" placeholder="Neues Passwort" maxlength="30">
            </p>
            <p>Bitte gib folgenden Code unten ein:<br />
                <span class="captcha" onclick="reloadImage(1)">
                    <img id="captcha_picture" src="content/captcha.php" />
                </span>
            </p>
            <p>
                <input name="captcha" placeholder="Captcha" type="text">
            </p>
            <p>
                <button type="submit" name="go" value="los">Bestätigen</button>
            </p>
        </form>
        <p>&nbsp;</p>
    </div>
    <!--Account-löschen-Form-->
    <div class="double-content-right">
        <h2>Account löschen</h2>
        <p>Willst du deinen Account endgültig löschen?</p>
        <form action="content/deleteAccount.php" method="post">
            <p>Bitte gib folgenden Code unten ein:<br />
                <span class="captcha" onclick="reloadImage(2)">
                    <img id="captcha_picture2" src="content/captcha.php" />
                </span>
            </p>
            <p>
                <input name="captcha" placeholder="Captcha" type="text">
            </p>
            <p>
                <input type="submit" value="Bestätigen">
            </p>
        </form>
        <p>&nbsp;</p>
    </div>
</div>