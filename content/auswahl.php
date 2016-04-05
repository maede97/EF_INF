<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    //Funktioniert noch nicht!
    header("Location: http://localhost/EF_INF/index.php?site=login&error=4");
    exit;
} else {
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
		if(count($result)==0){
			echo "<h1>Achtung!</h1>";
			echo "<hr />";
			echo "<p>Du besitzt noch keine Tabellen.</p>";
			echo "<p>Du kannst sie hier hinzufügen:</p>";
			echo "<a href='http://localhost/EF_INF/index.php?site=manage#addList'>Liste hinzufügen</a>";
			exit;
		}
		echo "<h1>Vorbereitung</h1>";
		echo "<hr />";
		echo "<h2>Bitte wähle eine Tabelle</h2>";
		echo "<form method='post' name='form' action='http://localhost/EF_INF/content/startList.php'>";
		echo "<select name='listen'>";
		foreach($result as $row)
		{
		  //Print voci-tables into html table
		  echo "<option value=".$row['listen_id'].">".$row['titel']." - ";
		  echo $row['sprache']."</option>";
		}
		echo "</select>";
		echo "<input type='submit' value='Lernen'>";
		echo "</form>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
?>