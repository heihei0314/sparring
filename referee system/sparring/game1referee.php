<?php
	$courtNum = $_GET["courtNum"];
	$round = $_GET["round"];
	$minutes = $_GET["minutes"];
	$seconds = $_GET["seconds"];
	$restTime = $_GET["restTime"];
	require_once 'db_configs.php';
	/*/ connect to database
	$mysqli = new mysqli(host, username, password, dbname);	

 	if ($mysqli->connect_errno) {
 		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
 	}
	
	$sql = "INSERT INTO `courtRecord` (`courtNum`, `Red`, `Blue`) VALUES ('$courtNum', '0', '0');";
	$mysqli->query($sql);
	$mysqli->close();
	// connect to database*/
?>

<style type="text/css">
html, body {
    margin: 0;
    padding: 0;
}
#red {
    margin: 0;
    border: 1px solid black;
    width: 50%;
    height: 100%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
}
#blue {
    margin: 0;
    border: 1px solid black;
    width: 50%;
    height: 100%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
}

</style>

<html>
<head>
	<title>Chi Lok Referee System</title>
	<meta charset="UTF-8">
</head>
<script>

<!--control pannel-->
var scoring; 
var courtNum = "<?php echo $courtNum;?>";
var sensitive = <?php echo sensitive; ?>;
document.onkeydown = function(evt) {
    evt = evt || window.event;
    
	switch (evt.keyCode)    {
        case 81:    //press q add red 1 score
			// update screen
			addRed(1);
			// update screen	
            break;
        case 87:    //press w deduct red 1 score
			// update screen
			addRed(-1);	
			// update screen
            break;
        case 65:    //press a add red 1 warning
			// update screen
			addBlue(1);	
			var tempWarning = document.getElementById("r_warning").innerHTML;
			tempWarning = parseInt(tempWarning)+1;
			document.getElementById("r_warning").innerHTML = tempWarning.toString();
			// update screen	
            break;
        case 83:    //press s deduct red 1 warning			
			// update screen
			addBlue(-1);	
			var tempWarning = document.getElementById("r_warning").innerHTML;
			tempWarning = parseInt(tempWarning)-1;
			document.getElementById("r_warning").innerHTML = tempWarning.toString();
			// update screen
            break;
        case 79:    //press o add blue 1 score
			// update screen
			addBlue(1);
			// update screen
            break;
        case 80:    //press p deduct blue 1 score
			// update screen
			addBlue(-1);
			// update screen
            break;
        case 75:    //press k add blue 1 warning			
			// update screen
			addRed(1);
			var tempWarning = document.getElementById("b_warning").innerHTML;
			tempWarning = parseInt(tempWarning)+1;
			document.getElementById("b_warning").innerHTML = tempWarning.toString();
			// update screen		
            break;
        case 76:    //press l deduct blue 1 warning			
			// update screen
			addRed(-1);	
			var tempWarning = document.getElementById("b_warning").innerHTML;
			tempWarning = parseInt(tempWarning)-1;
			document.getElementById("b_warning").innerHTML = tempWarning.toString();
			// update screen
            break;
        case 35:    //press end restart
            location.reload();
            break;
        case 13:    //press enter stop/start timer
			if (document.getElementById("state").innerHTML == 0){
				document.getElementById("state").innerHTML = 1;
				scoring = setInterval(function(){ 
					checkBlueScore("b_r2"); 
					checkRedScore("r_r2"); 
					//checkBlueScore("b_r3"); 
					//checkRedScore("r_r3"); 
					//checkBlueScore("b_r1"); 
					//checkRedScore("r_r1"); 
					}, 100);
				//scoreCompare();
				countdown();
			}
			else	{
				document.getElementById("state").innerHTML = 0;
				clearInterval(scoring);
				//clearInterval(queueing);
				clearTimeout(timer);
			}
            break;		
	}
};
<!--control pannel-->

<!--score queue-->
var r_r1_queue = new Array();
var r_r2_queue = new Array();
var r_r3_queue = new Array();
var b_r1_queue = new Array();
var b_r2_queue = new Array();
var b_r3_queue = new Array();
function scoreCompare(){
	queueing = setInterval(function(){
		if (b_r1_queue.length>0 || b_r2_queue.length>0 || b_r3_queue.length>0){
			if(b_r1_queue[0]==b_r2_queue[0]||b_r1_queue[0]==b_r3_queue[0]){
				
				if (b_r1_queue.length>0){
					var temp = parseInt(b_r1_queue[0])
					addBlue(temp);
				}
			}else if (b_r3_queue[0]==b_r2_queue[0]){
				
				if (b_r3_queue.length>0){
					var temp = parseInt(b_r3_queue[0])
					addBlue(temp);
				}
			}
			b_r1_queue.shift();
			b_r2_queue.shift();
			b_r3_queue.shift();
		}	
		if (r_r1_queue.length>0 || r_r2_queue.length>0 || r_r3_queue.length>0){
			if(r_r1_queue[0]==r_r2_queue[0]||r_r1_queue[0]==r_r3_queue[0]){
				
				if (r_r1_queue.length>0){
					var temp = parseInt(r_r1_queue[0])
					addRed(temp);
				}
			}else if (r_r3_queue[0]==r_r2_queue[0]){
				
				if (r_r3_queue.length>0){
					var temp = parseInt(r_r3_queue[0])
					addRed(temp);
				}
			}
			r_r1_queue.shift();
			r_r2_queue.shift();
			r_r3_queue.shift();
		}
	}, sensitive);
}
<!--score queue-->*/

