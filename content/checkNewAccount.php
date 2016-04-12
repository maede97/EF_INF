<?php

//Include Database-Function-PHP-File
include('functions.php');
session_start();
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["username"]) &&
        isset($_POST["password"]) && isset($_POST["password2"]) && ($_POST['password'] == $_POST['password2'])) {
    //Und strings filtern!
    $username_data = trim($_POST['username']);
    $username_data = htmlspecialchars($username_data);
    $username_data = mysql_real_escape_string($username_data);
    $password_data = sha1($_POST['password']);

    $db = new DB();
    if (!count($db->selectIdFromUsername($username_data)) == 0) {
        unset($_SESSION['user_id']);
        header("Location: ../index.php?site=createAccount&error=5");
        exit;
    }
    $db->addUser($username_data, $password_data);
    $result = $db->selectIdFromUsername($username_data);
    if (count($result) == 1) {
        $_SESSION['user_id'] = $result[0]['user_id'];
        header("Location: ../index.php?site=home");
        exit;
    } else if (count($result) == 0) {
        //Kein Benutzer gefunden.
        unset($_SESSION['user_id']);
        header("Location: ../index.php?site=createAccount&error=0");
        exit;
    } else {
        unset($_SESSION['user_id']);
        header("Location: ../index.php?site=login&error=0");
        exit;
    }
    $db->closeConnection();
    header("Location: ../index.php?site=home");
    exit;
} else {
    unset($_SESSION['user_id']);
    header("Location: ../index.php?site=createAccount&error=1");
    exit;
}
?>