<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_POST) && isset($_POST['listen'])) {
	//Die Listen-ID in die Session schreiben, damit sie im Trainer wieder geholt werden kann
    $_SESSION['listen'] = $_POST['listen'];
    header("Location: ../index.php?site=trainer");
    exit;
} else {
    header("Location: ../index.php?site=login&error=4");
    exit;
}
?>