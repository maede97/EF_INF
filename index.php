﻿<?php
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

<!DOCTYPE html>
<script src="scripts/jquery.js"></script>
<script type="text/javascript">
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
    //Wenn Dokument geladen wird
    $(document).ready(function () {
        //Daten an Stelle im Dokument laden
        $("#header").load("header.php");
        $("#footer").load("footer.php");
        $("#menu").load("menu.php");
        //Content wird über GET gesteuert
        $("#main").load("content/" + getParamGET("site") + ".php");
        //Sehr hässlicher Code:
		//Per PHP wird eventuell eine Error-Nachricht ge-echo-t, diese wird dann mit dem Java-Script per Alert ausgegeben.
        var error = "<?php
		if (isset($_GET['error'])) {
			echo getErrorMessage($_GET['error']);
		} else {
			//Falls keine Fehler-Meldung angezeigt werden muss, wird ein leerer String zurück gegeben.
			echo "";
		}
		?>";
		//Falls der hässliche Teil keinen leeren String zurückgegeben hat, mache einen alert
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