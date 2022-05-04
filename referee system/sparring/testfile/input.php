<html>
<body>
<div id="r_r1">0</div>
<input type="button" value="r_add_1" id="r_add_1">
<div id="b_r1">0</div>
<input type="button" value="b_add_1" id="b_add_1">
</body>
</html>
<?php
		$court = 'test';
		$referee = 'r2';
		$url = "updateScore.php?court=".$court."&referee=".$referee;
		//echo $url;
?>
<script>
	r_add_1.onclick = function(){
		var temp1 = document.getElementById("r_r1").innerHTML;
		temp1 = parseInt(temp1)+1;
		document.getElementById("r_r1").innerHTML = temp1.toString();	

		// call php update db
		var url = "<?php echo $url.'&RB=R'.'&score=1';?>";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		// call php update db*/
	};
	b_add_1.onclick = function(){
		var temp1 = document.getElementById("b_r1").innerHTML;
		temp1 = parseInt(temp1)+1;
		document.getElementById("b_r1").innerHTML = temp1.toString();	

		// call php update db
		var url = "<?php echo $url.'&RB=B'.'&score=1';?>";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
		// call php update db*/
	};

</script>