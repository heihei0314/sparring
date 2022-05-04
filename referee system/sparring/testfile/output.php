<html>
<body>
<table>
<tr>
<td id="r_r2">0</td>
</tr>
</table>
</body>


<script>
setInterval(function(){ checkScore(); }, 1000);
function checkScore()
{
	// call php update db
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("r_r2").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "checkScore.php", true);
  xhttp.send();
	// call php update db*/
}

</script>