<script src="scripts/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		document.getElementById("newEntrySpan").style.display = "none";
        $("#addEntry").click(function () {
			document.getElementById("newEntrySpan").style.display = "block";
			document.getElementById("addEntry").style.display = "none";
		});
	});
</script>

<?php
session_start();

function getForumEntrys(){
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT forum.title, forum.message, forum.datum, user.username FROM forum, user WHERE user.user_id = forum.user_id AND forum.art=0 ORDER BY forum.entry_id DESC;");
        $stmt->execute();
        $result = $stmt->fetchall();
		if(count($result)==0){
			echo "<h3>Noch keine Einträge vorhanden.</h3>";
		}
		foreach($result as $entry)
		{
		  //Print forum entry
		  echo "<h3><font size='5'>".$entry['title']."</font><font size='3'> - ".$entry['username']." (".$entry['datum'].")</font></h3>";
		  $message = $entry['message'];
		  $message = str_replace("[NEWLINE]","<br />",$message);
		  echo "<p>".$message."</p>";
		  echo "<hr />";
		}
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

function getAnnouncements(){
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $conn->prepare("SELECT title, message, datum FROM forum WHERE art=1 ORDER BY entry_id DESC;");
        $stmt->execute();
        $result = $stmt->fetchall();
		if(count($result)==0){
			echo "<h3>Noch keine Einträge vorhanden.</h3>";
		}
		foreach($result as $entry)
		{
		  //Print forum entry
		  echo "<h3><font size='5'>".$entry['title']."</font><font size='3'> (".$entry['datum'].")</font></h3>";
		  $message = $entry['message'];
		  $message = str_replace("[NEWLINE]","<br />",$message);
		  echo "<p>".$message."</p>";
		  echo "<hr />";
		}
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

function newEntry(){
	if(isset($_SESSION['user_id'])){
		//Print a span with a form to enter a new entry for the forum
		echo "<button id='addEntry'>Neuen Eintrag</button>";
		echo "<span id='newEntrySpan'>";
		echo "<h2>Eintrag verfassen</h2>";
		echo "<hr />";
		echo "<form action='http://localhost/EF_INF/content/forumEntry.php' method='POST'>";
        echo "<p>";
        echo "<label>Titel:</label>";
        echo "<input type='text' name='titel' maxlength='30'>";
        echo "</p>";
        echo "<p>";
        echo "<label>Nachricht:</label>";
        echo "<textarea rows='4' cols='50' name='message' />";
        echo "</p>";
		echo "<p>";
        echo "<button type='submit' style='position: relative;'>Absenden</button>";
        echo "</p>";
		echo "</form>";
		echo "<hr />";
		echo "</span>";
	}
}
?>
<h1>Forum</h1>
<hr />
<div id="forum_parent">
    <div id="forum_left">
		<h2>Announcements</h2>
		<hr />
		<?php getAnnouncements(); ?>
    </div>
    <div id="forum_right">
		<?php newEntry(); ?>
		<h2>User-Entries</h2>
		<hr />
		<?php getForumEntrys(); ?>
    </div>
</div>