<!--check score-->
function checkRedScore(id)	{	
	var xhttp = new XMLHttpRequest();
	var response;
	var referee = id.substr(-2);
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			response = this.responseText;
			/*if (response >0){
				switch (referee){
					case 'r1':			
						r_r1_queue.push(response);
						break;
					case 'r2':
						r_r2_queue.push(response);
						break;
					case 'r3':
						r_r3_queue.push(response);
						break;
				}
			}*/
			if (response == 1){	
				addRed(1);
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "yellow";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "red";
				}, sensitive);				
			}
			else if (response == 2){	
				addRed(2);
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "lightgreen";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "red";
				}, sensitive);		
			}
			else if (response == 3){	
				addRed(3);				
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "purple";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "red";
				}, sensitive);		
			}
			else if (response == 4){	
				addRed(4);
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "White";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "red";
				}, sensitive);		
			}
		}
	};

	xhttp.open("GET","checkScore.php?court="+courtNum+"&referee="+referee+"&RB=R", true);
	xhttp.send();
}
function checkBlueScore(id)	{	
	var xhttp = new XMLHttpRequest();
	var response;
	var referee = id.substr(-2);
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			response = this.responseText;
			/*if (response >0){
				switch (referee){
					case 'r1':			
						b_r1_queue.push(response);
						break;
					case 'r2':
						b_r2_queue.push(response);
						break;
					case 'r3':
						b_r3_queue.push(response);
						break;
				}
			}*/
			if (response == 1){	
				addBlue(1);
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "yellow";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "blue";
				}, sensitive);		
			}
			else if (response == 2){
				addBlue(2);
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "lightgreen";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "blue";
				}, sensitive);		
			}
			else if (response == 3){
				addBlue(3);
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "purple";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "blue";
				}, sensitive);		
			}
			else if (response == 4){
				addBlue(4);
				document.getElementById(id).style.fontSize = "48px";
				document.getElementById(id).innerHTML = response;
				document.getElementById(id).style.backgroundColor = "White";
				setTimeout(function(){
        			document.getElementById(id).style.fontSize = "48px";
					document.getElementById(id).innerHTML = id;
					document.getElementById(id).style.backgroundColor = "blue";
				}, sensitive);		
			}
		}
	};
	xhttp.open("GET", "checkScore.php?court="+courtNum+"&referee="+referee+"&RB=B", true);
	xhttp.send();
}
<!--check score-->

<!--add score-->
function addRed(score){
		var audio2 = new Audio('addScore.mp3');
		audio2.play();
		var temp = document.getElementById("r_score").innerHTML;
		temp = parseInt(temp)+score;
		document.getElementById("r_score").innerHTML = temp.toString();
		if (document.getElementById('round').innerHTML=="加賽"){
			additionWin();
		}
		else
			win();	
	
}
function addBlue(score){		
		var audio3 = new Audio('addScore.mp3');
		audio3.play();
		var temp = document.getElementById("b_score").innerHTML;
		temp = parseInt(temp)+score;
		document.getElementById("b_score").innerHTML = temp.toString();
		if (document.getElementById('round').innerHTML=="加賽"){
			additionWin();
		}
		else
			win();	
	
}
<!--add score-->

