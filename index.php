<!DOCTYPE html>
<script src="scripts/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#header").load("header.php");
		$("#footer").load("footer.php");
    		$("#menu").load("menu.php");
                $("#main").load("content/"+getParamGET("site")+".php");
                startTimer();
            });
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
        
        function getParamGET(param) {
            var found;
            window.location.search.substr(1).split("&").forEach(function(item) {
                if (param ==  item.split("=")[0]) {
                    found = item.split("=")[1];
                }
            });
            return found;
        }         
</script>

<link rel="stylesheet" href="styles/style.css">
<html>
    <head>
        <title>SchoolTool</title>
    </head>
    <body>
		<div id="menu"></div>
		<div id="header">
			<span id="time"></span>
		</div>
		<div id="main"></div>
		<div id="footer"></div>
    </body>
</html>