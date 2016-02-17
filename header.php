<!DOCTYPE html>
<script src="scripts/jquery.js"></script>
<span>
    SchoolTool - Trainer<br />
    PHP-Projekt von Jeremy und Matthias
</span>
<a id="homeBut" href="index.php?site=home" title="Home">Home</a>
<?php
//Session starten
session_start();
if (!(isset($_SESSION['user_id']))) {
    //Interaktiver Knopf: falls eingeloggt: Profil, sonst Login
    echo "<a id='logBut' href='index.php?site=login' title='Login'>Login</a>";
} else {
    echo "<a id='logBut' href='index.php?site=profil' title='Profil'>Profil</a>";
}
?>