<!--count down-->
var seconds;
var minutes;
var temp; 
function countdown() {

	seconds = document.getElementById('seconds').innerHTML;
	minutes = document.getElementById('minutes').innerHTML;
	seconds = parseInt(seconds, 10);
	minutes = parseInt(minutes, 10);
 
	if (seconds == 0) {               
		if (minutes == 0)	{
			var r =<?php echo $round;?>;
			var temp = document.getElementById("round").innerHTML;
			if (temp=="加賽"){
				alert("回合完結");
				header("Refresh:0");
			}
			else {
				temp = parseInt(temp)+1;	
			
				if(temp>r){
					timeWin();
					return;
				}
				else	{
					document.getElementById("round").innerHTML = temp.toString();
					var s=<?php echo $seconds;?>;
					var m=<?php echo $minutes;?>;
					document.getElementById("state").innerHTML = 0;
					document.getElementById("seconds").innerHTML = "<?php if ($seconds<10){echo "0";echo $seconds;}else{echo $seconds;}?>";
					document.getElementById("minutes").innerHTML = "<?php echo $minutes;?>";
					clearTimeout(timer);		
					var audio = new Audio('restTime.mp3');
					audio.play();
					var rt=<?php echo $restTime;?>;
					window.open("timer.php?restTime="+rt)
					return;
				}
			}
		}
		else	{
			seconds = 59;
			minutes--;
		}
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
	temp = document.getElementById('minutes');
	temp.innerHTML = minutes;
	timer = setTimeout(countdown, 1000);
}
countdown();
<!--count down-->

<!--win setting-->
function timeWin()	{
	var audio = new Audio('won.mp3');
	var audio4 = new Audio('restTime.mp3');
	var r_score = document.getElementById('r_score').innerHTML;
	r_score = parseInt(r_score);
	var b_score = document.getElementById('b_score').innerHTML;
	b_score = parseInt(b_score);	
	
	if (r_score>b_score){
		window.open("win.php?who=紅勝");
		audio.play();
	}		
	else if (b_score>r_score){
		window.open("win.php?who=藍勝");
		audio.play();
	}		
	else	{
		document.getElementById("round").innerHTML = "加賽";
		var s=<?php echo $seconds;?>;
		var m=<?php echo $minutes;?>;
		document.getElementById("state").innerHTML = 0;
		document.getElementById("seconds").innerHTML = "<?php if ($seconds<10){echo "0";echo $seconds;}else{echo $seconds;}?>";
		document.getElementById("minutes").innerHTML = "<?php echo $minutes;?>";
		clearTimeout(timer);
		audio4.play();
		var rt=<?php echo $restTime;?>;
		window.open("timer.php?restTime="+rt)
	}
	return;
	
}
function win()	{
	var audio = new Audio('won.mp3');
	var r_score = document.getElementById('r_score').innerHTML;
	r_score = parseInt(r_score);
	var b_score = document.getElementById('b_score').innerHTML;
	b_score = parseInt(b_score);	
	var r_warning = document.getElementById('r_warning').innerHTML;
	r_warning = parseInt(r_warning);
	var b_warning = document.getElementById('b_warning').innerHTML;
	b_warning = parseInt(b_warning);
	// point Gap
	if (r_score>=b_score+20){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=紅勝");
	}
	else if (b_score>=r_score+20){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=藍勝");
	}
	// warning
	if (b_warning>=10){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=紅勝");
	}
	else if (r_warning>=10){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=藍勝");
	}
	return;
	
}
function additionWin()	{
	var audio = new Audio('won.mp3');
	var r_score = document.getElementById('r_score').innerHTML;
	r_score = parseInt(r_score);
	var b_score = document.getElementById('b_score').innerHTML;
	b_score = parseInt(b_score);	
	var r_warning = document.getElementById('r_warning').innerHTML;
	r_warning = parseInt(r_warning);
	var b_warning = document.getElementById('b_warning').innerHTML;
	b_warning = parseInt(b_warning);
	// point first
	if (r_score>b_score){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=紅勝");
	}
	else if (b_score>r_score){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=藍勝");
	}		
	// warning
	if (r_warning == 2){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=藍勝");
	}
	else if (b_warning == 2){
		clearTimeout(timer);
		audio.play();
		window.open("win.php?who=紅勝");
	}
}
<!--win setting-->


</script>
<body>
	<!--red-->
	<div id=red style=background-color:red;float:left;>
		<table width="100%" height="100%" border=0>
			<tr>
				<td id='r_r1' style="font-size:48px;"></td>
				<td colspan=3 width="80%"></td>
				<td id='r_r3' style="font-size:48px;"> </td>
			</tr>
			<tr  heigt="85%">
				<td colspan=5 align=center>
					<font color=white><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big>
					<span id=r_score>0</span>						</big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></font>
				</td>
			</tr>
			<tr>
				<td width=15%><font color=red size=7><span id="state">0</span></font></td>
				<td colspan=3 align=center>
					<font color=yellow size=7>Warning: 
						<span id=r_warning>0</span> 
					</font>
				</td>
				<td width=15%><font color=white size=7>Round</font></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td width=10% align=center id="r_r2" style="font-size:48px;">R2</td>

				<td></td>
				<td align="right"><font color=white size=7> 0<span id="minutes"><?php echo $minutes;?></span>:</font></td>
			</tr>
		</table>
	</div>
	<!--red-->
	<!--blue-->
	<div id=blue style=background-color:blue;float:left;>
		<table width="100%" height="100%" border=0>
			<tr>
				<td id='b_r1' style="font-size:48px;"></td>
				<td colspan=3 width="80%"></td>
				<td id='b_r3' style="font-size:48px;"></td>
			</tr>
			<tr  heigt="85%">
				<td colspan=5 align=center>
					<font color=white><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big>
						<span id=b_score>0</span>	
					</big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></font>
				</td>
			</tr>
			<tr>
				<td width=15%><font color=white size=7>&nbsp&nbsp<span id=round>1</span></font></td>
				<td width=70% colspan=3 align=center>
					<font color=yellow size=7>Warning: 
						<span id=b_warning>0</span> <!--blue warning-->
					</font>
				</td>
				<td width=15%></td>
			</tr>
			<tr>
				<td align="left"><font color=white size=7><span id="seconds"><?php if ($seconds<10){echo "0";echo $seconds;}else{echo $seconds;}?></span></font></td>
				<td></td>
				<td width=10% align=center id='b_r2' style="font-size:48px;">R2</td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
	<!--blue-->
</body>
</html>		