<!DOCTYPE html>
<script src="scripts/jquery.js"></script>
<script type="text/javascript">
    //Wenn Dokument geladen wird
    $(document).ready(function () {
        //Daten an Stelle im Dokument laden
        $("#header").load("header.php");
        $("#footer").load("footer.php");
        $("#menu").load("menu.php");
        //Content wird über GET gesteuert
        $("#main").load("content/" + getParamGET("site") + ".php");
		
		var error = '<?php echo getErrorMessage(); ?>';
		if(error!=""){
			alert(error);
		}
    });

    function getParamGET(param) {
        //Die GET-Parameter extrahieren, den Paramter der der Variable param entspricht zurückgeben
        var found;
        window.location.search.substr(1).split("&").forEach(function (item) {
            if (param == item.split("=")[0]) {
                found = item.split("=")[1];
            }
        });
        return found;
    }
</script>

<?php
/* Tabellen-Namen mit Kolumnen:

  user
  ----
  user_id	| username | password

  listen
  ------
  listen_id | sprache | user_id | titel

  woerter
  ---------------------
  wort_id | wort | translation | listen_id

 */

//Falls gerade Session gestartet, Datenbanken erstellen, falls noch nicht vorhanden

session_start();
if (!(isset($_SESSION['started']))) {
    $users = "CREATE TABLE IF NOT EXISTS schooltool.user (user_id INT(6) PRIMARY KEY AUTO_INCREMENT, "
            . "username VARCHAR(30) UNIQUE NOT NULL, "
            . "password TEXT NOT NULL);";
    $listen = "CREATE TABLE IF NOT EXISTS schooltool.listen (listen_id INT(6) PRIMARY KEY AUTO_INCREMENT, "
            . "sprache VARCHAR(30) NOT NULL, "
            . "user_id INT(6) NOT NULL, "
            . "titel VARCHAR(30) NOT NULL, "
            . "FOREIGN Key(user_id) REFERENCES user(user_id));";
	$woerter = "CREATE TABLE IF NOT EXISTS schooltool.woerter (wort_id INT(6) PRIMARY KEY AUTO_INCREMENT, "
            . "wort VARCHAR(60) NOT NULL, "
			. "translation VARCHAR(60) NOT NULL, "
            . "listen_id INT(6) NOT NULL, "
            . "FOREIGN Key(listen_id) REFERENCES listen(listen_id));";
	$forum = "CREATE TABLE IF NOT EXISTS schooltool.forum (entry_id INT(6) PRIMARY KEY AUTO_INCREMENT, "
			. "title VARCHAR(30) NOT NULL, "
			. "message TEXT NOT NULL, "
			. "user_id INT(6) NOT NULL, "
			. "art INT(2) NOT NULL, "
			. "datum TIMESTAMP NOT NULL, "
			. "FOREIGN KEY(user_id) REFERENCES user(user_id));";
    try {
        $db = new PDO("mysql:dbname=schooltool;host=localhost", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    //Beide SQL-Befehle ausführen
    $createUsers = $db->exec($users);
    $createListen = $db->exec($listen);
	$createWoerter = $db->exec($woerter);
	$createForum = $db->exec($forum);
    $db = null;
    $_SESSION['started'] = '1';
}

function getErrorMessage(){
	$errorMessage = array(
		'Ein Fehler ist aufgetreten.',
		'Du musst alle Felder ausfüllen.',
		'Dein Passwort ist falsch.',
		'Dieser Benutzer existiert nicht.\nDu kannst nun einen neuen Benutzer anlegen.',
		'Du musst eingeloggt sein, um diese Funktion nützen zu können.',
		'Dieser Benutzer existiert bereits.',
		'Du kannst nur XLS-Dateien hochladen.',
		'Deine Datei ist zu gross.',
		'Wir unterstützen im Moment nur Listen mit bis zu 100 Wörter.',
		'Du besitzt schon eine Liste mit demselben Titel.\nBitte wähle einen anderen.',
		'Bitte füge eine Datei hinzu.'
	);

	if(isset($_GET['error'])){
		return $errorMessage[$_GET['error']]; 
	}
	return "";
}

?>

<link rel="stylesheet" href="styles/style.css">
<html>
    <head>
        <title>SchoolTool</title>
    </head>
    <body>
        <div id="menu"></div>
        <div id="header"></div>
        <div id="main"></div>
        <div id="footer"></div>
    </body>
</html>