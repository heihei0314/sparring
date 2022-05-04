<!DOCTYPE html>
<html>
<body>

<input type="button" value="r_add_1" id="r_add_1">
<object height="100" width="100" data="won.mp3"></object>
<embed height="100" width="100" src="won.mp3"></embed>
	<audio id="addScoreSound">
		<source src="won.mp3" type="audio/mpeg">
	</audio>
</body>
</html>
<script>
r_add_1.onclick = function() {addRed()};
function addRed(){
		var audio = new Audio('won.mp3');
		audio.play();
		}
		</script>