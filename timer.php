<?php
	$restTime = $_GET["restTime"];
?>
<html>
<body><font color=black size=7><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big>
<p align=center id="seconds"><?php echo $restTime;?></p>
</big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big><font>
<script type="text/javascript">
<!--count down-->
var seconds;
var temp;

function countdown() {
	seconds = document.getElementById('seconds').innerHTML;
	seconds = parseInt(seconds, 10);
 
	if (seconds == 0) {               
		window.close();
	}
	else	{
		seconds--;
	}

	if (seconds < 10){
		temp = document.getElementById('seconds');
		temp.innerHTML = "0"+seconds;
	}
	else	{
		temp = document.getElementById('seconds');
		temp.innerHTML = seconds;
	}	

	timer = setTimeout(countdown, 1000);
}
countdown();
	
<!--count down-->
</script>
</body>
</html>