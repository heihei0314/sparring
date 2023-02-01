<?php
    // Establishing Connection with Database
	require_once '../db_configs.php';
	$conn = new mysqli(host, username, password, dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	// Establishing Connection with Database

    $games = array();
	//get data from database	
	$sql = "SELECT `gamerecord`.`court`, `gameWinner`, `rWinningRound`, `bWinningRound`, sum(`gamerecord`.`redScore`), sum(`RPunch`), sum(`RBody`), sum(`RSpinBody`), sum(`RSpinHead`), sum(`RHead`), sum(`gamerecord`.`RWarning`), sum(`gamerecord`.`blueScore`), sum(`BPunch`), sum(`BBody`), sum(`BSpinBody`), sum(`BSpinHead`), sum(`BHead`), sum(`gamerecord`.`BWarning`) FROM `gamerecord`, `competitionRecord` WHERE `gamerecord`.`court` LIKE `competitionRecord`.`court` GROUP by `gamerecord`.`court`";//get all game record
	$retval = $conn->query( $sql);
	if(! $retval )	{
		die('Could not get data: ' . mysql_error());
	}
	
	//add data into array
	while ($row = $retval->fetch_assoc()){	
	    array_push($games, array(
           "court" => $row['court'],
            "gameWinner" => $row['gameWinner'],
            "rWinningRound" => $row['rWinningRound'],
            "bWinningRound" => $row['bWinningRound'],
            "RScore" => $row['sum(`gamerecord`.`redScore`)'],
            "RPunch" => $row['sum(`RPunch`)'],
            "RBody" => $row['sum(`RBody`)'],
            "RSpinBody" => $row['sum(`RSpinBody`)'],
            "RSpinHead" => $row['sum(`RSpinHead`)'],
            "RHead" => $row['sum(`RHead`)'],
            "RWarning" => $row['sum(`gamerecord`.`RWarning`)'],
            "blueScore" => $row['sum(`gamerecord`.`blueScore`)'],
            "BPunch" => $row['sum(`BPunch`)'],
            "BBody" => $row['sum(`BBody`)'],
            "BSpinBody" => $row['sum(`BSpinBody`)'],
            "BSpinHead" => $row['sum(`BSpinHead`)'],
            "BHead" => $row['sum(`BHead`)'],
            "BWarning" => $row['sum(`gamerecord`.`BWarning`)']
        ));
	}
	//add data into array
	
	$athletes = array();
	//get data from database	
	$sql = "SELECT `court`, `name`, `color` FROM `seasonGame`";//get all athletes participation record
	$retval = $conn->query( $sql);
	if(! $retval )	{
		die('Could not get data: ' . mysql_error());
	}
		
	//add data into array
	while ($row = $retval->fetch_assoc()){	
	    array_push($athletes, array(
            "name" => $row['name'],
            "court" => $row['court'],
            "Color" => $row['color']
        ));
	}
	//add data into array
	
	$conn->close();
	//get data from database	

    // Create Array and convert to JSON
    $json = array(
        "athletes" => $athletes,
        "games" => $games,
    );
    $response = json_encode($json);
    // Create Array and convert to JSON

    // Set header to JSON format
    header('Content-Type: application/json; charset=utf-8');
    // Set header to JSON format
  
    // return JSON
    echo $response;
    // return JSON
?>
