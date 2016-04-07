<?php
include("functions.php");
session_start();
if (isset($_SESSION) && isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    $db= new DB();

    $result = $db->selectUsernameFromId($id);
	if (count($result) == 1) {
		$username = $result[0]['username'];
	} else {
		$username = "Error!";
	}
    
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