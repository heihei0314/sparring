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
#scoringPannel, #refereePannel {
    display: none;
    border: 1px solid black;
    width: 20%;
    height: 33%;
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
	var pointGap = "<?php echo $pointGap;?>";
	var warning = "<?php echo $warning;?>";
	var refereeNum = "<?php echo $refereeNum;?>";
	var sensitive = "<?php echo $sensitive; ?>";
	var lightStay = sensitive;
	const redScoreDetails = [0, 0, 0, 0, 0, 0]; // punch, body, spinBody, spinHead, head, warning
	const blueScoreDetails = [0, 0, 0, 0, 0, 0];
	var scoringListener; 
	var currentRound = 0;
	var matchPoint = Math.floor(rounds/2)+1;
	var bWinRounds = 0;
	var rWinRounds = 0;
	
	document.onkeydown = function(evt) {
    	evt = evt || window.event;
    
		switch (evt.keyCode)    {
        	case 67:    //press c to open scoring pannel			
				document.getElementById("scoringPannel").style.display="block";
            	break;
        	case 82:    //press r to open referee pannel			
				document.getElementById("refereePannel").style.display="block";
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
	function closeRefereePannel(){
		document.getElementById("refereePannel").style.display="none";
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
					redScoreDetails [5] += 1*operate;
					var tempWarning = document.getElementById("r_warning").innerHTML;
					tempWarning = parseInt(tempWarning)+1*operate;
					document.getElementById("r_warning").innerHTML = tempWarning.toString();
					break;
			}
			//alert(blueScoreDetails[2]+", "+scoreType+", "+RedBlue+", "+operate);

		}
		//record score detail locally

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
			timeWin();
			return;				
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
	    clearTimeout(timer);
		var r_score = document.getElementById('r_score').innerHTML;
		r_score = parseInt(r_score);
		var b_score = document.getElementById('b_score').innerHTML;
		b_score = parseInt(b_score);	
		
		if (r_score>b_score){
			recordScore('R');
		}		
		else if (b_score>r_score){
			recordScore('B');
		}		
		else	{//draw
			tieDecision();
		}
			
		return;
	}
	function tieDecision(){
	    //"&RWarning="+redScoreDetails[5]+"&b_score="+b_score+"&BPunch="+blueScoreDetails[0]+"&BBody="+blueScoreDetails[1]+"&BSpinBody="+blueScoreDetails[2]+"&BSpinHead="+blueScoreDetails[3]+"&BHead="+blueScoreDetails[4]+"&BWarning="+blueScoreDetails[5]+"&roundWinner="+who;
		
		var competitionRecord;
	    //get game record
		var xhttp = new XMLHttpRequest();
		var response;
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				response = this.responseText;
			}
		};
		xhttp.open("GET","recordRound.php?court="+courtNum+"&round="+currentRound, false);
		xhttp.send();
		//get game record
		
		competitionRecord = response.split(",");
		var redSpin = redScoreDetails[2]*4+redScoreDetails[3]*5;
		var blueSpin = blueScoreDetails[2]*4+blueScoreDetails[3]*5;

		var redHead = redScoreDetails[4]*3+redScoreDetails[3]*5;
		var blueHead = blueScoreDetails[4]*3+blueScoreDetails[3]*5;

		var redBody = redScoreDetails[1]*2+redScoreDetails[2]*4;
		var blueBody = blueScoreDetails[1]*2+blueScoreDetails[2]*4;
		
	    if(redSpin>blueSpin){//旋轉踢法得分
			recordScore('R');
			return;
		}
		else if(redSpin<blueSpin){
			recordScore('B');
			return;
		}//旋轉踢法得分
		else if(redHead>blueHead){//頭
			recordScore('R');
			return;
		}
		else if(redHead<blueHead){
			recordScore('B');
			return;
		}//頭
		else if(redBody>blueBody){//身
			recordScore('R');
			return;
		}
		else if(redBody<blueBody){
			recordScore('B');
			return;
		}//身
		else if(redScoreDetails[0]>blueScoreDetails[0]){//拳
			recordScore('R');
			return;
		}
		else if(redScoreDetails[0]<blueScoreDetails[0]){
			recordScore('B');
			return;
		}//拳
		else if(redScoreDetails[5]>blueScoreDetails[5]){//警告
			recordScore('B');
		}
		else if(redScoreDetails[5]<blueScoreDetails[5]){
			recordScore('R');
			return;
		}//警告
		else{
			alert("referee Meeting, Please press 'R'");
		}
	}
	function pointWin(tempRound)	{ 
	    clearTimeout(timer);
		var r_score = document.getElementById('r_score').innerHTML;
		r_score = parseInt(r_score);
		var b_score = document.getElementById('b_score').innerHTML;
		b_score = parseInt(b_score);	
		// point Gap 
		if (r_score>=b_score+pointGap & pointGap>0 ){
			recordScore('R');
		}
		else if (b_score>=r_score+pointGap & pointGap>0 ){
			recordScore('B');
		}
	
		// warning
		var r_warning = document.getElementById('r_warning').innerHTML;
		r_warning = parseInt(r_warning);
		var b_warning = document.getElementById('b_warning').innerHTML;
		b_warning = parseInt(b_warning);
		if (b_warning==warning & warning>0){
			recordScore('R');
		}
		else if (r_warning==warning & warning>0){
			recordScore('B');
		}
		return;
	
	}
	
	function finalWin(){
		var competitionRecord;
	    //get game record
		var xhttp = new XMLHttpRequest();
		var response;
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				response = this.responseText;
				
			}
		};
		xhttp.open("GET","recordGame.php?court="+courtNum, false);
		xhttp.send();
		//get game record
		
		competitionRecord = response.split(",");
		var redSpin = parseInt(competitionRecord[4])*4+parseInt(competitionRecord[5])*5;
		var blueSpin = parseInt(competitionRecord[8])*4+parseInt(competitionRecord[9])*5;
		
		var audio = new Audio('won.mp3');
		audio.play();
		
		if(competitionRecord[1]>competitionRecord[2]){//獲勝回合數
			var gameWinner = "R";
			window.open("win.php?who=紅勝");
			return;
		}
		else if(competitionRecord[1]<competitionRecord[2]){
			var gameWinner = "B";
			window.open("win.php?who=藍勝");
			return;
		}//獲勝回合數
		else if(competitionRecord[3]>competitionRecord[7]){//三回合總分
			var gameWinner = "R";
			window.open("win.php?who=紅勝");
			return;
		}
		else if(competitionRecord[3]<competitionRecord[7]){
			var gameWinner = "B";
			window.open("win.php?who=藍勝");
			return;
		}//三回合總分
		else if(redSpin>blueSpin){//旋轉踢法得分
			var gameWinner = "R";
			window.open("win.php?who=紅勝");
			return;
		}
		else if(redSpin<blueSpin){
			var gameWinner = "B";
			window.open("win.php?who=藍勝");
			return;
		}//旋轉踢法得分
		else if(competitionRecord[6]>competitionRecord[10]){//警告
			var gameWinner = "B";
			window.open("win.php?who=藍勝");
			return;
		}
		else if(competitionRecord[6]<competitionRecord[10]){
			var gameWinner = "R";
			window.open("win.php?who=紅勝");
			return;
		}//警告
		else{
			alert("referee Meeting");
		}
		//update competition record
		var url = "recordCompetition.php?court="+courtNum+"&rWinningRound="+competitionRecord[1]+"&redScore="+competitionRecord[3]+"&redSpin="+redSpin+"&RWarning="+competitionRecord[6]+"&bWinningRound="+competitionRecord[2]+"&blueScore="+competitionRecord[7]+"&blueSpin="+blueSpin+"&BWarning="+competitionRecord[10]+"&gameWinner="+gameWinner;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		//update competition record*/
	}
