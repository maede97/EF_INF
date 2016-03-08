<?php
session_start();
if(isset($_SESSION['user_id']) && isset($_POST) && isset($_POST['titel']) && isset($_POST['message'])){
	if(($_POST['titel']=="") && ($_POST['messsage']=="")){
		header("Location: http://localhost/EF_INF/index.php?site=forum&error=1");
		exit;
	}
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

	$message = $_POST['message'];
	$message = str_replace("\n","[NEWLINE]",$message);
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $conn->prepare("INSERT INTO forum (title, message, user_id, art) VALUES ('".$_POST['titel']."','".$message."','".$_SESSION['user_id']."',0);");
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
	header("Location: http://localhost/EF_INF/index.php?site=forum");
	exit;
} else {
	header("Location: http://localhost/EF_INF/index.php?site=forum&error=0");
	exit;
}
?>