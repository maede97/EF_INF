<?php
//Diese Datei wechselt das Passwort des Benutzers. Wird von der Profil-Seite aufgerufen
include("functions.php");
session_start();
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["old"]) &&
        isset($_POST["new"]) && isset($_POST["new2"]) && isset($_SESSION['user_id'])) {
    if ($_POST['new'] != $_POST['new2']) {
        header("Location: ../index.php?site=profil&error=12");
        exit;
    }
	//Testen ob irgendwas leer ist
	if($_POST['new'] == ""){
		header("Location: ../index.php?site=profil&error=1");
		exit;
	}
	//Testen ob Captcha richtig ist
	if(!isset($_POST["captcha"])||$_POST["captcha"]==""||$_SESSION["code"]!=$_POST["captcha"])
	{
		header("Location: ../index.php?site=profil&error=13");
		exit;
	}

    $user_id = $_SESSION['user_id'];

    $db = new DB();
    $result = $db->selectPasswordFromId($user_id);
    if (($result[0]['password'] == sha1($_POST['old'])) && ($_POST['new'] == $_POST['new2'])) {
        $db->updatePassword($user_id, sha1($_POST['new']));
    } else {
        header("Location: ../index.php?site=profil&error=12#newPass");
        exit;
    }
    $db->closeConnection();
    header("Location:  ../index.php?site=profil");
    exit;
} else {
    unset($_SESSION['user_id']);
    header("Location: ../index.php?site=login&error=0");
    exit;
}
?>