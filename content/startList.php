<?php
session_start();
if(isset($_SESSION['user_id']) && isset($_POST) && isset($_POST['listen'])){
	$_SESSION['listen']=$_POST['listen'];
	header("Location: http://localhost/EF_INF/index.php?site=trainer");
	exit;
} else {
	header("Location: http://localhost/EF_INF/index.php?site=login&error=4");
	exit;
}
?>