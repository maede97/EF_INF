<?php

//Session starten, danach destroyen: Alle lokalen Daten werden gelöscht
session_start();
session_destroy();
header("Location: http://localhost/EF_INF/index.php?site=home");
exit;
?>