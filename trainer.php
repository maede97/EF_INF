<!DOCTYPE html>
<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#header").load("header.php");
		$("#footer").load("footer.php");
		$("#menu").load("menu.php");
		$("#next").click(function(){
			getNextCard();
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
	var titles = null;
	var texts = null;
	
	function moveLeft(a){
		$("#item").animate({left: '25%', opacity: '0', fontSize: "1em"}, a);
	}
	
	function moveMiddle(a){
		$("#item").animate({left: '50%', opacity: '1',fontSize: "2em"},a);
	}
	
	function moveRight(a){
		$("#item").animate({left: '75%', opacity: '0', fontSize: "1em"},a);
	}
	
	function getCards(){
		titles = <?php echo json_encode(getTitles()); ?>;
		texts = <?php echo json_encode(getTexts()); ?>;
	}
	
	function getNextCard(){
		moveLeft("slow");
		$("#item").promise().done(function(){
			//wait until card is left and invisible, then new one
			if(aktuell > titles.length-1){
					aktuell = 0;
			}
			var text = texts[aktuell];
			var title = titles[aktuell];
			aktuell ++;
			document.getElementById("titel").innerHTML = "<h3>"+title+"</h3>";
			document.getElementById("text").innerHTML = text;
			moveRight(0);
			moveMiddle("slow");
		});
	}
	

	
	function getTime(){
		var now = new Date();
		var hours = now.getHours();
		var minutes = now.getMinutes();
		var seconds = now.getSeconds();
		var timeValue  = ((hours < 10) ? "0" : "") + hours;
		timeValue  += ((minutes < 10) ? ":0" : ":") + minutes;
		timeValue  += ((seconds < 10) ? ":0" : ":") + seconds;
		document.getElementById("time").innerHTML = timeValue;
	}
	
	function startTimer(){
		getTime();
		setInterval(getTime,1000);
	}
</script>

<?php
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login']!="")){
	header("Location: login.php");
} else {
	//Login successfull
}

function getTexts(){
	//Später aus sql-statement auslesen und returnen.
	//Genau gleich bei getTitles()
	return array("Text der Karte 1","Text der Karte 2","Text der Karte 3");
}
function getTitles(){
	return array("Titel der Karte 1","Titel der Karte 2","Titel der Karte 3");
}

?>

<link rel="stylesheet" href="styles/style.css">
<html>
    <head>
        <title>SchoolTool - Trainer</title>
    </head>
    <body>
		<div id="menu"></div>
		<div id="header">
			<span id="time"></span>
		</div>
		<div id="main">
			<h1>Trainer</h1>
			<hr />
			Hier kommt eine Übersicht über alle Listen.
			<p>Nun folgt ein kleiner Test:</p>
			<button id="next">Nächste Karte</button>
			<div id="item">
				<span id="titel"></span>
				<hr />
				<span id="text"></span>
			</div>
			
			<input type="text" name="solution" id="sol">

		</div>
		<div id="footer"></div>
    </body>
</html>