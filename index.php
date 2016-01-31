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

//if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["username"] && $_POST["password"]){
	//Get data here via $_POST["password"] etc;
//}
?>


<?php
//Füllt die Seite mit Müll, um Ränder zu sehen.
function fill(){
	$out = "";
	for($i = 1; $i<=50; $i++){
		$out .= $i . "<br />";
	}
	return $out;
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
			<h1>Herzlich Willkommen!</h1>
			<hr />
			<h2>Dies ist eine Begrüssung! :-)</h2>
			<?php echo fill(); ?>
			<h1>Dies ist das Ende der Seite.</h1>
		</div>
		<div id="footer"></div>
    </body>
</html>