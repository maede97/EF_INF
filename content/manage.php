<h1>Verwalten</h1>
<hr />
<?php
//Idee:
//Tabellen erzeugen, löschen, bearbeiten

session_start();
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Select all existing tables for this user
        $stmt = $conn->prepare("SELECT * FROM listen WHERE user_id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchall();
		
		echo "<h2>Deine Tabellen:</h2>";
		echo "<table>"; 
		echo "<tr><th>Name:</th><th>Sprache:</th></tr>";
		foreach($result as $row)
		{
		  //Print voci-tables into html table
		  echo "<tr><td>"; 
		  echo $row['titel'];
		  echo "</td><td>";   
		  echo $row['sprache'];
		  echo "</td></tr>";  
		}
		echo "</table>";
		
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    header("Location: http://localhost/EF_INF/content/logout.php");
    exit;
}
?>
<hr />
<h2>Ideen:</h2>
<p>Auf Tabelle klicken --> Weiterleitung zu edit.php mit get-Param der Liste (id oder name), dort wird id/name überprüft, Liste kann bearbeitet werden.</p>
<p>Tabellen könnnen hier gelöscht / hinzugefügt werden.</p>
<hr />
<h2>Tabelle hinzufügen</h2>
<p>Beispiel: <a href="http://localhost/EF_INF/content/uploads/example.xls">Hier klicken</a></p>
<form action="http://localhost/EF_INF/content/upload.php" method="post" enctype="multipart/form-data">
	<p>
        <label>Sprache:</label>
        <input type="text" name="language" maxlength="30">
    </p>
    <p>
		<label>Titel:</label>
		<input type="text" name="title" maxlength="30">
	</p>
	<p>
		<label>Select file to upload:</label>
		<input type="file" name="fileToUpload" accept="spreadsheet/xls">
	</p>
    <p>
		<input type="submit" value="Upload">
	</p>
 </form>
