<?php
	$who = $_GET["who"];
?>
<script type="text/javascript">
<!--count down-->
var seconds = 3;

function countdown() {
	
 
	if (seconds == 0) {               
		window.close();
	}
	else	{
		seconds--;
	}
	timer = setTimeout(countdown, 1000);
}
countdown();
	
<!--count down-->
</script>
<html>
<body onload='countdown()'><font color=black size=7><big><big><big><big><big><big>
<p align=center id="seconds"><?php echo $who;?></p>
</big></big></big></big></big></big></big></big><font>
</body>
</html>