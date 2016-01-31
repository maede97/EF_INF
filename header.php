<!DOCTYPE html>
<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
<?php
/*
	//Create all necessary tables
	$servername = "localhost";
	$username = "root";
	$password = "";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=schooltool",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		$conn->exec("CREATE TABLE IF NOT EXISTS `users` ("
		."`u_id` int(11) unsigned NOT NULL auto_increment, "
		."`name` varchar(255) NOT NULL default '', "
		."`hash` varchar(255) NOT NULL default '', "
		."PRIMARY KEY (`u_id`)"
		.") ENGINE=MyISAM DEFAULT CHARSET=utf8");
		$conn = null;
	}catch(PDOException $e){
		echo "Conn failed. " . $e->getMessage();
	}
*/
?>
<html>
	<body>
		<span id="time"></span>
		<span>
			SchoolTool - Vocabulary <br />
			PHP-Projekt von Jeremy und Matthias
		</span>
		<a id="logBut" href="login.php">Login</a>
	</body>
</html>