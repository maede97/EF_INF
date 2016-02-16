<?php
session_start();
//TODO:
//Listen-Name übergeben
//Sprachen übergeben
include 'excel_reader.php';
if(isset($_POST) && isset($_POST["title"]) && isset($_POST["language"]) && isset($_SESSION['user_id']) && $_POST['title']!="" && $_POST['language']!=""){
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$excelFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	// Check if file already exists
	if (file_exists($target_file)) {
		$uploadOk = 0;
	}
	 // Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		$uploadOk = 0;
	 }
	// Allow certain file formats
	if($excelFileType != "xls") {
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	// if everything is ok, try to upload file
		header("Location: http://localhost/EF_INF/index.php?site=manage");
	} else {	
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			//Did work
			$excel = new Spreadsheet_Excel_Reader($target_file, false);
			
			//Format:
			//Spalte 1: Deutsch
			//Spalte 2: Fremdsprache
			
			//rowCount = Alle Zeilen
			$rowCount = $excel->rowcount();
			
			//Daten für Datenbank
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "schooltool";

			try {
				//Eine Verbindung aufbauen
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//User bekommt neue Tabellen_ID
				$u_id = $_SESSION['user_id'];
				$titel = $_POST['title'];
				$sprache = $_POST['language'];
				//Dem User die neue Liste hinzufügen
				$stmt = "INSERT INTO `listen`(`sprache`, `user_id`, `titel`) VALUES ('$sprache','$u_id','$titel')";
				$conn->exec($stmt);
				//Die neue listen_id holen
				$stmt = "SELECT listen_id FROM listen WHERE user_id = '$u_id' AND titel='$titel' AND sprache='$sprache';";
				$go = $conn->prepare($stmt);
				$go->execute();
				$result = $go->fetchall();
				if (count($result) == 1) {
					$listen_id = $result[0]['listen_id'];
				} else {
					exit;
				}
				
				//Daten in Tabelle einfügen
				for($i=1;$i<=$rowCount;$i++){
					$wort = $excel->val($i,1);
					$translation= $excel->val($i,2);
					//Jedes Wort in Liste einfügen
					$stmt = "INSERT INTO `woerter`(`wort`, `translation`, `listen_id`) VALUES ('$wort','$translation','$listen_id');";
					$conn->exec($stmt);
				}
				//Datei wieder löschen
				unlink($target_file);

				
			} catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
			//Verbindung zurücksetzen
			$conn = null;
			header("Location: http://localhost/EF_INF/index.php?site=manage");
			exit;
		} else {
			header("Location: http://localhost/EF_INF/index.php?site=manage");
			exit;
		}
	}
} else {
	if(!isset($_SESSION['user_id'])){
		header("Location: http://localhost/EF_INF/index.php?site=login");
		exit;
	}
	header("Location: http://localhost/EF_INF/index.php?site=manage");
	exit;
}

?> 