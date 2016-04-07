<?php
include("functions.php");
session_start();
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["old"]) &&
        isset($_POST["new"]) && isset($_POST["new2"])
		&& isset($_SESSION['user_id'])) {
	if($_POST['new'] != $_POST['new2']){
		header("Location: http://localhost/EF_INF/index.php?site=profil&error=0");
		exit;
	}
    $user_id = $_SESSION['user_id'];
	
	$db = new DB();
	$result = $db->selectPasswordFromId($user_id);
	if(($result[0]['password']==sha1($_POST['old'])) && ($_POST['new'] == $_POST['new2'])){
		$db->updatePassword($user_id, sha1($_POST['new']));
	} else {
		header("Location: http://localhost/EF_INF/index.php?site=profil&error=0");
		exit;
	}
	$db->closeConnection();
	header("Location: http://localhost/EF_INF/index.php?site=profil");
    exit;
} else {
    unset($_SESSION['user_id']);
    header("Location: http://localhost/EF_INF/index.php?site=login&error=0");
    exit;
}
?>