<!--win setting-->
<!--recordScore-->
	function recordScore(who){
		var audio = new Audio('restTime.mp3');
		var r_score = document.getElementById('r_score').innerHTML;
		r_score = parseInt(r_score);
		var b_score = document.getElementById('b_score').innerHTML;
		b_score = parseInt(b_score);	
		var r_warning = document.getElementById('r_warning').innerHTML;
		r_warning = parseInt(r_warning);
		var b_warning = document.getElementById('b_warning').innerHTML;
		b_warning = parseInt(b_warning);
		// call php update db
		var url = "recordScore.php?court="+courtNum+"&round="+currentRound+"&r_score="+r_score+"&RPunch="+redScoreDetails[0]+"&RBody="+redScoreDetails[1]+"&RSpinBody="+redScoreDetails[2]+"&RSpinHead="+redScoreDetails[3]+"&RHead="+redScoreDetails[4]+"&RWarning="+redScoreDetails[5]+"&b_score="+b_score+"&BPunch="+blueScoreDetails[0]+"&BBody="+blueScoreDetails[1]+"&BSpinBody="+blueScoreDetails[2]+"&BSpinHead="+blueScoreDetails[3]+"&BHead="+blueScoreDetails[4]+"&BWarning="+blueScoreDetails[5]+"&roundWinner="+who;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", url, false);
		xmlhttp.send();
		// call php update db*/
		if (who=='R'){
		    rWinRounds=rWinRounds+1;
			document.getElementById('r_roundWin').innerHTML=rWinRounds;
			document.getElementById('r_roundWin').style.backgroundColor='green';
			if (rWinRounds>=matchPoint||currentRound==rounds){
			    finalWin();
		    }
		    else{
			    audio.play();
			    window.open("roundWin.php?who=紅回合勝&restTime="+restTime);
		    }
		}
		else if (who=='B'){
		    bWinRounds=bWinRounds+1;
			document.getElementById('b_roundWin').innerHTML=bWinRounds;
			document.getElementById('b_roundWin').style.backgroundColor='green';
			if (bWinRounds>=matchPoint||currentRound==rounds){
			    finalWin();
		    }
	        else{
		    	audio.play();
		    	window.open("roundWin.php?who=藍回合勝&restTime="+restTime);
	    	}
		}
	}
