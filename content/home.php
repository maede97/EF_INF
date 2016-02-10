<h1>Home</h1>
<hr />
<p>Herzlich Willkommen auf unserer Seite!</p>
<p>Auf der linken Seite findest du das Menu.</p>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<p>Dort findest du den Vokabulartrainer!</p>";
} else {
    echo "<p>Bitte logge dich ein, um den Vokabulartrainer zu verwenden.</p>";
}
?>