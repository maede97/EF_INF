<?php

include("functions.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    //Username filtern!
    $username_data = trim($_POST['username']);
    $username_data = htmlspecialchars($username_data);
    $username_data = mysql_real_escape_string($username_data);

    $db = new DB();

    $result = $db->selectUserInformationsFromName($username_data);
    //Alle Resultate speichern, sollte genau 1 sein, darum count($result)==1
    if (count($result) == 1) {
        //Password ver-Hash-en und überprüfen
        if (sha1($_POST['password']) == $result[0]['password']) {
            //User_ID an Session übergeben
            $_SESSION['user_id'] = $result[0]['user_id'];
            //Auf Home-Seite weiterleiten
            header("Location: http://localhost/EF_INF/index.php?site=home");
            exit;
        } else {
            //Falsches Passwort, eventuelle Sessions zurücksetzen
            unset($_SESSION['user_id']);
            //Zurück zu Login-Page
            header("Location: http://localhost/EF_INF/index.php?site=login&error=2");
            exit;
        }
    } else if (count($result) == 0) {
        //Kein Benutzer gefunden.
        unset($_SESSION['user_id']);
        header("Location: http://localhost/EF_INF/index.php?site=createAccount&error=3");

        exit;
    } else {
        //Sonst irgend was
        unset($_SESSION['user_id']);
        header("Location: http://localhost/EF_INF/index.php?site=login&error=0");
        exit;
    }

    $db->closeConnection();
} else {
    //Keine Daten per POST geschickt, zurück zu Login
    unset($_SESSION['user_id']);
    header("Location: http://localhost/EF_INF/index.php?site=login&error=1");
    exit;
}
?>