<!--recordScore-->

<!--reset for rounds-->
function resetRound(nextRound){
	for (let i = 0; i < redScoreDetails.length; i++){
		redScoreDetails[i] = 0; 
		blueScoreDetails[i] = 0; 
	}
	
	document.getElementById('r_score').innerHTML='0';
	document.getElementById('b_score').innerHTML='0';
	document.getElementById('r_warning').innerHTML='0';
	document.getElementById('b_warning').innerHTML='0';
	currentRound = currentRound+nextRound;
	
	document.getElementById("round").innerHTML = currentRound;
	document.getElementById("state").innerHTML = 0;
	if (setSeconds<10){
		document.getElementById("seconds").innerHTML ="0"+setSeconds;
	}
	else{
		document.getElementById("seconds").innerHTML = setSeconds
	}
	if (setMinutes<10){
		document.getElementById("minutes").innerHTML ="0"+setMinutes;
	}
	else{
		document.getElementById("minutes").innerHTML = setMinutes
	}	
	seconds =  parseInt(setSeconds);
	minutes =  parseInt(setMinutes);
}
<!--reset for rounds-->
</script>
<body>
	<!--red-->
	<div id=red style=background-color:red;float:left;>
		<table width="100%" height="100%" border=0>
			<tr>
				<td id='R_r1' style="font-size:48px;">R1</td>
				<td width="35%"></td>
				<td id='r_roundWin' width="10%"></td>
				<td width="35%"></td>
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
						<span id=r_warning>0</span> </big></big></big></big>
					</font>
				</td>
				<td width=15%><font color=white size=7>Round</font></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td width=10% align=center id="R_r2" style="font-size:48px;">R2</td>

				<td></td>
				<td align="right"><font color=white size=7> <span id="minutes"><?php if ($minutes<10){echo "0";echo $minutes;}else{echo $minutes;}?></span>:</font></td>
			</tr>
		</table>
	</div>
	<!--red-->
	<!--blue-->
	<div id=blue style=background-color:blue;float:left;>
		<table width="100%" height="100%" border=0>
			<tr>
				<td id='B_r1' style="font-size:48px;">R1</td>
				<td width="35%"></td>
				<td id='b_roundWin' width="10%"></td>
				<td width="35%"></td>
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
		<tr >
			<td colspan=2 align="center">
			<button onclick="closeScoringPannel()">關閉</button>
			</td>
		</tr>
		<tr >
			<td colspan=2 align="center">
			如直接按下一回合/上一回合，比賽數據不會被記錄
			</td>
		</tr>
		<tr >
			<td>
				<button onclick="resetRound(-1)">上一回合</button>
			</td>
			<td align="right">
				<button onclick="resetRound(1)">下一回合</button> 
			</td>
		</tr>
		<tr >
			<td colspan=2 align="center">
			<button onclick="resetRound(0)">重置回合</button>
			</td>
		</tr>
		</table>
	</div>	
	<!--scoringPannel-->
	
	<!--referee Meeting-->
	<div id="refereePannel">
	    <table style="width:100%;">
		<tr>
			<td>
				<button onclick="recordScore('R')">紅回合勝</button> 
			</td>
			<td align="right">
				<button onclick="recordScore('B')">藍回合勝</button>
			</td>
		</tr>
		<tr >
			<td colspan=2 align="center">
			<button onclick="closeRefereePannel()">關閉</button>
			</td>
		</tr>
		</table
	</div>
	<!--referee Meeting-->
</body>
</html>		