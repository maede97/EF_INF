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
		echo "<tr><th>Titel:</th><th>Sprache:</th></tr>";
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
    header("Location: http://localhost/EF_INF/index.php?site=login");
	//Funktioniert nicht!
    exit;
}

function showSelectionDialog(){
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
		echo "<p><form method='GET' name='liste' action='http://localhost/EF_INF/content/pdf.php'>";
		echo "<select name='liste'>";
		foreach($result as $row)
		{
		  //Print voci-tables into html table
		  echo "<option value=".$row['listen_id'].">".$row['titel']." - ";
		  echo $row['sprache']."</option>";
		}
		echo "</select>";
		echo "<input type='submit' value='PDF erhalten'>";
		echo "</form></p>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
?>
<hr />
<h2>Ideen: (noch nicht umgesetzt)</h2>
<p>Auf Tabelle klicken --> Weiterleitung zu edit.php mit Session-Param der Liste (id), dort wird id überprüft, Liste kann bearbeitet werden.</p>
<p>Tabellen können hier gelöscht werden.</p>
<hr />
<a name="printList"></a>
<h2>Tabellen ausdrucken</h2>
<p>Hier können Tabellen in PDF's verwandelt werden, um sie dann auszudrucken.</p>
<?php showSelectionDialog(); ?>
<hr />
<a name="addList"></a>
<h2>Tabelle hinzufügen</h2>
<p>Beispiel: <a href="http://localhost/EF_INF/content/uploads/example.xls">Hier klicken</a></p>
<form action="http://localhost/EF_INF/content/upload.php" method="post" enctype="multipart/form-data">
	<p>
        <p>Sprache:</p>
        <input type="text" name="language" maxlength="30">
    </p>
    <p>
		<p>Titel:</p>
		<input type="text" name="title" maxlength="30">
	</p>
	<p>
		<p>Select file to upload:</p>
		<input type="file" name="fileToUpload" accept="spreadsheet/xls">
	</p>
    <p>
		<input type="submit" value="Upload">
	</p>
 </form>
