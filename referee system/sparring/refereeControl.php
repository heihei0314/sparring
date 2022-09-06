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

<html>
<head>
<style>

#red {
    background-color:red;
}
#blue {
     background-color:blue;

}
button {
	width: 100%;
	height: 100%;
	font-size: 24px;
}
table {
    height: 100%;
    width: 100%;
}
tr {
    height: 33%;
}
td {
    width: 12.5%;
}
</style>
<title>Wai Tsuen TKD Sparring Referee System (Referee)</title>
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" >
<meta name="apple-mobile-web-app-capable" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" >
</head>
<body>
<table>
    
<tr>
<td id=red>	<button id="RHead" onClick="addScore(this.id)">Head&nbsp</button>
</td>
<td id=red>
</td>
<td id=red><button id="RSpinHead" onClick="addScore(this.id)">SpinH&nbsp</button>
</td>
<td id=red>
</td>
<td id=blue>
</td>
<td id=blue><button id="BHead" onClick="addScore(this.id)">Head&nbsp</button>
</td>
<td id=blue>
</td>
<td id=blue><button id="BSpinHead" onClick="addScore(this.id)">SpinH&nbsp</button>
</td>
</tr>

<tr>
<td id=red>	
</td>
<td id=red><button id="RPunch" onClick="addScore(this.id)">Punch</button>
</td>
<td id=red>
</td>
<td id=red align=right><font color=white id="court" >court</font>
</td>
<td id=blue align=left><font color=white id="referee" >referee</font>
</td>
<td id=blue>
</td>
<td id=blue><button id="BPunch" onClick="addScore(this.id)">Punch</button>
</td>
<td id=blue>
</td>
</tr>

<tr>
<td id=red>	<button id="RBody" onClick="addScore(this.id)">body&nbsp</button>
</td>
<td id=red> 
</td>
<td id=red><button id="RSpinBody" onClick="addScore(this.id)">SpinB&nbsp</button>
</td>
<td id=red>
</td>
<td id=blue>
</td>
<td id=blue><button id="BBody" onClick="addScore(this.id)">body&nbsp</button>
</td>
<td id=blue> 
</td>
<td id=blue><button id="BSpinBody" onClick="addScore(this.id)">SpinB&nbsp</button>
</td>
</tr>

</table>

<script>
var court = "<?php echo $court;?>";
var referee = "<?php echo $referee;?>";
var elem = document.documentElement;
var RB = "";
var score = 0;
var scoreType = "";
	function addScore(id){
		//震動
		if("vibrate" in navigator){
			navigator.vibrate(100);
		}
		//震動
		RB = id.substring(0,1);
        scoreType = id.substring(1);

		// call php update db
		var url = "<?php echo $url;?>"+"&RB="+RB+"&scoreType="+scoreType;
		//alert(url);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		// call php update db*/
		//full screen
		if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen();
        }
        //full screen
	};
	
	//prevent scaling
    window.onload = () => {
        document.getElementById("court").innerHTML = court.toString();
        document.getElementById("referee").innerHTML = referee.toString();
        document.addEventListener('touchmove', function (event) {
            if (event.scale !== 1) { event.preventDefault(); }
            }, { passive: false });
  
        let lastTouchEnd = 0;
        document.addEventListener('touchend', (event) => {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 100) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    }
	//prevent scaling
	
	
</script>
</body>
</html>