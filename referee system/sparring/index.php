<?php

header("Content-type:text/html;charset=utf-8");  

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title> Chi Lok Referee System</title>
</head>
<body>
<p align=center>
<img src=logo.png height=200 width=200>
<h1 align=center>Chi Lok Referee System (Center)A</h1>
</p>
<form method=GET action=game.php  align=center>
<p>
<p>
Court: 
<input type=text name=courtNum></input>
</p>
Round: 
<input type=text name=round></input>
</p>
<p>
Minutes:
<input type=text name=minutes></input>
</p>
<p>
Seconds:
<input type=text name=seconds></input>
</p>
<p>
Rest Time:
<input type=text name=restTime></input>
</p>
<p>
<input type="submit" value="3 Referee">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="1 Referee" formaction="game1referee.php">
</p>
</form>
<table border=1 align=center>
  <tr>
    <td>操作說明</td>
    <td>紅方</td> 
    <td>藍方</td>
  </tr>
  <tr>
    <td>加一分</td>
    <td>q</td> 
    <td>o</td>
  </tr>
  <tr>
    <td>減一分</td>
    <td>w</td> 
    <td>p</td>
  </tr>  
  <tr>
    <td>加一警告</td>
    <td>a</td> 
    <td>k</td>
  </tr>  
  <tr>
    <td>減一警告</td>
    <td>s</td> 
    <td>l</td>
  </tr>
  <tr>
    <td>暫停 / 開始計時</td>
    <td colspan=2>enter</td> 
  </tr> 
  <tr>
    <td>開新一局</td>
    <td colspan=2>end</td> 
  </tr>   
</table>
</body>
</html>