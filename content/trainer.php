<script src="scripts/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#next").click(function () {
            showSolution();
        });

        $("#sol").keypress(function (e) {
            if (e.which == 13) {
                //Check here if correct
				//solutions[aktuell-1]
				//texts[aktuell-1]
				if(solutions[aktuell-1]==document.getElementById("sol").value){
					//Correct
					document.getElementById("sol").value = "";
					document.getElementById("sol").style.background = "beige";
					getNextCard();
				} else {
					//Not correct
					wrong++;
					if(wrong==3){
						showSolution();
					}
					document.getElementById("sol").value = "";
					document.getElementById("sol").style.background = "red";
				}
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
	var wrong = 0;
	
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
		//Session starten
		<?php session_start(); ?>
		//Die Arrays mit den Wörtern holen
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
		wrong=0;
    }
</script>
<?php
function getTexts(){
	//Default-Werte
	$id = 0;
	$liste = 0;
	if(isset($_SESSION) && isset($_SESSION['user_id']) && isset($_SESSION['listen'])){
		//Auf richtige Werte stellen
		$id = $_SESSION['user_id'];
		$liste = $_SESSION['listen'];
	}
	$woerter = array();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Select all words from the word-list
        $stmt = $conn->prepare("SELECT woerter.wort FROM woerter, listen WHERE listen.listen_id = '$liste' AND woerter.listen_id = '$liste' AND listen.user_id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchall();
		//Jedes neue Wort dem wort-Array hinzufügen
		foreach($result as $paar){
			array_push($woerter,$paar['wort']);
		}
    } catch (PDOException $e) {
    }
    $conn = null;
	return $woerter;
}
function getTranslations(){

	$id = 0;
	$liste = 0;
	if(isset($_SESSION) && isset($_SESSION['user_id']) && isset($_SESSION['listen'])){
		$id = $_SESSION['user_id'];
		$liste = $_SESSION['listen'];
	}
	$translations = array();
	
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooltool";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Select all translations from this word-list
        $stmt = $conn->prepare("SELECT woerter.translation FROM woerter, listen WHERE listen.listen_id = '$liste' AND woerter.listen_id = '$liste' AND listen.user_id = '$id'");
        $stmt->execute();
        $result = $stmt->fetchall();
		foreach($result as $paar){
			//Alle Translations dem translation-array anhängen
			array_push($translations, $paar['translation']);
		}
    } catch (PDOException $e) {
    }
    $conn = null;
	return $translations;
}
?>

<h1>Trainer</h1>
<hr />

<p><div id="item_Container">
    <span id="item"></span>
</div></p>
<p><button id="next">Karte drehen</button></p>
<p><input type="text" name="solution" id="sol"></p>