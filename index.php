<!DOCTYPE html>
<?php
include("content/functions.php");
//Falls gerade Session gestartet, Datenbanken erstellen, falls noch nicht vorhanden
//Für weitere Infos zu den Tabellen, sehe man sich unser Lastenheft an
session_start();
if (!(isset($_SESSION['started']))) {
    $db = new DB();
	// Alle Tabellen erzeugen, falls sie noch nicht vorhanden sind.
    $db->generateUserTable();
    $db->generateListTable();
    $db->generateWordTable();
    
    $db->closeConnection();

    $_SESSION['started'] = '1';
}
$theme = 0;
if(isset($_SESSION['user_id'])){
	//Das vom Benutzer gewählte Theme abfragen
    $db = new DB();
    $theme = $db->getTheme($_SESSION['user_id'])[0]['theme'];
    $db->closeConnection();
}
//Das korrekte Theme-Style-Sheet und das immer-geltende-Style-sheet laden
echo '<link rel="stylesheet" href="styles/'. getThemeName($theme) . '.css" />';
echo '<link rel="stylesheet" href="styles/style.css" />';
?>
<script src="scripts/jquery.js"></script>
<script src="scripts/customAlert.js"></script>
<script type="text/javascript">
	function getErrorMessage(errorParam) {
		// Gibt eine Fehler-Nachricht zum jeweiligen Parameter zurück
		var errorMessages = [];
		errorMessages[0] = 'Ein Fehler ist aufgetreten.',
		errorMessages[1] = 'Du musst alle Felder ausfüllen.',
		errorMessages[2] = 'Dein Passwort ist falsch.',
		errorMessages[3] = 'Dieser Benutzer existiert nicht.\nDu kannst nun einen neuen Benutzer anlegen.',
		errorMessages[4] = 'Du musst eingeloggt sein, um diese Funktion nützen zu können.',
		errorMessages[5] = 'Dieser Benutzer existiert bereits.',
		errorMessages[6] = 'Du kannst nur XLS- und XLSX-Dateien hochladen.',
		errorMessages[7] = 'Deine Datei ist zu gross.',
		errorMessages[8] = 'Wir unterstützen im Moment nur Listen mit bis zu 100 Wörter.',
		errorMessages[9] = 'Du besitzt schon eine Liste mit demselben Titel.\nBitte wähle einen anderen.',
		errorMessages[10] = 'Bitte füge eine Datei hinzu.',
		errorMessages[11] = 'Du besitzt noch keine Tabellen.',
		errorMessages[12] = 'Die Passwörter stimmen nicht überein.',
		errorMessages[13] = 'Du hast das Captcha falsch ausgefüllt.\nBitte versuche es erneut.'
		if (errorParam == "" || errorParam > errorMessages.length) {
			return "";
		}
		return errorMessages[errorParam];
	}
	
    function getParamGET(param) {
        //Die GET-Parameter extrahieren, den Paramter der der Variable param entspricht zurückgeben
        var found="";
        window.location.search.substr(1).split("&").forEach(function (item) {
            if (param == item.split("=")[0]) {
                found = item.split("=")[1];
            }
        });
        return found;
    }
    //Wenn Dokument geladen wird
    $(document).ready(function () {
        //Daten an Stelle im Dokument laden
        $("#header").load("header.php");
        $("#footer").load("footer.php");
        $("#menu").load("menu.php");
        //Content wird über GET gesteuert
        $("#main").load("content/" + getParamGET("site") + ".php");
        
        var error = getErrorMessage(getParamGET('error'));
        if (error != "") {
            alert(error);
        }
    });
</script>
<html>
    <head>
        <title>SchoolTool</title>
        <link rel="shortcut icon" href="res/favicon.ico">
    </head>
    <body>
        <div id="back"></div>
        <div id="right">
		<a href="https://www.dropbox.com/sh/6mad7mpg6ksuha2/AABofHyKe7lMjYVp6c4a9Etya?dl=0" target="_blank">
            <img src="res/schooltool.png" />
		</a>
        </div>
        <div id="menu"></div>
        <div id="header"></div>
        <div id="main"></div>
        <div id="footer"></div>
    </body>
</html>