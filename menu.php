<!DOCTYPE html>
<!-- KZO-Logo: Bei Klick geht in neuem Fenster (target="_blank") die KZO-Seite auf. -->
<img src="res/icon.png">
<hr />
<ul>
    <li><a href="?site=home">Home</a></li>
    <?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        //Trainer, Profil und Logout anzeigen, falls eingeloggt
        echo "<li><a href='?site=auswahl'>Trainer</a></li>";
        echo "<hr />";
        echo "<li><a href='?site=manage'>Verwalten</a></li>";
        echo "<li><a href='?site=profil'>Profil</a></li>";
        echo "<li><a href='content/logout.php'>Logout</a></li>";
    } else {
        //Login und Create Account anzeigen, falls nicht eingeloggt
        echo "<li><a href='?site=login'>Login</a></li>";
        echo "<li><a href='?site=createAccount'>Create Account</a></li>";
    }
    ?>
    <hr />
    <li><a href="?site=about">About</a></li>
</ul>
