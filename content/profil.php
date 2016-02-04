<?php
session_start();
if(isset($_SESSION['user_id'])){
	$id = $_SESSION['user_id'];
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "schooltool";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//Check if User exists:
		$stmt = $conn->prepare("SELECT username FROM user WHERE user_id = '$id'");
		$stmt->execute();
		$result = $stmt->fetchall();
		if(count($result)==1){
			$username=$result[0]['username'];
		} else {
			$username="Error!";
		}
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
} else {
	header("Location: http://localhost/EF_INF/content/logout.php");
	exit;
}
?>
<h1>Profil</h1>
<hr />
<p>Hier steht noch nichts.</p>
<p>Ausser deinem Benutzernamen:</p>
<p><b><?php echo $username;?></b></p>
