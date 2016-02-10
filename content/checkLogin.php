<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    $username_data = $_POST['username'];

    //Daten für Datenbank
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        //Eine Verbindung aufbauen
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Alle User mit Username von POST abfragen
        $stmt = $conn->prepare("SELECT user_id, password FROM schooltool.user WHERE username = '$username_data';");
        $stmt->execute();
        $result = $stmt->fetchall();
        //Alle Resultate speichern, sollte genau 1 sein, darum count($result)==1
        if (count($result) == 1) {
            //Password ver-Hash-en und überprüfen
            if (sha1($_POST['password']) == $result[0]['password']) {
                //User_ID an Session übergeben
                $_SESSION['user_id'] = $result[0]['user_id'];
                //Auf Home-Seite weiterleiten
                header("Location: http://localhost/EF_INF/index.php?site=home");
                exit;
            } else {
                //Falsches Passwort, eventuelle Sessions zurücksetzen
                unset($_SESSION['user_id']);
                //Zurück zu Login-Page
                header("Location: http://localhost/EF_INF/index.php?site=login");
                exit;
            }
        } else if (count($result) == 0) {
            //Kein Benutzer gefunden.
            unset($_SESSION['user_id']);
            header("Location: http://localhost/EF_INF/index.php?site=createAccount");
            exit;
        } else {
            //Sonst irgend was
            unset($_SESSION['user_id']);
            header("Location: http://localhost/EF_INF/index.php?site=login");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    //Verbindung zurücksetzen
    $conn = null;
} else {
    //Keine Daten per POSt geschickt, zurück zu Login
    unset($_SESSION['user_id']);
    header("Location: http://localhost/EF_INF/index.php?site=login");
    exit;
}
?>