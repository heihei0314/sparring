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
#red {
    margin: 0;
    border: 1px solid black;
    width: 50%;
    height: 100%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
	-webkit-appearance: none;
}
#blue {
    margin: 0;
    border: 1px solid black;
    width: 50%;
    height: 100%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
	-webkit-appearance: none;
}
.button {
	width: 100%;
	height: 100%;
	font-size: 48px;
	-webkit-appearance: none;
}
</style>
<html>
<head>
<title> Chi Lok Referee System</title>
<meta name="apple-mobile-web-app-capable"
  content="yes" />
<meta name="apple-mobile-web-app-status-bar-style"
  content="black-translucent" />
</head>
<body>
<div id='total'>
<div id=red style=background-color:red;float:left;>
<table width="100%" height="100%" border=0>
<tr>
<td width="33%">	
</td>
<td width="33%" align='center'><button class="button" id="R_add_3" onClick="addScore(this.id)">Head</button>
</td>
<td width="33%">
</td>
</tr>
<tr>
<td><button class="button" id="R_add_1" onClick="addScore(this.id)">Punch</button>
</td>
<td>
</td>
<td><button class="button" id="R_add_2" onClick="addScore(this.id)">Spin</button>
</td>
</tr>
<tr>
<td>
</td>
<td><button class="button" id="R_add_2" onClick="addScore(this.id)">Body</button>
</td>
<td>
</td>
</tr>
</table>
</div>
<div id=blue style=background-color:blue;float:right;>
<table width="100%" height="100%" border=0>
<tr>
<td width="33%">	
</td>
<td width="33%" align='center'><button class="button" id="B_add_3" onClick="addScore(this.id)">Head</button>
</td>
<td width="33%">
</td>
</tr>
<tr>
<td><button class="button" id="B_add_2" onClick="addScore(this.id)">Spin</button>
</td>
<td>
</td>
<td><button class="button" id="B_add_1" onClick="addScore(this.id)">Punch</button>
</td>
</tr>
<tr>
<td>
</td>
<td><button class="button" id="B_add_2" onClick="addScore(this.id)">Body</button>
</td>
<td>
</td>
</tr>
</table>
</div>
</div>
<script>
	function addScore(id){
		//震動
		if("vibrate" in navigator){
			navigator.vibrate(100);
		}
		//震動
		var RB = id.substr(0);
		var score = id.substr(-1);

		// call php update db
		var url = "<?php echo $url;?>"+"&RB="+RB+"&score="+score;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		// call php update db*/
	};
</script>
</body>
</html>