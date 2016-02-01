<!DOCTYPE html>
<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("#header").load("header.php");
		$("#footer").load("footer.php");
		$("#menu").load("menu.php");
	});
	function getTime(){
		var now = new Date();
		var hours = now.getHours();
		var minutes = now.getMinutes();
		var seconds = now.getSeconds();
		var timeValue  = ((hours < 10) ? "0" : "") + hours;
		timeValue  += ((minutes < 10) ? ":0" : ":") + minutes;
		timeValue  += ((seconds < 10) ? ":0" : ":") + seconds;
		document.getElementById("time").innerHTML = timeValue;
	}
	
	function startTimer(){
		getTime();
		setInterval(getTime,1000);
	}
</script>
<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["username"] && $_POST["password"]){
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['login']="1";
	//Danach: $_SESSION['login'] = userID
	
	//check here the data.
	//Then set the header
	header("Location: index.php");
}
else{
	$_SESSION['login']="";
}
?>

<link rel="stylesheet" href="styles/style.css">
<html>
    <head>
        <title>SchoolTool - Vocabular</title>
    </head>
    <body onload="startTimer()">
		<div id="menu"></div>
		<div id="header">
			<span id="time"></span>
		</div>
		<div id="main">
			<h1>Login</h1>
			<hr />
			<div id="loginform">
				<form action="<?php $_PHP_SELF ?>" method="POST">
					<p>
						<label>Benutzername:</label>
						<input type="text" name="username" maxlength="30">
					</p>
					<p>
						<label>Passwort:</label>
						<input type="password" name="password" maxlength="30">
					</p>
					<p>
						<button type="submit" name="go" value="los">Login</button>
					</p>
				</form>
			</div>
		</div>
		<div id="footer"></div>
    </body>
</html>