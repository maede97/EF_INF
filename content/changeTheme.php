<?php
include("functions.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["theme"]) && isset($_SESSION['user_id'])) {
    $db = new DB();
	$db->updateTheme($_SESSION['user_id'],$_POST['theme']);
	$db->closeConnection();
	header("Location: http://localhost/EF_INF/index.php?site=profil");
	exit;
} else {
    //Keine Daten per POST geschickt, zurück zu Login
    unset($_SESSION['user_id']);
    header("Location: http://localhost/EF_INF/index.php?site=login&error=1");
    exit;
}
?>