<?php
	header("Content-type:text/html;charset=utf-8"); 
	$who = $_GET["who"];
	$restTime = $_GET["restTime"];
?>
<script type="text/javascript">




<!--winner style-->
	var who = "<?php echo $who;?>";
	function winner() {
		//alert(who);
		if (who=="紅回合勝"){
			document.body.style.backgroundColor = "red";
		}
		else if (who=="藍回合勝"){
			document.body.style.backgroundColor = "blue";
		}
	}	
	countdown();	
<!--winning style-->
</script>
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title> Wai Tsuen TKD Sparring Referee System</title>
</head>
<body onload='winner()'>
	<font id='bg' align='center' color=black size=5><big><big><big><big><big><big><big><big><big><big><big><big><big><big>
		<p>
			<?php echo $who;?>
			<br><span id="seconds"><?php echo $restTime;?></span>
		</p>
	</big></big></big></big></big></big></big></big></big></big></big></big></big></big><font>

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
</script>
<!--count down-->

</body>
</html>