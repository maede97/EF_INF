<?php
include("functions.php");
session_start();
if (isset($_SESSION) && isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    $db = new DB();

    $result = $db->selectUsernameFromId($id);
    if (count($result) == 1) {
        $username = $result[0]['username'];
    } else {
        $username = "Error!";
    }

    $theme = getThemeName($db->getTheme($id)[0]['theme']);

    $db->closeConnection();
} else {
    header("Location: ?site=login");
    //Funktioniert nicht --> Endlosschleife?!?
    exit;
}
?>
<div class="title-content">
	<h1>Profil</h1>
</div>
<div class="double-content-left" style="height: 300px">
	<p>Hier steht noch nichts.</p>
	<p>Ausser deinem Benutzernamen:</p>
	<p><b><?php echo $username; ?></b></p>
	<p>Und deine Darstellung:</p>
	<!-- Erster Buchstabe gross -->
	<p><b><?php echo ucfirst($theme); ?></b></p>
</div>
<div class="double-content-right" style="height: 300px">
	<h2>Darstellung wählen</h2>
	<?php
	//Den Spinner für das Theme printen
	$themes = getThemeName("", true);
	echo "<form method='post' name='form' action='content/changeTheme.php'>";
	echo "<select name='theme'>";
	$counter = 0;
	foreach ($themes as $th) {
		echo "<option value=" . $counter;
		$db = new DB();
		if($db->getTheme($id)[0]['theme']==$counter){
			echo " selected";
		}
		$db->closeConnection();
		//Erster Buchstabe des Theme-Namens gross
		echo ">".ucfirst($th)."</option>";
		$counter++;
	}
	echo "</select>";
	echo "<input type='submit' value='Ändern'>";
	echo "</form>";
	?>
</div>
<div id="newPassForm" class="double-content-left" style="height: 510px;">
	<form action="content/changePassword.php" method="POST">
		<h2>Neues Passwort wählen</h2>
		<p>
			<label>Altes Passwort:</label>
			<input type="password" name="old" maxlength="30">
		</p>
		<p>
			<label>Neues Passwort:</label>
			<input type="password" name="new" maxlength="30">
		</p>
		<p>
			<label>Neues Passwort wiederholen:</label>
			<input type="password" name="new2" maxlength="30">
		</p>
		<p>
			<button type="submit" name="go" value="los">Bestätigen</button>
		</p>
	</form>
	<p>&nbsp;</p>
</div>
<div class="double-content-right" style="height: 510px;">
	<h2>Account löschen</h2>
	<p>Willst du deinen Account endgültig löschen?</p>
	<p><a href="content/deleteAccount.php">Bestätigen</a></p>
</div>