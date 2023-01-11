<?php 
    if (isset($_POST['adminpw'])){
	    require_once 'db_configs.php';
	    if ($_POST['adminpw'] <> adminPW){
	        window.close();
	    }
    }   
		$year = $_POST['year'];
		$game = $_POST['game'];

		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sqlP = "SELECT * from participant where years = ".$year." and game like '".$game."'";
		$retvalP = $conn->query( $sqlP);
		if(! $retvalP )	{
			die('Could not get data: ' . mysql_error());
		}
		$rowcount=mysqli_num_rows($retvalP);
		$i=0;
		$output='{"participant":[';
		$sortRow=array();
		while ($rowP = $retvalP->fetch_assoc()) {
			$output = $output.'{"name":"'.$rowP['player'].'",';
			$output = $output.'"weight":"'.$rowP['weight_group'].'"}';
		    $i++;
		    //echo $i.$rowcount.", ";
			if ($i<$rowcount)	{
				$output = $output.',';
			}
		}
		$output = $output.']}';
		//echo $output;	
		$conn->close();
	
	?>

<html>
<head>
	<title>Wai Tsuen TKD Sparring Referee System (generating competition)</title>
	<meta charset="UTF-8">
</head>
    <body>
    <select id="selectedClass" onchange="changePlayerlist(this.value)">
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
        <div id="GameSchedule"></div>
        <button onclick=updateDB()>Upload to DB</button>
        <script>
            var weight_group='unlimited';
            var playerList = <?php echo $output?>;
            
            var tempPlayer = [];
            var numPlayers=0;
            var rotatingRounds;
            var pairsPerRound;
            changePlayerlist(weight_group);
            function changePlayerlist(sel){
                weight_group = sel;
                //console.log(weight_group);
                for (m=0;m<playerList.participant.length;m++){
                    if (playerList.participant[m].weight==weight_group){
                        numPlayers++;
                    }
                }
                if (numPlayers%2==0){
                    rotatingRounds = numPlayers-1;
                    pairsPerRound = numPlayers/2;  
                }else{
                    tempPlayer.push("dummy");
                    rotatingRounds = numPlayers;
                    pairsPerRound = (numPlayers-1)/2+1;  
                    numPlayers = numPlayers+1;
                }
                
                for (m=0;m<playerList.participant.length;m++){
                    if (playerList.participant[m].weight==weight_group){
                        tempPlayer.push(playerList.participant[m].name);
                    }
                }
                assignToGame();
            }
            
            //console.log(tempPlayer);
            //tempPlayer.sort(() => (Math.random() > .5) ? 1 : -1); //random sort
            console.log(numPlayers+", "+rotatingRounds+", "+pairsPerRound);
            var games = [];
            var GameScheduleText="";

            function assignToGame(){
                
                var rotatePlayer = 1;
                var indexB;
                var indexR;
                for (r=1;r<=rotatingRounds;r++){
                    if (rotatePlayer<=0){
                        rotatePlayer = numPlayers-1;
                    }
                    //console.log(rotatePlayer);
                    let B = [];
                    let R = [];
                    B.push(tempPlayer[0]);
                    indexB=rotatePlayer;
                    indexR=rotatePlayer-1;
                    if (indexR<=0){
                        indexR = numPlayers-1;
                    }
                    for (n=1;n<pairsPerRound;n++){
                        //console.log("indexB:" +indexB);
                        B.push(tempPlayer[indexB]);
                        R.push(tempPlayer[indexR]);
                        indexB++;
                        if(indexB>numPlayers-1){
                            indexB=1;
                        }

                        indexR--;                        
                        if (indexR<=0){
                            indexR = numPlayers-1;
                        }
                        
                    }                    
                    R.push(tempPlayer[indexR]);
                    rotatePlayer = rotatePlayer-1;
                    gameOutput(r, B, R);
                    //console.log(GameScheduleText);
                }
                document.getElementById("GameSchedule").innerHTML = GameScheduleText;
                
                console.log(games);
            }
            function gameOutput(r, B, R){
                console.log(B);
                console.log(R);
                GameScheduleText += "<table border='1' width='100%' style='text-align:center'><tr>";
                GameScheduleText += "<td colspan='3'> Day " + r + "</td></tr>";
                
                
                for (p=0;p<pairsPerRound;p++){
                    var courtNum = "<?php echo $game?>"+r.toString()+p.toString();
                    GameScheduleText += "<tr>";
                    let addPlayer = '{"Day":' + r +',"Court":"'+courtNum+ '","B":"' + B[p] + '","R":"' + R[p] +'"}'; 
                    playerObj = JSON.parse(addPlayer);
                    games.push(playerObj);
                    GameScheduleText += "<td>"+courtNum+"</td>";
                    GameScheduleText += "<td>"+B[p]+"</td>";
                    GameScheduleText += "<td>"+R[p]+"</td>";
                    GameScheduleText += "</tr>";
                }
                
                GameScheduleText += "</table>";
            }
            function updateDB(){
                for (g=0;g<games.length;g++){
                   
                    //update game schedule 
		            var url = "recordGameSchedule.php?court="+games[g].Court+"&name="+games[g].B+"&color=B"+"&Day="+games[g].Day+"&year="+"<?php echo $year?>";
		            var xmlhttp = new XMLHttpRequest();
		            xmlhttp.open("GET", url, true);
                    console.log(url);
		            xmlhttp.send();
		            
		            var url = "recordGameSchedule.php?court="+games[g].Court+"&name="+games[g].R+"&color=R"+"&Day="+games[g].Day+"&year="+"<?php echo $year?>";
		            var xmlhttp = new XMLHttpRequest();
		            xmlhttp.open("GET", url, true);
		            
                    console.log(url);
		            xmlhttp.send();
		             //update game schedule 
                }
            
            }
        </script>
        
    </body>
</html>