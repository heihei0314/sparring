<?php

header("Content-type:text/html;charset=utf-8");  

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Wai Tsuen TKD Referee System (Center)</title>
</head>
<body>
<p align=center>
<img src=logo.png height=200 width=200>
<h1 align=center>Wai Tsuen TKD Sparring Referee System (Center)</h1>
</p>
<form target="_blank" method=POST action=defaultGame.php  align=center>
<p>
<p>
Court+Game Name: 
<input type=text name=courtNum></input>
</p>
Round:  
<input type=text name=round value=3></input> 
</p>
<p>
Minutes: 
<input type=text name=minutes value=2></input> 
</p>
<p>
Seconds:
<input type=text name=seconds value=0></input>
</p>
<p>
Rest Time: 
<input type=text name=restTime value=60></input> (Second)
</p>
<p>
Point Gap:
<input type=text name=pointGap value=12></input>
</p>
<p>
Warning:
<input type=text name=warning value=5></input>
</p>
<p>
Sensitive (1second=1000):
<input type=text name=sensitive value=1800></input>
</p>
<p>
Number of referee :
<input type="radio" id="3" name="refereeNum" value="3" checked>3</input> 
<input type="radio" id="1" name="refereeNum" value="1" >1 (please use r2) </input>
</p>
<p>
  <input type="submit" value="Newest WT Rule " formaction="defaultGame.php">
</p>
<p>
  <input type="submit" value="Old Rule: Accumulated Point" formaction="game3referee.php">
</p>
</form>
<table border=1 align=center>
  <tr>
    <td colspan=3>操作說明</td>
    <td rowspan=7><img src='qr code.png' alt=''><br>tkdreferee</td>
  </tr>
  <tr>
    <td>分數/警告改動</td>
    <td colspan=2>c</td> 
  </tr> 
  <tr>
    <td>暫停 / 開始計時</td>
    <td colspan=2>enter</td> 
  </tr> 
  <tr>
    <td>開新一局</td>
    <td colspan=2>end</td> 
  </tr>   
  <tr>
    <td>S: Season</td>
    <td>P: Playoff</td> 
  <tr>
    <td>Z: Practice</td> 
    <td>T: Test</td>
  </tr> 
  </tr> 
</table>
<p>
 <form target="_blank" method=POST  align=center>
Year: 
<input type=text name=year></input>
</p>
Game:  
<input type=text name=game></input> 
</p>
<p>
Password:
<input type=password name=adminpw></input></p>
<p>
  <input type="submit" value="report " formaction="report.php">
</p>
<p>
  <input type="submit" value="Game Schedule" formaction="competition.php">
</p>
</form>
</body>
</html>