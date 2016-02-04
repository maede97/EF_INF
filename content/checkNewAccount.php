<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["username"]) &&
isset($_POST["password"]) && isset($_POST["password2"]) && ($_POST['password']==$_POST['password2'])){
	//Und strings filtern!
	$username_data = $_POST['username'];
	$password_data = sha1($_POST['password']);
		
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "schooltool";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//Check if User exists:
		$stmt = $conn->prepare("SELECT user_id FROM user WHERE username = '$username_data'");
		$stmt->execute();
		$result = $stmt->fetchall();
		if(!count($result)==0){
			//Very bad
			unset($_SESSION['user_id']);
			header("Location: http://localhost/EF_INF/index.php?site=createAccount");
			exit;
		}
		
		
		$stmt = $conn->prepare("INSERT INTO user (username, password) VALUES ('$username_data', '$password_data')");
		$stmt->execute();
		
		$stmt = $conn->prepare("SELECT user_id FROM user WHERE username = '$username_data'");
		$stmt->execute();
		$result = $stmt->fetchall();
		if(count($result)==1){
			$_SESSION['user_id']=$result[0]['user_id'];
			header("Location: http://localhost/EF_INF/index.php?site=home");
			exit;
		} else if(count($result)==0) {
				//Kein Benutzer gefunden.
				unset($_SESSION['user_id']);
				header("Location: http://localhost/EF_INF/index.php?site=createAccount");
				exit;
		} else {
			unset($_SESSION['user_id']);
			header("Location: http://localhost/EF_INF/index.php?site=login");
			exit;
		}
		header("Location: http://localhost/EF_INF/index.php?site=home");
		exit;
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
} else {
	unset($_SESSION['user_id']);
	header("Location: http://localhost/EF_INF/index.php?site=createAccount");
	exit;
}
?>