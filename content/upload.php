<?php

include("functions.php");
session_start();
//PHPExcel implementieren
include '.\\PHPExcel\\PHPExcel\\IOFactory.php';

//Falls alle POST-Daten gesetzt
if (isset($_POST) && isset($_POST["title"]) && isset($_POST["language"]) && isset($_SESSION['user_id']) && $_POST['title'] != "" && $_POST['language'] != "") {
    //Check if user gave a file
    if (!isset($_FILES['fileToUpload'])) {
        $uploadOk = 0;
        header("Location: ../index.php?site=manage&error=10#addList");
        exit;
    }
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        unlink($target_file);
        header("Location: ../index.php?site=manage&error=0#addList");
        exit;
    }
    $u_id = $_SESSION['user_id'];
    $titel = $_POST['title'];
    $db = new DB();
    $result = $db->selectListId($u_id, $titel);

    if (count($result) != 0) {
        $uploadOk = 0;
        unlink($target_file);
        header("Location: ../index.php?site=manage&error=10#addList");
        exit;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $uploadOk = 0;
        unlink($target_file);
        header("Location: ../index.php?site=manage&error=7#addList");
        exit;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header("Location: ../index.php?site=manage&error=1#addList");
        exit;
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //Did work

            $fileExtension = pathinfo($target_file, PATHINFO_EXTENSION);
            $excelFileType = PHPExcel_IOFactory::identify($target_file);

            // Allow certain file formats
            if (!($fileExtension == "xls" || $fileExtension == "xlsx")) {
                $uploadOk = 0;
                unlink($target_file);
                //header("Location: ../index.php?site=manage&error=6#addList");
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
                header("Location: ../index.php?site=manage&error=9#addList");
                exit;
            }

            //User bekommt neue Tabellen_ID
            $u_id = $_SESSION['user_id'];
            $titel = $_POST['title'];
            $sprache = $_POST['language'];
            //öäü entfernen und umwandeln
            $titel = htmlentities($titel);
            $sprache = htmlentities($sprache);
            //Dem User die neue Liste hinzufügen
            $db->addList($sprache, $u_id, $titel);
            //Die neue listen_id holen
            $result = $db->selectListId($u_id, $titel);
            if (count($result) == 1) {
                $listen_id = $result[0]['listen_id'];
            } else {
                header("Location: ../index.php?site=manage&error=20#addList");
                exit;
            }

            //Daten in Tabelle einfügen
            for ($i = 1; $i <= $rowCount; $i++) {
                $wort = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i);
                $translation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i);
                $wort = utf8_decode($wort);
                $translation = utf8_decode($translation);

                //Jedes Wort in Liste einfügen
                $db->addWord($wort, $translation, $listen_id);
            }

            //Datei wieder löschen
            unlink($target_file);
            //exit;
            $db->closeConnection();

            header("Location: ../index.php?site=manage");
            exit;
        } else {
            header("Location: ../index.php?site=manage&error=0#addList");
            exit;
        }
    }
} else {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php?site=login&error=4");
        exit;
    }
    header("Location: ../index.php?site=manage&error=1#addList");
    exit;
}
?> 