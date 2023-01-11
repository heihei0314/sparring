<?php
	$courtNum = $_POST["courtNum"];
	$round = $_POST["round"];
	$minutes = $_POST["minutes"];
	$seconds = $_POST["seconds"];
	$restTime = $_POST["restTime"];
	$pointGap = $_POST["pointGap"];
	$warning = $_POST["warning"];
	$refereeNum = $_POST["refereeNum"];
	$sensitive = $_POST["sensitive"];
	require_once 'db_configs.php';
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
#scoringPannel {
    display: none;
    border: 1px solid black;
    width: 20%;
    height: 30%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
	position: fixed;
	top: 25%;
	left: 40%;
	background-color:white;
}

</style>

<html>
<head>
	<title>Wai Tsuen TKD Sparring Referee System (in Game)</title>
	<meta charset="UTF-8">
</head>
<script>
<!--control pannel-->
	var courtNum = "<?php echo $courtNum;?>";
	var courtName = courtNum.substring(0,1);
	var rounds = "<?php echo $round;?>";
	var setMinutes = "<?php echo $minutes;?>";
	var setSeconds = "<?php echo $seconds;?>";
	var restTime = "<?php echo $restTime;?>";
	var pointGap =  parseInt("<?php echo $pointGap;?>");
	var warning =  parseInt("<?php echo $warning;?>");
	var refereeNum = "<?php echo $refereeNum;?>";
	var sensitive = "<?php echo $sensitive; ?>";
	var lightStay = sensitive;
	const redScoreDetails = [0, 0, 0, 0, 0, 0]; // punch, body, spinBody, spinHead, head, warning
	const blueScoreDetails = [0, 0, 0, 0, 0, 0];
	var scoringListener; 
	var currentRound = 0;
	
	
	
	
	document.onkeydown = function(evt) {
    	evt = evt || window.event;
    
		switch (evt.keyCode)    {
        	case 67:    //press c to open scoring pannel			
				document.getElementById("scoringPannel").style.display="block";
            	break;
        	case 35:    //press end to restart
            	location.reload();
            	break;
        	case 13:    //press enter to stop/start timer
				if (document.getElementById("state").innerHTML == 0){ //check timer status
					document.getElementById("state").innerHTML = 1;
					countdown();
					scoringListener = setInterval(function(){ 
						checkScore(); 
					    scoreCompare();
					}, 1000);
					currentRound = document.getElementById("round").innerHTML;
					currentRound = parseInt(currentRound);
				}
				else	{
					document.getElementById("state").innerHTML = 0; //timer status
					clearInterval(scoringListener);
					clearTimeout(timer);
				}
            break;		
		}
	};

	function closeScoringPannel(){
		document.getElementById("scoringPannel").style.display="none";
	}
<!--control pannel-->

<!--check score-->
    var scoreObj;
	var r_r1_queue = new Array();
	var r_r2_queue = new Array();
	var r_r3_queue = new Array();
	var b_r1_queue = new Array();
	var b_r2_queue = new Array();
	var b_r3_queue = new Array();
	var scoreTimer;
	function checkScore()	{	
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				scoreObj = JSON.parse(this.responseText);
				if (scoreObj.scoreEvent.length>0){
				    for(i=0;i<scoreObj.scoreEvent.length;i++){
                        var referee = scoreObj.scoreEvent[i].referee;
		                var checkRB = scoreObj.scoreEvent[i].RB;
		                var response = scoreObj.scoreEvent[i].scoreType;
		                var id = checkRB+"_"+referee;
		                var baseColor;
		                switch(checkRB){
		                    case 'R':
		                        baseColor = "red";
		                        break;
		                    case 'B':
		                        baseColor = "blue";
		                        break;
		                }
                    
				        pushScoreQueue(id, response);
				        switch(referee){
				            case 'r1':
				                scoreTimer1 = setTimeout(function(){
						        shiftScoreQueue(id, baseColor);
					        }, lightStay);
				            case 'r2':
				                scoreTimer2 = setTimeout(function(){
						        shiftScoreQueue(id, baseColor);
					        }, lightStay);
				            case 'r3':
				                scoreTimer3 = setTimeout(function(){
						        shiftScoreQueue(id, baseColor);
					        }, lightStay);
				        }
				        if (response == "Punch"){	
					        document.getElementById(id).style.backgroundColor = "yellow";			
				        }
				        else if (response == "Body"){
				            document.getElementById(id).style.backgroundColor = "lightgreen";
				        }
				        else if (response == "SpinBody"){				
					        document.getElementById(id).style.backgroundColor = "White";
				        }
			    	    else if (response == "SpinHead"){
					    	document.getElementById(id).style.backgroundColor = "Black";
				        }
				        else if (response == "Head"){
					        document.getElementById(id).style.backgroundColor = "Purple";	
				        }
				        setTimeout(function(){
	                        document.getElementById(id).style.backgroundColor = baseColor;
					    }, lightStay);		
				    }
			    }
			}
		};
		xhttp.open("GET","checkScore.php?court="+courtName, false);
		xhttp.send();
	}
