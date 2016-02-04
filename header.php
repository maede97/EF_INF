<!DOCTYPE html>
<script src="scripts/jquery.js"></script>
<span id="time"></span>
<span>
	SchoolTool - Trainer<br />
	PHP-Projekt von Jeremy und Matthias
</span>
<?php
session_start();
if(!(isset($_SESSION['user_id'])){
	echo "<a id='logBut' href='index.php?site=login'>Login</a>";
} else {
	echo "<a id='logBut' href='index.php?site=profil'>Profil</a>";
}
