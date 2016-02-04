<img src="res/kzo_logo.png">
<hr />
<ul>
	<li><a href="?site=home">Home</a></li>
	
	<?php
		session_start();
		if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){
			echo "<li><a href='?site=trainer'>Trainer</a></li>";
			echo "<hr />";
			echo "<li><a href='?site=profil'>Profil</a></li>";
			echo "<li><a href='content/logout.php'>Logout</a></li>";
		}
		else {
			echo "<li><a href='?site=login'>Login</a></li>";
			echo "<li><a href='?site=createAccount'>Create Account</a></li>";
		}
	?>
        <hr />
        <li><a href="?site=about">About</a></li>
</ul>