<!--check score-->
function pushScoreQueue(id, response){
    switch (id){
		case 'R_r1':			
			r_r1_queue.push(response);
			break;
		case 'R_r2':
			r_r2_queue.push(response);
			break;
		case 'R_r3':
			r_r3_queue.push(response);
			break;
		case 'B_r1':			
			b_r1_queue.push(response);
			break;
		case 'B_r2':
			b_r2_queue.push(response);
			break;
		case 'B_r3':
			b_r3_queue.push(response);
			break;
	}
}
function shiftScoreQueue(id){
    
    switch (id){
		case 'R_r1':			
			r_r1_queue.shift();
			clearTimeout(scoreTimer1);
			break;
		case 'R_r2':
			r_r2_queue.shift();
			clearTimeout(scoreTimer2);
			break;
		case 'R_r3':
			r_r3_queue.shift();
			clearTimeout(scoreTimer3);
			break;
		case 'B_r1':			
			b_r1_queue.shift();
			clearTimeout(scoreTimer1);
			break;
		case 'B_r2':
			b_r2_queue.shift();
			clearTimeout(scoreTimer2);
			break;
		case 'B_r3':
			b_r3_queue.shift();
			clearTimeout(scoreTimer3);
			break;
	}
}
<!--check score-->

<!--score queue and judge scoring-->
	function scoreCompare(){
		//alert(r_r1_queue[0]);
		if (b_r1_queue.length>0 ){
			if(b_r1_queue[0]==b_r2_queue[0]){
			    addScore('b_score', b_r1_queue[0], 1);
			    shiftScoreQueue('B_r1');
			    shiftScoreQueue('B_r2');
			}
			else if(b_r1_queue[0]==b_r3_queue[0]){
			    addScore('b_score', b_r1_queue[0], 1);
			    shiftScoreQueue('B_r1');
			    shiftScoreQueue('B_r3');
			}
		}
		else if (b_r3_queue[0]==b_r2_queue[0] & b_r3_queue.length>0){
			addScore('b_score', b_r3_queue[0], 1);
			shiftScoreQueue('B_r3');
			shiftScoreQueue('B_r2');
		}
		else if (refereeNum==1 & b_r2_queue.length>0){
			addScore('b_score', b_r2_queue[0], 1);
			shiftScoreQueue('B_r2');
		}
		
		if (r_r1_queue.length>0 ){
			if(r_r1_queue[0]==r_r2_queue[0]){
			    addScore('r_score', r_r1_queue[0], 1);
			    shiftScoreQueue('R_r1');
			    shiftScoreQueue('R_r2');
			}
			else if(r_r1_queue[0]==r_r3_queue[0]){
			    addScore('r_score', r_r1_queue[0], 1);
			    shiftScoreQueue('R_r1');
			    shiftScoreQueue('R_r3');
			}
		}
		else if (r_r3_queue[0]==r_r2_queue[0] & r_r3_queue.length>0){
			addScore('r_score', r_r3_queue[0], 1);
			shiftScoreQueue('R_r3');
			shiftScoreQueue('R_r2');
		}
		else if (refereeNum==1 & r_r2_queue.length>0){
			addScore('r_score', r_r2_queue[0], 1);
			shiftScoreQueue('R_r2');
		}
	}
	
<!--score queue and judge scoring-->

