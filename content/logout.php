<?php
	session_start();
	session_destroy();
	header("Location: http://localhost/EF_INF/index.php?site=home");
	exit;
?>