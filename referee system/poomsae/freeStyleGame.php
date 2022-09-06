<?php
	$courtNum = $_GET["courtNum"];
	$refereeNum = $_GET["refereeNum"];
	$player = $_GET["player"];
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
    width: 30%;
    height: 100%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
}
#blue {
    margin: 0;
    border: 1px solid black;
    width: 70%;
    height: 100%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
}
.refereeCell {
    color: white;
    font-size: 48px;
}
.textCell {
    color: white;
    font-size: 24px;
}
</style>

<html>
<head>
	<title>Wai Tsuen TKD Referee System (in Game)</title>
	<meta charset="UTF-8">
</head>
<script>
var courtNum = "<?php echo $courtNum;?>";
var refereeNum = "<?php echo $refereeNum;?>";
var player = "<?php echo $player;?>";
var accuracyScore = new Array();
var presentationScore = new Array();
var checkAccuracyScore = new Array();
var checkPresentationScore = new Array();
var finalScore = 0;
var finalAccuracyScore = 0;
var finalPresentationScore = 0;
var state = 0;
<!--control pannel-->
document.onkeydown = function(evt) {
    evt = evt || window.event;
    
	switch (evt.keyCode)    {
        case 80:    //press p penalties
			penalties(1);
            break;
        case 79:    //press o step back penalties
			penalties(-1);
            break;	
		case 35:    //press end restart
            endGame();
            break;
        case 13:    //press enter stop/start timer
			if (state == 1){ //wait for score
				state = 2;
				clearTimeout(timer);
				scoring = setInterval(function(){ 
					for (i=1; i<=refereeNum; i++){
						checkAccuracy(i.toString()); 
						checkPresentation(i.toString()); 
					}
				}, 1000);
				window.open("alert.php?who=計分開始");
			}
			else if	(state == 0){ //start timer and play
				state = 1;
				timer = setTimeout(countdown, 1000);
			}
            break;		
	}
};
<!--control pannel-->

<!-- delete Data-->
function endGame(){
	var xhttp = new XMLHttpRequest();
	var response;
	xhttp.open("GET","endGame.php?court="+courtNum+"&player="+player+"&finalScore="+finalScore+"&finalAccuracyScore="+finalAccuracyScore+"&finalPresentationScore="+finalPresentationScore, true);
	xhttp.send();
	window.open("index.php", "_self");
}
<!-- delete Data-->

<!--score calculation-->
function scoreCalculation(){
	clearInterval(scoring);					
	var audio = new Audio('finish.mp3');
	audio.play();
	document.getElementById("r1_as").style.backgroundColor = "red";
	document.getElementById("r1_ps").style.backgroundColor = "red";
	document.getElementById("r2_as").style.backgroundColor = "red";
	document.getElementById("r2_ps").style.backgroundColor = "red";
	document.getElementById("r3_as").style.backgroundColor = "red";
	document.getElementById("r3_ps").style.backgroundColor = "red";
	document.getElementById("r4_as").style.backgroundColor = "red";
	document.getElementById("r4_ps").style.backgroundColor = "red";
	document.getElementById("r5_as").style.backgroundColor = "red";
	document.getElementById("r5_ps").style.backgroundColor = "red";
	document.getElementById("r6_as").style.backgroundColor = "red";
	document.getElementById("r6_ps").style.backgroundColor = "red";
	document.getElementById("r7_as").style.backgroundColor = "red";
	document.getElementById("r7_ps").style.backgroundColor = "red";
	var avg = refereeNum;
	var accuracyScoreSum = 0;
	var presentationScoreSum = 0;
	if (refereeNum > 3){ // 5-man or 7-man referee
		accuracyScore.sort(function(a, b){return a - b});
		accuracyScore.pop();
		accuracyScore.shift();
		presentationScore.sort(function(a, b){return a - b});
		presentationScore.pop();
		presentationScore.shift();
		avg = refereeNum - 2;
	}
	for (i=0; i<accuracyScore.length; i++){
		accuracyScoreSum = accuracyScoreSum + accuracyScore[i];
		presentationScoreSum = presentationScoreSum + presentationScore[i];
	}
	finalAccuracyScore = accuracyScoreSum*100 / avg;
	finalAccuracyScore = Math.round(finalAccuracyScore)/100;
	finalPresentationScore = presentationScoreSum / avg;
	finalPresentationScore = finalPresentationScore*100;
	finalPresentationScore = Math.round(finalPresentationScore)/100;
	finalScore = (finalAccuracyScore + finalPresentationScore)*100;
	finalScore = Math.round(finalScore)/100;
	//Update Screen
	document.getElementById("finalScore").innerHTML = finalScore;
	document.getElementById("finalAccuracyScore").innerHTML = finalAccuracyScore;
	document.getElementById("finalPresentationScore").innerHTML = finalPresentationScore;
	//Update Screen
}
<!--score calculation-->*/

