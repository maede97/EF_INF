<?php

/*
  Zuerst folgen ein paar vereinzelte Funktionen,
  danach folgt die Klasse DB.
 */

function getErrorMessage($errorParam) {
    $errorMessages = array(
        0 => 'Ein Fehler ist aufgetreten.',
        1 => 'Du musst alle Felder ausfüllen.',
        2 => 'Dein Passwort ist falsch.',
        3 => 'Dieser Benutzer existiert nicht.\nDu kannst nun einen neuen Benutzer anlegen.',
        4 => 'Du musst eingeloggt sein, um diese Funktion nützen zu können.',
        5 => 'Dieser Benutzer existiert bereits.',
        6 => 'Du kannst nur XLS-Dateien hochladen.',
        7 => 'Deine Datei ist zu gross.',
        8 => 'Wir unterstützen im Moment nur Listen mit bis zu 100 Wörter.',
        9 => 'Du besitzt schon eine Liste mit demselben Titel.\nBitte wähle einen anderen.',
        10 => 'Bitte füge eine Datei hinzu.',
        11 => 'Du besitzt noch keine Tabellen.'
    );
    if ($errorParam == null || $errorParam > count($errorMessages)) {
        return "";
    }
    return $errorMessages[$errorParam];
}

function getThemeName($themeID, $all = false)
{
    $themeArray = array(
        0 => 'default',
        1 => 'blue',
        2 => 'ice',
		3 => 'green',
		4 => 'augenkrebs'
    );
	if($all){
		return $themeArray;
	}
    if($themeID == null || $themeID > count($themeArray)){
        return "default";
    }
    
    return $themeArray[$themeID];
}

/*
  Diese Klasse beinhaltet alle Befehle für die Verbindung zur Datenbank.
 */

class DB {

    //Variabeln der Klasse
    var $host = "localhost";
    var $username = "root";
    var $password = "";
    var $database = "schooltool";
    var $connection;

    //Konstruktor
    function __construct() {
        $this->connectToDatabase();
    }

