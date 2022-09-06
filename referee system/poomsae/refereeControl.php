<?php 
if (isset($_POST['refereePW'])){
	require_once 'db_configs.php';
	if ($_POST['refereePW'] == refereePW){
		$court = $_POST['court'];
		$referee = $_POST['referee'];
		$url = "updateScore.php?court=".$court."&referee=".$referee;
	}
	else 
		echo "<script type=\"text/javascript\">window.alert('Wrong Password');
				window.location.href = 'refereeLogin.php';</script>"; 
}
	
?>	
<style type="text/css">
html, body {
    margin: 0;
    padding: 0;
}

.button {
	width: 100%;
	height: 100%;
	font-size: 48px;
	-webkit-appearance: none;
}
input[type=range] {
  -webkit-appearance: none;
  width: 100%;
  margin: 13.8px 0;
}
input[type=range]:focus {
  outline: none;
}
input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  background: #3071a9;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}
input[type=range]::-webkit-slider-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -14px;
}
input[type=range]:focus::-webkit-slider-runnable-track {
  background: #367ebd;
}
input[type=range]::-moz-range-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  background: #3071a9;
  border-radius: 1.3px;
  border: 0.2px solid #010101;
}
input[type=range]::-moz-range-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
}
input[type=range]::-ms-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  background: transparent;
  border-color: transparent;
  color: transparent;
}
input[type=range]::-ms-fill-lower {
  background: #2a6495;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
}
input[type=range]::-ms-fill-upper {
  background: #3071a9;
  border: 0.2px solid #010101;
  border-radius: 2.6px;
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
}
input[type=range]::-ms-thumb {
  box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
  border: 1px solid #000000;
  height: 36px;
  width: 16px;
  border-radius: 3px;
  background: #ffffff;
  cursor: pointer;
  height: 8.4px;
}
input[type=range]:focus::-ms-fill-lower {
  background: #3071a9;
}
input[type=range]:focus::-ms-fill-upper {
  background: #367ebd;
}

</style>
<html>
<head>
<title> Wai Tsuen TKD Referee System</title>
<meta name="apple-mobile-web-app-capable"
  content="yes" />
<meta name="apple-mobile-web-app-status-bar-style"
  content="black-translucent" />
</head>
<body>
<div id='total'>
<table width="100%" height="100%" border=0>
<tr>
<td width="30%" align="center"><button class="button" onClick="accuracy(1)">-0.1</button></td>
<td width="40%" align="center" style="font-size: 48px;"><span id="accuracyScore">4.0</span></td>
<td width="30%" align="center"><button class="button" onClick="accuracy(3)">-0.3</button></td>
</tr>

<tr>
<td width="30%"align=center style="font-size: 48px;">Speed&Power: </td>
<td width="40%" align="center"><input id="SPRange" type="range" value="20" min="0" max="20" style="width: 100%; height: 100px;" onChange="presentation()"></td>
<td width="30%" align=center style="font-size: 48px;"> <span id="SP">2.0</span></td>
</tr>

<tr>
<td width="30%"align=center style="font-size: 48px;">Control: </td>
<td width="40%" align="center"><input id="ControlRange" type="range" value="20" min="0" max="20" style="width: 100%;" onChange="presentation()"></td>
<td width="30%" align=center style="font-size: 48px;"> <span id="Control">2.0</span></td>
</tr>

<tr>
<td width="30%"align=center style="font-size: 48px;">Energetic: </td>
<td width="40%" align="center"><input id="EnergeticRange" type="range" value="20" min="0" max="20" style="width: 100%;" onChange="presentation()"></td>
<td width="30%" align=center style="font-size: 48px;"> <span id="Energetic">2.0</span></td>
</tr>

<tr>
<td align="center"><button class="button" id="submit" onClick="submit()">Submit</button></td>
<td></td>
<td align="center"></td>

</tr>
</table>
</div>
<script>
var accuracyScore = 4;
var presentationScore = 6;
function accuracy(score){
	var temp = document.getElementById("accuracyScore").innerHTML;
	temp = parseFloat(temp);
	temp = (temp*10 - score)/10;
	
	if (temp <= 0){
		temp = 0;
	}
	accuracyScore = temp;
	document.getElementById("accuracyScore").innerHTML = temp.toString();

}
function presentation(){
	
	var SP;
	SP = document.getElementById("SPRange").value;
	SP = parseFloat(SP);
	SP = SP/10;
	document.getElementById("SP").innerHTML = SP.toString();
	
	var Control;
	Control = document.getElementById("ControlRange").value;
	Control = parseFloat(Control);
	Control = Control/10;
	document.getElementById("Control").innerHTML = Control.toString();
	
	var Energetic;
	Energetic = document.getElementById("EnergeticRange").value;
	Energetic = parseFloat(Energetic);
	Energetic = Energetic/10;
	document.getElementById("Energetic").innerHTML = Energetic.toString();	
	
	presentationScore = SP + Control + Energetic;
	
}
function submit(){
		// call php update db
		var url = "<?php echo $url;?>"+"&accuracyScore="+accuracyScore+"&presentationScore="+presentationScore;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		// call php update db*/
		alert("OK");
}
</script>
</body>
</html>