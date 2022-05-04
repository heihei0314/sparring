	<?php 
	

	
	?>
<!DOCTYPE html>
<html>
<body>


<input type="button" value="r_r1" id="r_r1">
<input type="button" value="r_r2" id="r_r2">

<p id="r1">0</p>
<p id="r2">0</p>

<script>
var r_r1_queue = new Array();
var r_r2_queue = new Array();
	setInterval(function(){
		if (r_r1_queue.length>0 || r_r2_queue.length>0){
			if(r_r1_queue.shift()==r_r2_queue.shift()){
				alert("藍方勝");
			}
		}
	
		document.getElementById("r1").innerHTML = r_r1_queue;
		document.getElementById("r2").innerHTML = r_r2_queue;
	}, 1000);

document.getElementById("r1").innerHTML = r_r1_queue;
document.getElementById("r2").innerHTML = r_r2_queue;

function r_r1_queueing() {
    r_r1_queue.push(1);
    document.getElementById("r1").innerHTML = r_r1_queue;
}
function r_r2_queueing() {
    r_r2_queue.push(1);
    document.getElementById("r2").innerHTML = r_r2_queue;
}
r_r1.onclick = function(){
    r_r1_queueing();
};
r_r2.onclick = function(){
   r_r2_queueing();
};
</script>

</body>
</html>