    //Verbindet mit der Datenbank
    function connectToDatabase() {
        $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!$conn) {
            $this->connection = null;
        } else {
            $this->connection = $conn;
        }
    }

    //Verbindung beenden
    function closeConnection() {
        $this->connection = null;
    }

    //Erzeugt User-Tabelle
    function generateUserTable() {
        $stmt = $this->connection->prepare("CREATE TABLE IF NOT EXISTS schooltool.user (user_id INT(6) PRIMARY KEY AUTO_INCREMENT, "
                . "username VARCHAR(30) UNIQUE NOT NULL, "
                . "password TEXT NOT NULL, "
                . "theme INT(6));");
        $stmt->execute();
        return true;
    }

    //Erzeugt Listen-Tabelle
    function generateListTable() {
        $stmt = $this->connection->prepare("CREATE TABLE IF NOT EXISTS schooltool.listen (listen_id INT(6) PRIMARY KEY AUTO_INCREMENT, "
                . "sprache VARCHAR(30) NOT NULL, "
                . "user_id INT(6) NOT NULL, "
                . "titel VARCHAR(30) NOT NULL, "
                . "FOREIGN Key(user_id) REFERENCES user(user_id));");
        $stmt->execute();
        return true;
    }

    //Erzeugt Woerter-Tabelle
    function generateWordTable() {
        $stmt = $this->connection->prepare("CREATE TABLE IF NOT EXISTS schooltool.woerter (wort_id INT(6) PRIMARY KEY AUTO_INCREMENT, "
                . "wort VARCHAR(60) NOT NULL, "
                . "translation VARCHAR(60) NOT NULL, "
                . "listen_id INT(6) NOT NULL, "
                . "FOREIGN Key(listen_id) REFERENCES listen(listen_id));");
        $stmt->execute();
        return true;
    }

    //Gibt die user_ID zum angegebenen User zurück
    function selectIdFromUsername($user) {
        $stmt = $this->connection->prepare("SELECT user_id FROM user WHERE username = :user");
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Gibt den Username zur angegebener ID zurück
    function selectUsernameFromId($id) {
        $stmt = $this->connection->prepare("SELECT username FROM user WHERE user_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Gibt das Theme zur ID zurück
    function getTheme($id) {
        $stmt = $this->connection->prepare("SELECT theme FROM user WHERE user_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Fügt einen neuen User hinzu
    function addUser($user, $pass) {
        $stmt = $this->connection->prepare("INSERT INTO user (username, password, theme) VALUES (:user, :pass, 1)");
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        return true;
    }

    //Gibt User-Informationen zurück
    function selectUserInformationsFromName($user) {
        $stmt = $this->connection->prepare("SELECT user_id, password FROM user WHERE username = :name");
        $stmt->bindParam(':name', $user);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Gibt Passwort des Users zurück
    function selectPasswordFromId($user_id) {
        $stmt = $this->connection->prepare("SELECT password FROM user WHERE user_id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Ändert Passwort eines Benutzers
    function updatePassword($user_id, $password) {
        $stmt = $this->connection->prepare("UPDATE user SET password = :password WHERE user_id = :id");
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return true;
    }

    //Ändert Theme
    function updateTheme($user_id, $theme) {
        $stmt = $this->connection->prepare("UPDATE user SET theme = :theme WHERE user_id = :id");
        $stmt->bindParam(':theme', $theme);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return true;
    }

    //Gibt alle Listen zur user_ID zurück
    function selectListsFromId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM listen WHERE user_id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Gibt Titel einer Liste aus der user_id und der listen_id zurück
    function selectListTitleFromId($user_id, $listen_id) {
        $stmt = $this->connection->prepare("SELECT titel FROM listen WHERE user_id = :id AND listen_id = :l_id");
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':l_id', $listen_id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Gibt listen_id aus user_id und Listen-Titel zurück
    function selectListId($user_id, $title) {
        $stmt = $this->connection->prepare("SELECT listen_id FROM listen WHERE user_id = :id AND titel = :titel");
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':titel', $title);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Fügt eine neue Liste hinzu aus Sprache, user_id und Titel
    function addList($sprache, $user_id, $titel) {
        $stmt = $this->connection->prepare("INSERT INTO listen (sprache, user_id, titel) VALUES (:sprache, :id, :titel)");
        $stmt->bindParam(':sprache', $sprache);
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':titel', $titel);
        $stmt->execute();
        return true;
    }

    //Fügt ein Wort einer Liste hinzu
    function addWord($wort, $translation, $listen_id) {
        $stmt = $this->connection->prepare("INSERT INTO woerter (wort, translation, listen_id) VALUES (:wort, :translation, :id)");
        $stmt->bindParam(':wort', $wort);
        $stmt->bindParam(':translation', $translation);
        $stmt->bindParam(':id', $listen_id);
        $stmt->execute();
        return true;
    }

    //Gibt alle Wörter / Übersetzungen einer Liste zurück
    function selectWordsFromId($listen_id) {
        $stmt = $this->connection->prepare("SELECT wort, translation FROM woerter WHERE listen_id = :l_id");
        $stmt->bindParam(':l_id', $listen_id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Gibt alle Wörter zurück
    function selectWords($id, $listen_id) {
        $stmt = $this->connection->prepare("SELECT woerter.wort FROM woerter, listen WHERE listen.listen_id = :l_id AND woerter.listen_id = listen.listen_id AND listen.user_id = :id");
        $stmt->bindParam(':l_id', $listen_id);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Gibt alle Übersetzungen zurück
    function selectTranslations($id, $listen_id) {
        $stmt = $this->connection->prepare("SELECT woerter.translation FROM woerter, listen WHERE listen.listen_id = :l_id AND woerter.listen_id = listen.listen_id AND listen.user_id = :id");
        $stmt->bindParam(':l_id', $listen_id);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchall();
    }

    //Löscht alle Wörter einer Liste
    function deleteWords($listen_id) {
        $stmt = $this->connection->prepare("DELETE FROM woerter WHERE listen_id = :id");
        $stmt->bindParam(':id', $listen_id);
        $stmt->execute();
        return true;
    }

    //Löscht alle Listen eines Benutzers
    function deleteLists($user_id) {
        $stmt = $this->connection->prepare("DELETE FROM listen WHERE user_id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return true;
    }

    //Löscht Benutzers
    function deleteUser($user_id) {
        $stmt = $this->connection->prepare("DELETE FROM user WHERE user_id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return true;
    }
}
?>