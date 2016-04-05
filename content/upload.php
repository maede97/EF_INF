<?php

session_start();
//PHPExcel implementieren
include '/opt/lampp/htdocs/EF_INF/content/PHPExcel/PHPExcel/IOFactory.php';

//Falls alle POST-Daten gesetzt
if (isset($_POST) && isset($_POST["title"]) && isset($_POST["language"]) && isset($_SESSION['user_id']) && $_POST['title'] != "" && $_POST['language'] != "") {
    //Check if user gave a file
    if (!isset($_FILES['fileToUpload'])) {
        $uploadOk = 0;
        header("Location: http://localhost/EF_INF/index.php?site=manage&error=10#addList");
        exit;
    }
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        unlink($target_file);
        header("Location: http://localhost/EF_INF/index.php?site=manage&error=0#addList");
        exit;
    }

    //check if user has already a list with this name
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
        //Listen holen
        $stmt = "SELECT listen_id FROM listen WHERE user_id = '$u_id' AND titel='$titel'";
        $go = $conn->prepare($stmt);
        $go->execute();
        $result = $go->fetchall();
        if (count($result) != 0) {
            $uploadOk = 0;
            unlink($target_file);
            header("Location: http://localhost/EF_INF/index.php?site=manage&error=10#addList");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    //Verbindung zurücksetzen
    $conn = null;

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $uploadOk = 0;
        unlink($target_file);
        header("Location: http://localhost/EF_INF/index.php?site=manage&error=7#addList");
        exit;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header("Location: http://localhost/EF_INF/index.php?site=manage&error=1#addList");
        exit;
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //Did work
            
            $fileExtension = pathinfo($target_file,PATHINFO_EXTENSION);
            $excelFileType = PHPExcel_IOFactory::identify($target_file);
            
            // Allow certain file formats
            if (!($fileExtension == "xls" || $fileExtension == "xlsx")) {
                $uploadOk = 0;
                unlink($target_file);
                //header("Location: http://localhost/EF_INF/index.php?site=manage&error=6#addList");
                exit;
            }
    
            $reader = PHPExcel_IOFactory::createReader($excelFileType);

            $reader->setReadDataOnly(true);
            $objPHPExcel = $reader->load($target_file);

            //Format:
            //Spalte 1: Deutsch
            //Spalte 2: Fremdsprache
            //rowCount = Alle Zeilen
            $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();

            if ($rowCount > 100) {
                unlink($target_file);
                header("Location: http://localhost/EF_INF/index.php?site=manage&error=9#addList");
                exit;
            }

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
                //öäü entfernen und umwandeln
                $titel = str_replace("ö", "&ouml;", $titel);
                $sprache = str_replace("ö", "&ouml;", $sprache);
                $titel = str_replace("ü", "&uuml;", $titel);
                $sprache = str_replace("ü", "&uuml;", $sprache);
                $titel = str_replace("ä", "&auml;", $titel);
                $sprache = str_replace("ä", "&auml;", $sprache);
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
                    header("Location: http://localhost/EF_INF/index.php?site=manage&error=20#addList");
                    exit;
                }

                //Daten in Tabelle einfügen
                for ($i = 1; $i <= $rowCount; $i++) {
                    $wort = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i);
                    $translation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i);
                    echo $wort. "<br />";
                    echo $translation."<br />";
                    //$wort = utf8_encode($wort);
                    //$translation = utf8_decode($translation);
                    echo $wort. "<br />";
                    echo $translation."<br />";
                    //$wort = htmlspecialchars($wort);
                    //$translation = htmlspecialchars($translation);
                    $wort = str_replace("ö","&ouml;",$wort);
                    $translation = str_replace("ö","&ouml;",$translation);
                    $wort = str_replace("ü","&uuml;",$wort);
                    $translation = str_replace("ü","&uuml;",$translation);
                    $wort = str_replace("ä","&auml;",$wort);
                    $translation = str_replace("ä","&auml;",$translation);
                    $wort = str_replace("Ö","Oe",$wort);
                    $translation = str_replace("Ö","Oe",$translation);
                    $wort = str_replace("Ü","Ue",$wort);
                    $translation = str_replace("Ü","Ue",$translation);
                    $wort = str_replace("Ä","Ae",$wort);
                    $translation = str_replace("Ä","Ae",$translation);
                    //Jedes Wort in Liste einfügen
                    $stmt = "INSERT INTO `woerter`(`wort`, `translation`, `listen_id`) VALUES ('$wort','$translation','$listen_id');";
                    $conn->exec($stmt);
                }
                
                //Datei wieder löschen
                unlink($target_file);
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            //Verbindung zurücksetzen
            $conn = null;
            header("Location: http://localhost/EF_INF/index.php?site=manage");
            exit;
        } else {
            header("Location: http://localhost/EF_INF/index.php?site=manage&error=0#addList");
            exit;
        }
    }
} else {
    if (!isset($_SESSION['user_id'])) {
        header("Location: http://localhost/EF_INF/index.php?site=login&error=4");
        exit;
    }
    header("Location: http://localhost/EF_INF/index.php?site=manage&error=1#addList");
    exit;
}
?> 