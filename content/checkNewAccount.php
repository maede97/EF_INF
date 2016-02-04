<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password2"])){
	//Hier noch: beide Passwörter müssen gleich sein!
	//Und strings filtern!
	//und username darf noch nicht vorhanden sein!
	$username_data = $_POST['username'];
	$password_data = sha1($_POST['password']);
	
	$_SESSION['username'] = $username_data;
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "schooltool";

 try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES ('$username_data', '$password_data')");
    $stmt->execute();
	
	$stmt = $conn->prepare("SELECT user_id FROM user WHERE username = '$username_data'");
	$stmt->execute();
	$result = $stmt->fetchall();
	if(count($result)==1){
		$_SESSION['user_id']=$result[0]['user_id'];
		header("Location: http://localhost/EF_INF/index.php?site=home");		
	} else if(count($result)==0) {
			//Kein Benutzer gefunden.
			header("Location: http://localhost/EF_INF/index.php?site=createAccount");
			$_SESSION['user_id']="";
	} else {
		header("Location: http://localhost/EF_INF/index.php?site=login");
		$_SESSION['user_id']="";
	}
	header("Location: http://localhost/EF_INF/index.php?site=home");
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