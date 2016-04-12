<?php
include("functions.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?site=login");
    exit;
}
$user_id = $_SESSION['user_id'];
/*
  1. Wörter löschen
  2. Listen löschen
  3. User löschen
  4. Weiterleiten auf logout.php um Session zu beenden
 */
$db = new DB();
$result = $db->selectListsFromId($user_id);
foreach ($result as $liste) {
    $db->deleteWords($liste['listen_id']);
}
$db->deleteLists($user_id);
$db->deleteUser($user_id);
$db->closeConnection();
header("Location: logout.php");
exit;
?>