<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {font-family: Arial;}
        
    /* Style the tab content */
    .tabcontent {
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
    </style>
    </head>
<body>
<?php 
    if (isset($_POST['adminpw'])){
	    require_once 'db_configs.php';
	    if ($_POST['adminpw'] <> adminPW){
	        window.close();
	    }
    }  
  $year = $_POST['year'];
 $game = $_POST['game'];
  //$year = '2022';
  //$game = 'S'
?>
<h2>校友交流賽常規賽積分</h2>

<div id="allGameRecord" class="tabcontent">
  <select id="selectedClass" onchange="showAllRecord(this.value)">
        <option value="unlimited">Unlimited</option>
        <option value="M_Fin">Male Fin</option>
        <option value="M_Fly">Male Fly</option>
        <option value="M_Bantam">Male Bantam</option>
        <option value="M_Feather">Male Feather</option>
        <option value="M_Light">Male Light</option>
        <option value="M_Welter">Male Welter</option>
        <option value="M_Middle">Male Middle</option>
        <option value="M_Heavy">Male Heavy</option>
        <option value="M_Unlimited">Male Unlimited</option>
        <option value="F_Fin">Female Fin</option>
        <option value="F_Fly">Female Fly</option>
        <option value="F_Bantam">Female Bantam</option>
        <option value="F_Feather">Female Feather</option>
        <option value="F_Light">Female Light</option>
        <option value="F_Welter">Female Welter</option>
        <option value="F_Middle">Female Middle</option>
        <option value="F_Heavy">Female Heavy</option>
        <option value="F_Unlimited">Female Unlimited</option>
    </select>
  <p id="allGameRecordTable"></p>
</div>

<!--get report--> 
<script>
var year = "<?php echo $year;?>";
var game = "<?php echo $game;?>";
var weight_group='unlimited';
var recordObj;
var allGameRecordText;

/*All  Record*/
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText); 
    recordObj = JSON.parse(this.responseText);    
    showAllRecord(weight_group);
  }
};
xmlhttp.open("GET", "leaderboard.php?year="+year+"&game="+game, false);
xmlhttp.send();

/*All  Record*/

/*generate ranking*/
function ranking() {
    console.log(recordObj.game); 
    recordObj.game = recordObj.game.slice().sort((a, b) => (a.warning - b.warning)*1);
    recordObj.game = recordObj.game.slice().sort((a, b) => (a.spinScore - b.spinScore)*-1);
    recordObj.game = recordObj.game.slice().sort((a, b) => (a.accScore - b.accScore)*-1);    
    let r=1;
    let highestScore = 0;
    for(i=0;i<recordObj.game.length;i++){
        if (recordObj.game[i].weight == weight_group) {   
            if (highestScore < recordObj.game[i].accScore){
              highestScore=recordObj.game[i].accScore;
            }
            else if(highestScore == recordObj.game[i].accScore){
              r--;
            }
            recordObj.game[i].scoreRank=r;
            r++;
        }
    }
    recordObj.game = recordObj.game.slice().sort((a, b) => (a.win - b.win)*-1);
    let r1=1;
    let highestWin = 0;
    var tempRank=1;
    for(i=0;i<recordObj.game.length;i++){
        if (recordObj.game[i].weight == weight_group) {
            if (highestWin < recordObj.game[i].win){
              highestWin=recordObj.game[i].win;
            }
            else if(highestWin == recordObj.game[i].win & recordObj.game[i].scoreRank==tempRank){
              r1--;
            }
            recordObj.game[i].winRank=r1;
            tempRank = recordObj.game[i].scoreRank;
            r1++;
        }
    }
    recordObj.game = recordObj.game.slice().sort((a, b) => (a.matchPoint - b.matchPoint)*-1);
    let r2=1;
    let highestMatchPoint = 0;
    tempRank=1;
    for(i=0;i<recordObj.game.length;i++){
        if (recordObj.game[i].weight == weight_group) {
            if (highestMatchPoint < recordObj.game[i].matchPoint){
              highestMatchPoint=recordObj.game[i].matchPoint;
            }
            else if(highestMatchPoint == recordObj.game[i].matchPoint & recordObj.game[i].winRank==tempRank){
              r2--;
            }
            recordObj.game[i].rank=r2;
            tempRank = recordObj.game[i].winRank;
            r2++;
        }
    }
}
/*generate ranking*/

