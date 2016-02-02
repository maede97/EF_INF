<script src="scripts/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#next").click(function(){
			showSolution();
		});
		
		$("#sol").keypress(function(e){
			if(e.which==13){
				//Check here if correct				
				document.getElementById("sol").value="";
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
	var solutions= null;
	var texts = null;
	
	function moveLeft(a){
		$("#item").animate({left: '15%', opacity: '0', fontSize: "1em", height: "250px", width: "415px"}, a);
	}
	
	function moveMiddle(a){
		$("#item").animate({left: '30%', opacity: '1',fontSize: "2em", height: "300px", width: "500px"},a);
	}
	
	function moveRight(a){
		$("#item").animate({left: '50%', opacity: '0', fontSize: "1em", height: "250px", width: "415px"},a);
	}
	
	function getCards(){
		solutions= <?php echo json_encode(getSolutions()); ?>;
		texts = <?php echo json_encode(getTexts()); ?>;
	}

	function showSolution(){
		$("#item").animate({width: "0", left: "+=150px"},"slow");
		$("#item").promise().done(function(){
			//wait until card ist done turning
			//Then change text
			document.getElementById("item").innerHTML = solutions[aktuell-1];
			$("#item").animate({width: "500px", left: "-=150px"},"slow");
		});

	}
	
	function getNextCard(){
		moveLeft("slow");
		$("#item").promise().done(function(){
			//wait until card is left and invisible, then new one
			if(aktuell > texts.length-1){
					aktuell = 0;
			}
			var text = texts[aktuell];
			aktuell ++;
			document.getElementById("item").innerHTML = text;
			moveRight(0);
			moveMiddle("slow");
		});
	}
</script>

<?php
	session_start();
	if(!(isset($_SESSION['login']) && $_SESSION['login']!="")){
		//Funktioniert noch nicht!
		//header("Location: http://localhost/EF_INF/content/logout.php");
	}

function getTexts(){
	//Später aus sql-statement auslesen und returnen.
	//Genau gleich bei getTitles()
	return array("Text der Karte 1","Text der Karte 2","Text der Karte 3");
}
function getSolutions(){
	return array("Solution der Karte 1","Solution der Karte 2","Solution der Karte 3");
}

?>

       
<h1>Trainer</h1>
<hr />
Hier kommt eine Übersicht über alle Listen.
<p>Nun folgt ein kleiner Test:</p>
<button id="next">Lösung</button>
<div id="item"></div>
<input type="text" name="solution" id="sol">
