<?php

include("functions.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    //Funktioniert noch nicht!
    header("Location: ?site=login&error=4");
    exit;
} else {
    $id = $_SESSION['user_id'];

    $db = new DB();

    $result = $db->selectListsFromId($id);
    if (count($result) == 0) {
		echo "<div class='title-content'>";
        echo "<h1>Achtung!</h1>";
		echo "</div>";
		echo "<div class='single-content'>";
        echo "<p>Du besitzt noch keine Tabellen.</p>";
        echo "<p>Du kannst sie hier hinzufügen:</p>";
        echo "<p><a href='?site=manage#addList'>Liste hinzufügen</a></p>";
		echo "</div>";
        exit;
    }
    echo "<div class='title-content'>";
	echo "<h1>Vorbereitung</h1>";
	echo "</div>";
    echo "<div class='single-content'>";
    echo "<h2>Bitte wähle eine Tabelle</h2>";
    echo "<form method='post' name='form' action='content/startList.php'>";
    echo "<select name='listen'>";
    foreach ($result as $row) {
        //Print voci-tables into html table
        echo "<option value=" . $row['listen_id'] . ">" . $row['titel'] . " - ";
        echo $row['sprache'] . "</option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Lernen'>";
	echo "<p>&nbsp;</p>";
    echo "</form>";
	echo "</div>";
    $db->closeConnection();
}
?>