<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["username"] && $_POST["password"]){
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['login']="1";
	//Danach: $_SESSION['login'] = userID
	
	//check here the data.
	//Then set the header
	header("Location: http://localhost/index.php?site=home");
}
else{
	$_SESSION['login']="";
}
?>

<h1>Login</h1>
<hr />
<div id="loginform">
        <form action="content/checkLogin.php" method="POST">
                <p>
                        <label>Benutzername:</label>
                        <input type="text" name="username" maxlength="30">
                </p>
                <p>
                        <label>Passwort:</label>
                        <input type="password" name="password" maxlength="30">
                </p>
                <p>
                        <button type="submit" name="go" value="los">Login</button>
                </p>
        </form>
</div>
