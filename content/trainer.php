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
        solutions = <?php echo json_encode(getSolutions()); ?>;
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
session_start();
if (!isset($_SESSION['user_id'])) {
    //Funktioniert noch nicht!
    header("Location: http://localhost/EF_INF/index.php?site=home");
    exit;
}

function getTexts() {
    //Später aus sql-statement auslesen und returnen.
    //Genau gleich bei getTitles()
    return array("Text der Karte 1", "Text der Karte 2", "Text der Karte 3");
}

function getSolutions() {
    return array("Solution der Karte 1", "Solution der Karte 2", "Solution der Karte 3");
}
?>


<h1>Trainer</h1>
<hr />
Hier kommt eine Übersicht über alle Listen.
<p>Nun folgt ein kleiner Test:</p>
<button id="next">Karte drehen</button>
<hr />
<input type="text" name="solution" id="sol">
<div id="item_Container">
    <span id="item"></span>
</div>