<script src="scripts/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#next").click(function () {
            showSolution();
        });

        $("#sol").keypress(function (e) {
            if (e.which == 13) {
                //Check here if correct				
                document.getElementById("sol").value = "";
                getNextCard();
            }
        });

        //Hide first card
        moveLeft(0);
        getCards();
        //show first card
        getNextCard();
        startTimer();
    });

    var aktuell = 0;
    var solutions = null;
    var texts = null;
    var isShownSolution = false;
	
	

    function moveLeft(a) {
        $("#item_Container").animate({left: '15%', opacity: '0', fontSize: "100%", height: "200px", width: "350px"}, a);
    }

    function moveMiddle(a) {
        $("#item_Container").animate({left: '30%', opacity: '1', fontSize: "120%", height: "240px", width: "420px"}, a);
    }

    function moveRight(a) {
        $("#item_Container").animate({left: '50%', opacity: '0', fontSize: "100%", height: "200px", width: "350px"}, a);
    }

    function getCards() {
        solutions = <?php echo json_encode(getTranslations()); ?>;
        texts = <?php echo json_encode(getTexts()); ?>;
    }

    function showSolution() {
        $("#item_Container").animate({left: "+=150px", width: "0"}, "slow");
        $("#item_Container").promise().done(function () {
            //Wait until card ist done turning
            //Then change text
            if (!isShownSolution) {
                document.getElementById("item").innerHTML = solutions[aktuell - 1];
                isShownSolution = true;
            } else {
                document.getElementById("item").innerHTML = texts[aktuell - 1];
                isShownSolution = false;
            }

            $("#item_Container").animate({width: "420px", left: "-=150px"}, "slow");
        });
    }

    function getNextCard() {
        moveLeft("slow");
        $("#item_Container").promise().done(function () {
            //wait until card is left and invisible, then new one
            if (aktuell > texts.length - 1) {
                aktuell = 0;
            }
            var text = texts[aktuell];
            aktuell++;
            document.getElementById("item").innerHTML = text;
            isShownSolution = false;
            moveRight(0);
            moveMiddle("slow");
        });
    }
</script>
<?php
function getTexts(){
	$id = 2;
	$liste = 1;
	$woerter = array();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Select all existing tables for this user
        $stmt = $conn->prepare("SELECT woerter.wort FROM woerter, listen WHERE listen.listen_id = '$liste' AND woerter.listen_id = '$liste' AND listen.user_id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchall();
		foreach($result as $paar){
			array_push($woerter,$paar['wort']);
		}
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
	return $woerter;
	return array();
}

function getTranslations(){
	$id = 0;
	$liste = 0;
	if(isset($_SESSION) && isset($_SESSION['user_id']) && isset($_SESSION['listen'])){
		$id = $_SESSION['user_id'];
		$liste = $_SESSION['listen'];
	} else {
		header("Location: http://localhost/EF_INF/index.php?site=login");
		exit;
	}
	$translations = array();
	
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Select all existing tables for this user
        $stmt = $conn->prepare("SELECT woerter.translation FROM woerter, listen WHERE listen.listen_id = '$liste' AND woerter.listen_id = '$liste' AND listen.user_id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchall();
		foreach($result as $paar){
			array_push($translations, $paar['translation']);
		}
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
	return $translations;
}
?>
<h1>Trainer</h1>
<hr />

<!--Dies ist ein kleiner Test zur Beispielabfrage-->
<p>Nun folgt ein kleiner Test:</p>
<button id="next">Karte drehen</button>
<hr />
<input type="text" name="solution" id="sol">
<div id="item_Container">
    <span id="item"></span>
</div>