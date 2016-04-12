<h1>Verwalten</h1>
<hr />
<?php
include("functions.php");
session_start();
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    $db = new DB();
    $result = $db->selectListsFromId($id);
    if (count($result) == 0) {
        echo "<h2>Du besitzt noch keine Tabellen.</h2>";
    } else {
        echo "<h2>Deine Tabellen:</h2>";
        echo "<table>";
        echo "<tr><th>Titel:</th><th>Sprache:</th></tr>";
        foreach ($result as $row) {
            //Print voci-tables into html table
            echo "<tr><td>";
            echo $row['titel'];
            echo "</td><td>";
            echo $row['sprache'];
            echo "</td></tr>";
        }
        echo "</table>";
    }
    $db->closeConnection();
} else {
    header("Location: ?site=login");
    //Funktioniert nicht!
    exit;
}

function showSelectionDialog() {
    $id = $_SESSION['user_id'];

    $db = new DB();
    $result = $db->selectListsFromId($id);
    if (count($result) == 0) {
        echo "<p>Du besitzt noch keine Tabellen.</p>";
    } else {
        echo "<p><form method='GET' name='liste' action='content/pdf.php'>";
        echo "<select name='liste'>";
        foreach ($result as $row) {
            //Print voci-tables into html table
            echo "<option value=" . $row['listen_id'] . ">" . $row['titel'] . " - ";
            echo $row['sprache'] . "</option>";
        }
        echo "</select>";
        echo "<input type='submit' value='PDF erhalten' title='PDF anfordern'>";
        echo "</form></p>";
    }
    $db->closeConnection();
}
?>
<hr />
<a name="printList"></a>
<h2>Tabellen ausdrucken</h2>
<p>Hier können Tabellen in PDF's verwandelt werden, um sie dann auszudrucken.</p>
<?php showSelectionDialog(); ?>
<hr />
<a name="addList"></a>
<h2>Tabelle hinzufügen</h2>
<p>Vorlage: <a href="content/uploads/example.xls" title="Vorlage herunterladen">Hier klicken</a></p>
<form action="content/upload.php" method="post" enctype="multipart/form-data">
    <p>
    <p>Sprache:</p>
    <input type="text" name="language" maxlength="30">
    </p>
    <p>
    <p>Titel:</p>
    <input type="text" name="title" maxlength="30">
    </p>
    <p>
    <p>Wähle die Datei:</p>
    <input type="file" name="fileToUpload" accept="spreadsheet/xls">
    </p>
    <p>
        <input type="submit" value="Upload" title="Hochladen">
    </p>
</form>