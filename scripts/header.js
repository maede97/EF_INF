<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
	function getTime(){
		var now = new Date();
		var hours = now.getHours();
		var minutes = now.getMinutes();
		var seconds = now.getSeconds();
		var timeValue  = ((hours < 10) ? "0" : "") + hours;
		timeValue  += ((minutes < 10) ? ":0" : ":") + minutes;
		timeValue  += ((seconds < 10) ? ":0" : ":") + seconds;
		document.getElementById("header").innerHTML = timeValue;
	}
	
	function startTimer(){
		getTime();
		setInterval(getTime,1000);
	}
</script>