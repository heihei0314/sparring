<?php 
		$year = $_GET['year'];
		$game = $_GET['game'];

		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		
		$sqlG = "SELECT name, redScore as accScore, redSpin as spinScore, RWarning as Warning, gameWinner, color FROM competitionRecord, seasonGame WHERE color like 'R' and competitionRecord.court=seasonGame.court and seasonGame.year =".$year." and competitionRecord.court like '".$game."%' UNION SELECT name, blueScore as accScore, blueSpin as spinScore, BWarning as Warning, gameWinner, color FROM competitionRecord, seasonGame WHERE color like 'B' and competitionRecord.court=seasonGame.court and seasonGame.year = ".$year." and competitionRecord.court like '".$game."%' order by name";
		//echo $sqlG;
		$retvalG = $conn->query( $sqlG);
		if(! $retvalG )	{
			die('Could not get data: ' . mysql_error());
		}
		$rowG=array();
		while ($row = $retvalG->fetch_assoc()){
		   array_push($rowG, $row); 
		}	
		
		$sqlP = "SELECT * from participant where years = ".$year." and game like '".$game."' order by player";
		$retvalP = $conn->query( $sqlP);
		if(! $retvalP )	{
			die('Could not get data: ' . mysql_error());
		}
		$rowcount=mysqli_num_rows($retvalP);
		$i=0;
		$output='{"game":[';
		$sortRow=array();
		while ($rowP = $retvalP->fetch_assoc()) {
			$rowP['win'] = 0;
			$rowP['lose'] = 0;
			for ($n=0;$n<count($rowG);$n++){
				if ($rowP['player']==$rowG[$n]['name']){
					if ($rowG[$n]['gameWinner']==$rowG[$n]['color']){
						$rowP['win'] +=1; 
					}
					else{
						$rowP['lose'] +=1; 
					}
					$rowP['accScore'] = $accScore + $rowG[$n]['accScore'];
					$rowP['spinScore'] = $spinScore + $rowG[$n]['spinScore'];
					$rowP['warning'] = $warning + $rowG[$n]['Warning'];
					$rowP['matchPoint'] = $rowP['win'] * 3 + $rowP['lose'];
				}
			}
			array_push($rowP, $sortRow); 
			
			$output = $output.'{"name":"'.$rowP['player'].'",';
			$output = $output.'"weight":"'.$rowP['weight_group'].'",';
			$output = $output.'"win":"'.$rowP['win'].'",';
			$output = $output.'"lose":"'.$rowP['lose'].'",';
			$output = $output.'"accScore":"'.$rowP['accScore'].'",';
			$output = $output.'"spinScore":"'.$rowP['spinScore'].'",';
			$output = $output.'"warning":"'.$rowP['warning'].'",';
			$output = $output.'"matchPoint":"'.$rowP['matchPoint'].'"}';
			
		    $i++;
		    //echo $i.$rowcount.", ";
			if ($i<$rowcount)	{
				$output = $output.',';
			}
		}
		$output = $output.']}';
		echo $output;	
		$conn->close();
	
	?>