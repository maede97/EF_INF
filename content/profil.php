<?php
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
    header("Location: http://localhost/EF_INF/index.php?site=login");
    //Funktioniert nicht --> Endlosschleife!!!
    exit;
}
?>
<h1>Profil</h1>
<hr />
<p>Hier steht noch nichts.</p>
<p>Ausser deinem Benutzernamen:</p>
<p><b><?php echo $username; ?></b></p>
<p>Und deinem Theme:</p>
<p><b><?php echo $theme; ?></b></p>
<hr />
<h2>Account löschen</h2>
<p>Willst du deinen Account endgültig löschen?</p>
<p><a href="content/deleteAccount.php">Bestätigen</a></p>
<hr />
<h2>Neues Passwort wählen</h2>
<div id="newPassForm">
    <form action="content/changePassword.php" method="POST">
        <p>
            <label>Altes Passwort:</label>
            <input type="password" name="old" maxlength="30">
        </p>
        <p>
            <label>Neues Passwort:</label>
            <input type="password" name="new" maxlength="30">
        </p>
        <p>
            <label>Neues Passwort wiederholen:</label>
            <input type="password" name="new2" maxlength="30">
        </p>
        <p>
            <button type="submit" name="go" value="los">Bestätigen</button>
        </p>
    </form>
</div>