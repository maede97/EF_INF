<img src="res/kzo_logo.png">
<hr />
<ul>
	<li><a href="index.php">Home</a></li>
	<li><a href="trainer.php">Trainer</a></li>
	<?php
		session_start();
		if(isset($_SESSION['login']) && $_SESSION['login']!=""){
			echo "<hr />";
			echo "<li><a href='profil.php'>Profil</a></li>";
			echo "<li><a href='logout.php'>Logout</a></li>";
		}
		else {
			echo "<li><a href='login.php'>Login</a></li>";
		}
	?>
</ul>