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
if(!(isset($_SESSION['login']) && $_SESSION['login']!="")){
	header("Location: login.php");
} else {
	//Login successfull
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
			<h1>Trainer</h1>
			<hr />
			Hier kommt eine Übersicht über alle Listen.
		</div>
		<div id="footer"></div>
    </body>
</html>