<img src="res/kzo_logo.png">
<hr />
<ul>
	<li><a href="?site=home">Home</a></li>
	<li><a href="?site=trainer">Trainer</a></li>
	<?php
		session_start();
		if(isset($_SESSION['login']) && $_SESSION['login']!=""){
			echo "<hr />";
			echo "<li><a href='?site=profil'>Profil</a></li>";
			echo "<li><a href='?site=logout'>Logout</a></li>";
		}
		else {
			echo "<li><a href='?site=login'>Login</a></li>";
		}
	?>
        <hr />
        <li><a href="?site=about">About</a></li>
</ul>