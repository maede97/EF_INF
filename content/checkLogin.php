<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["username"]) && isset($_POST["password"])){
	$username_data = $_POST['username'];
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "schooltool";

	 try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT user_id, password FROM schooltool.user WHERE username = '$username_data';");
		$stmt->execute();
		$result = $stmt->fetchall();
		if(count($result)==1){
			if(sha1($_POST['password'])==$result[0]['password']){
				echo "Correct";
				$_SESSION['user_id']=$result[0]['user_id'];
				header("Location: http://localhost/EF_INF/index.php?site=home");
			} else {
				header("Location: http://localhost/EF_INF/index.php?site=login");
				$_SESSION['user_id']="";
			}
			
		} else if(count($result)==0) {
			//Kein Benutzer gefunden.
			header("Location: http://localhost/EF_INF/index.php?site=createAccount");
			$_SESSION['user_id']="";
		} else {
			header("Location: http://localhost/EF_INF/index.php?site=login");
			$_SESSION['user_id']="";
		}
		
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
} else{
	$_SESSION['user_id']="";
}
?>