<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["username"]) && isset($_POST["password"])){
	$username_data = $_POST['username'];
	$_SESSION['username'] = $username_data;
	
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
		
	} else {
		header("Location: http://localhost/EF_INF/index.php?site=login");
		$_SESSION['user_id']="";
	}
	
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
	
	
	//Danach: $_SESSION['login'] = userID
	$_SESSION['login']="1";
	//check here the data.
	//Then set the header
}
else{
	$_SESSION['login']="";
}
?>