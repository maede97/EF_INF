<?php
include("functions.php");

function getTexts() {
    //Die Wörter, die Übersetzungen werden weiter unten übergeben
    $id = null;
    $liste = null;
    if (isset($_SESSION) && isset($_SESSION['user_id']) && isset($_SESSION['listen'])) {
        //Auf richtige Werte stellen
        $id = $_SESSION['user_id'];
        $liste = $_SESSION['listen'];
    } else {
        header("Location: site=login&error=4");
        exit;
    }
    $woerter = array();

    $db = new DB();
    $result = $db->selectWords($id, $liste);
    //Jedes neue Wort dem wort-Array hinzufügen
    foreach ($result as $paar) {
        $wort = utf8_encode($paar['wort']);
        array_push($woerter, $wort);
    }

    $db->closeConnection();
    return $woerter;
}

function getTranslations() {
	//Die Übersetzungen
    $id = null;
    $liste = null;
    if (isset($_SESSION) && isset($_SESSION['user_id']) && isset($_SESSION['listen'])) {
        $id = $_SESSION['user_id'];
        $liste = $_SESSION['listen'];
    } else {
        header("Location: ?site=login&error=4");
        exit;
    }
    $translations = array();

    $db = new DB();
    $result = $db->selectTranslations($id, $liste);
    foreach ($result as $paar) {
        //Alle Translations dem translation-array anhängen
        $translation = utf8_encode($paar['translation']);
        array_push($translations, $translation);
    }
    $db->closeConnection();
    return $translations;
}
?>

<script src="scripts/jquery.js"></script>
<script type="text/javascript">
	//Funktionen sind am Ende vom JS-Teil
    $(document).ready(function () {
		$("#item_Container").click(function () {
			//Falls auf die Karte geklickt wurde, zeige die Lösung
			showSolution();
		});
		$("#sol").focus(); //Setze den Tastaturfokus wieder auf das Eingabe-Feld
        $("#sol").keypress(function (e) {
            if (e.which == 13) { //Enter
                //Check here if correct
                if (solutions[aktuell - 1] == document.getElementById("sol").value) {
                    //Correct
                    document.getElementById("sol").value = "";
                    getNextCard();
                } else {
                    //Not correct
                    wrong++;
                    if (wrong == 3) {
                        showSolution();
                    }
                    document.getElementById("sol").value = "";
                }
            }
        });

        //Hide first card (called when the page loads)
        moveLeft(0);
        getCards();
        //show first card
        getNextCard(false);
        startTimer();
    });

	//Variabeln
    var aktuell = 0;
    var solutions = null;
    var texts = null;
    var isShownSolution = false;
    var wrong = 0;

	//Bei den folgenden 3 Funktionen: a ist die Geschwindigkeit
	//Karte nach Links bewegen
    function moveLeft(a) {
        $("#item_Container").animate({left: '18%', opacity: '0', fontSize: "100%", height: "200px", width: "350px"}, a);
    }

	//Karte in die Mitte bewegen
    function moveMiddle(a) {
        $("#item_Container").animate({left: '34%', opacity: '1', fontSize: "120%", height: "240px", width: "420px"}, a);
    }

	//Karte nach rechts bewegen
    function moveRight(a) {
        $("#item_Container").animate({left: '50%', opacity: '0', fontSize: "100%", height: "200px", width: "350px"}, a);
    }

	//Ich will alle Karten die in der Session stehen
    function getCards() {
		<?php session_start(); //Start the Session ?>
        solutions = <?php echo json_encode(getTranslations()); ?>;
        texts = <?php echo json_encode(getTexts()); ?>;
    }
    function showSolution() {
		//Zeige die Lösung zu einer Karte (=Karte drehen)
        $("#item_Container").animate({opacity: '0'}, "middle");
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
            $("#item_Container").animate({opacity: '1'}, "middle");
        });
    }

    function getNextCard(addTable = true) {
		if(aktuell == 1){
			//If reset (aktuelle Karte = 1 = erste Karte): delete all lines of the table
			//except the first one (=header with the titles of the rows)
			var table = document.getElementById("done");
			var tableRows = table.getElementsByTagName("tr");
			var rowCount = tableRows.length;
			for(var x=rowCount-1; x>0; x--){
				table.removeChild(tableRows[x]);
			}
			
		}
		if(addTable){
			//Add the just learned word to the table at the bottom of the page,
			//including some sort of kinda-statistics
			tableRow = document.getElementById("done").appendChild(document.createElement("tr"));
			tableWort = tableRow.appendChild(document.createElement("td"));
			tableWort.innerHTML = texts[aktuell-1];
			tableSol = tableRow.appendChild(document.createElement("td"));
			tableSol.innerHTML = solutions[aktuell-1];
			tableWas = tableRow.appendChild(document.createElement("td"));
			if(wrong > 0){
				tableWas.innerHTML = wrong + " mal falsch";
			} else {
				tableWas.innerHTML = "Richtig";
			}
		}
        moveLeft("middle");
        $("#item_Container").promise().done(function () {
            //wait until card is left and invisible, then new one
            if (aktuell > texts.length - 1) {
                //Einmal fertig gelernt
				alert("Du bist fertig.\nIch starte nun mal neu.\nUnten siehst du eine Statistik.");
				aktuell = 0;
            }
            var text = texts[aktuell];
            aktuell++;
            document.getElementById("item").innerHTML = text;
            isShownSolution = false;
            moveRight(0);
            moveMiddle("middle");
        });
        wrong = 0;
    }
</script>
<!--Trainer-Seite-->
<div class="title-content">
	<h1>Trainer</h1>
</div>
<div class="single-content" style="height: 400px;">
	<div id="item_Container">
		<span id="item"></span>
	</div>
	<div class="centered">
		<input type="text" name="solution" id="sol">
	</div>
</div>
<div class="single-content centered">
	<h2>Aktuelle Session</h2>
	<table id="done">
		<tr><th width="150px">Wort</th><th width="250px">Übersetzung</th><th width="150px">Ergebnis</th></tr>
	</table>
</div>