<!--check score-->
function checkAccuracy(id)	{	
	var xhttp = new XMLHttpRequest();
	var referee = "r"+id;
	var response;
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			response = this.responseText;
			if (response > 0){	
				document.getElementById(referee+"_as").innerHTML = response;
				document.getElementById(referee+"_as").style.backgroundColor = "white";
				checkAccuracyScore[id-1] = 1;
				accuracyScore[id-1] = parseFloat(response);
				if (checkPresentationScore.length == refereeNum && checkAccuracyScore.length == refereeNum){
					scoreCalculation();					
				}
			}	
		}
	};
	xhttp.open("GET","checkScore.php?court="+courtNum+"&referee="+referee+"&AP=A", true);
	xhttp.send();
}
function checkPresentation(id)	{	
	var xhttp = new XMLHttpRequest();
	var referee = "r"+id;
	var response;
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			response = this.responseText;
			if (response > 0){	
				document.getElementById(referee+"_ps").innerHTML = response;
				document.getElementById(referee+"_ps").style.backgroundColor = "white";
				presentationScore[id-1] = parseFloat(response);
				checkPresentationScore[id-1] = 1;
				if (checkPresentationScore.length == refereeNum && checkAccuracyScore.length == refereeNum){
					scoreCalculation();					
				}
			}	
		}
	};
	xhttp.open("GET","checkScore.php?court="+courtNum+"&referee="+referee+"&AP=P", true);
	xhttp.send();
}
<!--check score-->

<!--penalties-->
function penalties(yn){
		var temp = document.getElementById("penalties").innerHTML;
		temp = parseInt(temp);
		temp = temp+yn;
		finalScore = finalScore*10 - 3*yn;
		finalScore = finalScore/10;
		document.getElementById("finalScore").innerHTML = finalScore.toString();
		document.getElementById("penalties").innerHTML = temp.toString();
}
<!--penalties-->

<!--count down-->
var seconds;
var minutes;
var temp; 
function countdown() {

	seconds = document.getElementById('seconds').innerHTML;
	minutes = document.getElementById('minutes').innerHTML;
	seconds = parseInt(seconds, 10);
	minutes = parseInt(minutes, 10);
 
	if (state == 1){
		if (seconds == 59){
			seconds = 0;
			minutes++;
		}
		else	{
			seconds++;
		}
		temp = document.getElementById('seconds');
		if (seconds < 10){
			temp.innerHTML = "0"+seconds;
		}
		else	{
			temp.innerHTML = seconds;
		}
		temp = document.getElementById('minutes');
		if (minutes < 10){
			temp.innerHTML = "0"+minutes;
		}
		else	{
			temp.innerHTML = minutes;
		}		
		timer = setTimeout(countdown, 1000);
	}
}
<!--count down-->

</script>
<body>
	<!--red-->
	<div id=red style=background-color:red;float:left;>
		<table width="100%" height="100%" border=1>
			<tr>
				<td width="50%" class="refereeCell" align="center">Technical</td>
				<td width="50%" class="refereeCell" align="center">Presentation</td>
			</tr>
			<tr>
				<td width="50%" class="refereeCell" align="center" id="r1_as">r1_as</td>
				<td width="50%" class="refereeCell" align="center" id="r1_ps">r1_ps</td>
			</tr>
			<tr>
				<td width="50%" class="refereeCell" align="center" id="r2_as">r2_as</td>
				<td width="50%" class="refereeCell" align="center" id="r2_ps">r2_ps</td>
			</tr>
			<tr>
				<td width="50%" class="refereeCell" align="center" id="r3_as">r3_as</td>
				<td width="50%" class="refereeCell" align="center" id="r3_ps">r3_ps</td>
			</tr>
			<tr>
				<td width="50%" class="refereeCell" align="center" id="r4_as">r4_as</td>
				<td width="50%" class="refereeCell" align="center" id="r4_ps">r4_ps</td>
			</tr>
			<tr>
				<td width="50%" class="refereeCell" align="center" id="r5_as">r5_as</td>
				<td width="50%" class="refereeCell" align="center" id="r5_ps">r5_ps</td>
			</tr>
			<tr>
				<td width="50%" class="refereeCell" align="center" id="r6_as">r6_as</td>
				<td width="50%" class="refereeCell" align="center" id="r6_ps">r6_ps</td>
			</tr>
			<tr>
				<td width="50%" class="refereeCell" align="center" id="r7_as">r7_as</td>
				<td width="50%" class="refereeCell" align="center" id="r7_ps">r7_ps</td>
			</tr>
		</table>
	</div>
	<!--red-->
	<!--blue-->
	<div id=blue style=background-color:blue;float:left;>
		<table width="100%" height="100%" border=0>
			<tr>
				<td align="center"><font color=white size=7><span id="minutes">00</span>:<span id="seconds">00</span></font></td>
				<td width="60%"></td>
				<td class="textCell" align="center">Penalties Amount:&nbsp&nbsp<span id="penalties">0</span></td>
			</tr>
			<tr>
				<td class="textCell" align="center">Technical Skills</td>
				<td style="color: white; font-size: 60px;" align="center"><?php echo $player?></td>
				<td class="textCell" align="center">Final Presentation</td>
			</tr>
			<tr>
				<td class="refereeCell" align="center"><span id=finalAccuracyScore>0</span></td>
				<td></td>
				<td class="refereeCell" align="center"><span id=finalPresentationScore>0</span></td>
			</tr>
			<tr  heigt="70%">
				<td colspan=3 align=center>
					<font color=white><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big><big>
						<span id=finalScore>0</span>	
					</big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></big></font>
				</td>
			</tr>
		</table>
	</div>
	<!--blue-->
</body>
</html>		