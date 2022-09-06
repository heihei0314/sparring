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
<td width="30%"align=center style="font-size: 48px;">Difficulties: </td>
<td width="40%" align="center"><input id="DRange" type="range" value="0" min="0" max="50" style="width: 100%; height: 100px;" onChange="accuracy()"></td>
<td width="30%" align=center style="font-size: 48px;"> <span id="Difficulties">0.0</span></td>
</tr>

<tr>
<td width="30%"align=center style="font-size: 48px;">Basic Movements: </td>
<td width="40%" align="center"><input id="BRange" type="range" value="0" min="0" max="10" style="width: 100%; height: 100px;" onChange="accuracy()"></td>
<td width="30%" align=center style="font-size: 48px;"> <span id="Basic">0.0</span></td>
</tr>

<tr>
<td width="30%"align=center style="font-size: 48px;">Presentation: </td>
<td width="40%" align="center"><input id="PRange" type="range" value="0" min="0" max="40" style="width: 100%; height: 100px;" onChange="presentation()"></td>
<td width="30%" align=center style="font-size: 48px;"> <span id="Presentation">0.0</span></td>
</tr>

<tr>
<td align="center"><button class="button" id="submit" onClick="submit()">Submit</button></td>
<td></td>
<td align="center"></td>

</tr>
</table>
</div>
<script>
var accuracyScore = 6;
var presentationScore = 4;
function accuracy(id){
	var Difficulties;
	Difficulties = document.getElementById("DRange").value;
	Difficulties = parseFloat(Difficulties);
	Difficulties = Difficulties/10;
	document.getElementById("Difficulties").innerHTML = Difficulties.toString();
	
	var Basic;
	Basic = document.getElementById("BRange").value;
	Basic = parseFloat(Basic);
	Basic = Basic/10;
	document.getElementById("Basic").innerHTML = Basic.toString();
	
	accuracyScore = Difficulties + Basic;
}
function presentation(){
	
	presentationScore = document.getElementById("BRange").value;
	presentationScore = parseFloat(presentationScore);
	presentationScore = presentationScore/10;
	document.getElementById("Presentation").innerHTML = presentationScore.toString();
	
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