/*show all record*/
function showAllRecord(sel) {
    weight_group = sel;
    ranking();
  allGameRecordText = "<table border='1'><tr>";
  allGameRecordText +=  "<td>Name <button onclick=sortTable(1,'name')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'name')><i class='fa fa-caret-down'></i></button></td>";
  allGameRecordText +=  "<td>Win <button onclick=sortTable(1,'win')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'win')><i class='fa fa-caret-down'></i></button></td>";
  allGameRecordText +=  "<td>Lose <button onclick=sortTable(1,'lose')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'lose')><i class='fa fa-caret-down'></i></button></td>";
  allGameRecordText +=  "<td>Acc Score  <button onclick=sortTable(1,'accScore')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'accScore')><i class='fa fa-caret-down'></i></button></td>";
  allGameRecordText +=  "<td>Spin Score  <button onclick=sortTable(1,'spinScore')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'spinScore')><i class='fa fa-caret-down'></i></button></td>";
  allGameRecordText +=  "<td>Warning  <button onclick=sortTable(1,'warning')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'warning')><i class='fa fa-caret-down'></i></button></td>";
  allGameRecordText +=  "<td>Match Point <button onclick=sortTable(1,'matchPoint')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'matchPoint')><i class='fa fa-caret-down'></i></button></td>";
  allGameRecordText +=  "<td>Rank <button onclick=sortTable(1,'rank')><i class='fa fa-caret-up'></i></button><button onclick=sortTable(-1,'rank')><i class='fa fa-caret-down'></i></button></td>";
  
  
  for(i=0;i<recordObj.game.length;i++){
    if(recordObj.game[i].weight == sel){
      allGameRecordText += "<tr>";
      allGameRecordText += "<td>" + recordObj.game[i].name + "</td>";
      allGameRecordText += "<td>" + recordObj.game[i].win + "</td>";
      allGameRecordText += "<td>" + recordObj.game[i].lose + "</td>";
      allGameRecordText += "<td>" + recordObj.game[i].accScore + "</td>";
      allGameRecordText += "<td>" + recordObj.game[i].spinScore + "</td>";
      allGameRecordText += "<td>" + recordObj.game[i].warning + "</td>";
      allGameRecordText += "<td>" + recordObj.game[i].matchPoint + "</td>";
      allGameRecordText += "<td>" + recordObj.game[i].rank + "</td>";
      allGameRecordText += "</tr>";
    }
  }
allGameRecordText += "</table>";
document.getElementById("allGameRecordTable").innerHTML = allGameRecordText;
}
/*show all record*/



</script>
<!--get report--> 


<!--sort report--> 
<script>
  function sortTable(o, type) {
    let sortedData =recordObj.game;
    switch(type){
      case 'name':
        sortedData.sort(function(a, b){
          let x = "";
          if (a.name!=null){
            x = a.name.toLowerCase();
          }
          let y = "";
          if (b.name!=null){
            y = b.name.toLowerCase();
          }
          
          if (x < y) {return -1*o;}
          if (x > y) {return 1*o;}
          return 0;
        });  
        break;
      case 'win':
        sortedData = sortedData.slice().sort((a, b) => (a.win - b.win)*o);
        break;
      case 'lose':
        sortedData = sortedData.slice().sort((a, b) => (a.lose - b.lose)*o);
        break;
      case 'matchPoint':
        sortedData = sortedData.slice().sort((a, b) => (a.matchPoint - b.matchPoint)*o);
        break;
      case 'accScore':
        sortedData = sortedData.slice().sort((a, b) => (a.accScore - b.accScore)*o);
        break;
      case 'spinScore':
        sortedData = sortedData.slice().sort((a, b) => (a.spinScore - b.spinScore)*o);  
        break;
      case 'rank':
        sortedData = sortedData.slice().sort((a, b) => (a.rank - b.rank)*o);  
        break;
    }
    console.log(sortedData); 
    recordObj.game = sortedData;
    showAllRecord();
  }
  
  </script>
<!--sort report--> 

</body>
</html>