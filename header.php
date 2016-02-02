<!DOCTYPE html>
<script src="scripts/jquery.js"></script>
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
<span id="time"></span>
<span>
	SchoolTool - Trainer<br />
	PHP-Projekt von Jeremy und Matthias
</span>
<?php
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login']!="")){
	echo "<a id='logBut' href='index.php?site=login'>Login</a>";
} else {
	echo "<a id='logBut' href='index.php?site=profil'>Profil</a>";
}