<!--add score-->
	function addScore(RedBlue, scoreType, operate){
		var currentScore = document.getElementById(RedBlue).innerHTML;
		var audio2 = new Audio('addScore.mp3');
		audio2.play();

		tempScore = scoringTable(scoreType)*operate;		
		currentScore = parseInt(currentScore)+tempScore;

		document.getElementById(RedBlue).innerHTML = currentScore.toString();
		var currentRound = document.getElementById('round').innerHTML;
		currentRound = parseInt(currentRound);
		
		//record score detail locally
		if (RedBlue=='r_score'){
			switch (scoreType){
				case "Punch":
					redScoreDetails [0] += 1*operate;
					break;
				case "Body":
					redScoreDetails [1] += 1*operate;
					break;
				case "SpinBody":
					redScoreDetails [2] += 1*operate;
					break;
				case "SpinHead":
					redScoreDetails [3] += 1*operate;
					break;
				case "Head":
					redScoreDetails [4] += 1*operate;
					break;
				case "Warning":
					blueScoreDetails [5] += 1*operate;
					var tempWarning = document.getElementById("b_warning").innerHTML;
					tempWarning = parseInt(tempWarning)+1*operate;
					document.getElementById("b_warning").innerHTML = tempWarning.toString();
					break;
			}
		}	
		else if (RedBlue=='b_score'){
			switch (scoreType){
				case "Punch":
					blueScoreDetails [0] += 1*operate;
					break;
				case "Body":
					blueScoreDetails [1] += 1*operate;
					break;
				case "SpinBody":
					blueScoreDetails [2] += 1*operate;
					break;
				case "SpinHead":
					blueScoreDetails [3] += 1*operate;
					break;
				case "Head":
					blueScoreDetails [4] += 1*operate;
					break;
				case "Warning":
					blueScoreDetails [5] += 1*operate;
					var tempWarning = document.getElementById("r_warning").innerHTML;
					tempWarning = parseInt(tempWarning)+1*operate;
					document.getElementById("r_warning").innerHTML = tempWarning.toString();
					break;
			}
			//alert(blueScoreDetails+", "+scoreType+", "+RedBlue+", "+operate);

		}
		//record score detail locally
       // alert(currentRound);
		if (currentRound=="黃金"){
			additionWin();
		}
		else {
			pointWin(currentRound);	
		}			
	}
<!--add score-->

<!--Score Table-->
	function scoringTable (scoreType){
		var tempScore=0;
		switch (scoreType){
			case "Punch":
				tempScore=1;
				break;
			case "Body":
				tempScore=2;
				break;
			case "SpinBody":
				tempScore=4;
				break;
			case "SpinHead":
				tempScore=5;
				break;
			case "Head":
				tempScore=3;
				break;
			case "Warning":
				tempScore=1;
				break;
		}
		return tempScore;
	}
<!--Score Table-->

