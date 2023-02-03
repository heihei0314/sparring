<?php

header("Content-type:text/html;charset=utf-8");  

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title> Wai Tsuen TKD Poomsae Referee System (Center)</title>
</head>
<body>
<p align=center>
<img src=logo.png height=200 width=200>
<h1 align=center>Wai Tsuen TKD Poomsae Referee System (Center)</h1>
</p>
<form method=GET action=game.php  align=center>
<p>
<p>
Court: 
<input type=text name=courtNum></input>
</p>
Referee Amount: 
<input type=text name=refereeNum></input>
</p>
<p>
Player:
<input type=text name=player></input>
</p>
<p>
<input type="submit" value="Normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Free Style" formaction="freeStyleGame.php">
</p>
<p>
<input type="submit" value="Result" formaction="result.php">
</p>
</form>
<table border=1 align=center>
  <tr>
    <td colspan=2>操作說明</td>
  </tr>
  <tr>
    <td>扣分</td>
    <td>p</td> 
  </tr>
  <tr>
    <td>還原扣分</td>
    <td>o</td> 
  </tr>
  <tr>
    <td>開始計時 / 計分</td>
    <td>enter</td> 
  </tr> 
  <tr>
    <td>儲存得分</td>
    <td>end</td> 
  </tr>   
</table>
</body>
</html>