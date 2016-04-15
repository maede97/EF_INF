<?php
//Session starten, danach destroyen: Alle lokalen Daten werden gelöscht
session_start();
session_destroy();
header("Location: ../index.php?site=home");
exit;
?>