<!--count down-->
var seconds =  parseInt(setSeconds);
var minutes =  parseInt(setMinutes);
function countdown() {
    var r_score = document.getElementById('r_score').innerHTML;
	r_score = parseInt(r_score);
	var b_score = document.getElementById('b_score').innerHTML;
	b_score = parseInt(b_score);
	
	if (seconds == 0) {               
		if (minutes == 0)	{
			if (currentRound=="黃金"){
				alert("回合完結");	
				
				//clearTimeout(timer);
				return;	
			}
			else {				
				pointWin(currentRound);
				currentRound = currentRound+1;	
				if(currentRound>rounds){
					timeWin();
				    //clearTimeout(timer);
				    return;	
				}
				else	{
					seconds =  parseInt(setSeconds);
                    minutes =  parseInt(setMinutes);
					document.getElementById("round").innerHTML = currentRound.toString();
					document.getElementById("state").innerHTML = 0;
					document.getElementById("seconds").innerHTML = "<?php if ($seconds<10){echo "0";echo $seconds;}else{echo $seconds;}?>";
					document.getElementById("minutes").innerHTML = "<?php if ($minutes<10){echo "0";echo $minutes;}else{echo $minutes;}?>";
					//clearTimeout(timer);		
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
		document.getElementById("seconds").innerHTML = "0"+seconds.toString();
	}
	else	{
	    document.getElementById("seconds").innerHTML = seconds.toString();
	}	
	if (minutes < 10){
		document.getElementById('minutes').innerHTML = "0"+minutes.toString();
	}
	else	{
		document.getElementById('minutes').innerHTML = minutes.toString();
	}	
	timer = setTimeout(countdown, 1000);
}
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
			document.getElementById("round").innerHTML = "黃金";
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
	function pointWin(r)	{
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
		if (r_score>=b_score+pointGap & pointGap>0 &r>1){
			clearTimeout(timer);
			audio.play();
			window.open("win.php?who=紅勝");
		}
			else if (b_score>=r_score+pointGap & pointGap>0 &r>1){
			clearTimeout(timer);
			audio.play();
			window.open("win.php?who=藍勝");
		}
	
		// warning
		if (b_warning==warning & warning>0){
			clearTimeout(timer);
			audio.play();
			window.open("win.php?who=紅勝");
		}
		else if (r_warning==warning & warning>0){
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
		if (r_score>=b_score+2){
			clearTimeout(timer);
			audio.play();
			window.open("win.php?who=紅勝");
		}
		else if (b_score>=r_score+2){
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
				<td id='R_r1' style="font-size:48px;">R1</td>
				<td colspan=3 width="80%"></td>
				<td id='R_r3' style="font-size:48px;">R3 </td>
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
				<font color=yellow size=7><big><big><big><big>Warning: 
						<span id=r_warning>0</span> <!--blue warning--></big></big></big></big>
					</font>
				</td>
				<td width=15%><font color=white size=7>Round</font></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td width=10% align=center id="R_r2" style="font-size:48px;">R2</td>

				<td></td>
				<td align="right"><font color=white size=7><span id="minutes"><?php if ($minutes<10){echo "0";echo $minutes;}else{echo $minutes;}?></span>:</font></td>
			</tr>
		</table>
	</div>
	<!--red-->
	<!--blue-->
	<div id=blue style=background-color:blue;float:left;>
		<table width="100%" height="100%" border=0>
			<tr>
				<td id='B_r1' style="font-size:48px;">R1</td>
				<td colspan=3 width="80%"></td>
				<td id='B_r3' style="font-size:48px;">R3</td>
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
					<font color=yellow size=7><big><big><big><big>Warning: 
						<span id=b_warning>0</span> <!--blue warning--></big></big></big></big>
					</font>
				</td>
				<td width=15%></td>
			</tr>
			<tr>
				<td align="left"><font color=white size=7><span id="seconds"><?php if ($seconds<10){echo "0";echo $seconds;}else{echo $seconds;}?></span></font></td>
				<td></td>
				<td width=10% align=center id='B_r2' style="font-size:48px;">R2</td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
	<!--blue-->
	
	<!--scoringPannel-->
	<div id="scoringPannel">
		<table style="width:100%;">
		<tr>
			<td>
				<button onclick="addScore('r_score', 'Punch', 1)">紅加拳分</button> <button onclick="addScore('r_score', 'Punch', -1)">紅減拳分</button>
			</td>
			<td align="right">
				<button onclick="addScore('b_score', 'Punch', 1)">藍加拳分</button> <button onclick="addScore('b_score', 'Punch', -1)">藍減拳分</button>
			</td>
		</tr>
		<tr>
			<td>
				<button onclick="addScore('r_score', 'Body', 1)">紅加身分</button> <button onclick="addScore('r_score', 'Body', -1)">紅減身分</button>
			</td>
			<td align="right">
				<button onclick="addScore('b_score', 'Body', 1)">藍加身分</button> <button onclick="addScore('b_score', 'Body', -1)">藍減身分</button>
			</td>
		</tr>
		<tr>
			<td>
				<button onclick="addScore('r_score', 'SpinBody', 1)">紅加轉身腰</button> <button onclick="addScore('r_score', 'SpinBody', -1)">紅減轉身腰</button>
			</td>
			<td align="right">
				<button onclick="addScore('b_score', 'SpinBody', 1)">藍加轉身腰</button> <button onclick="addScore('b_score', 'SpinBody', -1)">藍減轉身腰</button>
			</td>
		</tr>
		<tr>
			<td>
				<button onclick="addScore('r_score', 'SpinHead', 1)">紅加轉身頭</button> <button onclick="addScore('r_score', 'SpinHead', -1)">紅減轉身頭)</button>
			</td>
			<td align="right">
				<button onclick="addScore('b_score', 'SpinHead', 1)">藍加轉身頭</button> <button onclick="addScore('b_score', 'SpinHead', -1)">藍減轉身頭</button>			
			</td>
		</tr>
		<tr>
			<td>
				<button onclick="addScore('r_score', 'Head', 1)">紅加頭分</button> <button onclick="addScore('r_score', 'Head', -1)">紅減頭分</button>
			</td>
			<td align="right">
				<button onclick="addScore('b_score', 'Head', 1)">藍加頭分</button> <button onclick="addScore('b_score', 'Head',-1)">藍減頭分</button>
			</td>
		</tr>
		<tr >
			<td>
				<button onclick="addScore('b_score', 'Warning', 1)">紅加警告</button> <button onclick="addScore('b_score', 'Warning', -1)">紅減警告</button>
			</td>
			<td align="right">
				<button onclick="addScore('r_score', 'Warning', 1)">藍加警告</button> <button onclick="addScore('r_score', 'Warning', -1)">藍減警告</button>
			</td>
		</tr>
		</table>
		<p align="center"><button onclick="closeScoringPannel()">關閉</button></p>
	</div>	
	<!--scoringPannel-->
</body>
</html>		