<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["username"] && $_POST["password"]){
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['login']="1";
	//Danach: $_SESSION['login'] = userID
	
	//check here the data.
	//Then set the header
	header("Location: http://localhost/index.php?site=home");
}
else{
	$_SESSION['login']="";
}
?>