<?php
	header("Content-type:text/html;charset=utf-8"); 
	$who = $_GET["who"];
?>
<script type="text/javascript">


<!--count down-->		
	var seconds = 10;
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

<!--winner style-->
	var who = "<?php echo $who;?>";
	function winner() {
		//alert(who);
		if (who=="紅勝"){
			document.body.style.backgroundColor = "red";
		}
		else if (who=="藍勝"){
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
	<font id='bg' align='center' color=black size=7><big><big><big><big><big><big><big><big><big><big><big><big><big><big>
		<p><?php echo $who;?></p>
	</big></big></big></big></big></big></big></big></big></big></big></big></big></big><font>
</body>
</html>