<script src="scripts/jquery.js"></script>
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
		$("#item").animate({left: '15%', opacity: '0', fontSize: "1em"}, a);
	}
	
	function moveMiddle(a){
		$("#item").animate({left: '30%', opacity: '1',fontSize: "2em"},a);
	}
	
	function moveRight(a){
		$("#item").animate({left: '60%', opacity: '0', fontSize: "1em"},a);
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
</script>

<?php

function getTexts(){
	//Später aus sql-statement auslesen und returnen.
	//Genau gleich bei getTitles()
	return array("Text der Karte 1","Text der Karte 2","Text der Karte 3");
}
function getTitles(){
	return array("Titel der Karte 1","Titel der Karte 2","Titel der Karte 3");
}

?>

       
<h1>Home</h1>
<hr />
