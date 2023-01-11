	<?php 
		$court = $_GET['court'];
		$rWinningRound = $_GET['rWinningRound'];
		$redScore = $_GET['redScore'];
		$redSpin = $_GET['redSpin'];
		$RWarning = $_GET['RWarning'];

		$bWinningRound = $_GET['bWinningRound'];
		$blueScore = $_GET['blueScore'];
		$blueSpin = $_GET['blueSpin'];
		$BWarning = $_GET['BWarning'];

		$gameWinner = $_GET['gameWinner'];
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "INSERT INTO competitionRecord (court, rWinningRound, redScore, redSpin, RWarning, bWinningRound, blueScore, blueSpin, BWarning, gameWinner) VALUES ('$court', '$rWinningRound', '$redScore', '$redSpin', '$RWarning', '$bWinningRound', '$blueScore', '$blueSpin', '$BWarning', '$gameWinner')";
		//echo $sql;
		if ($conn->query($sql) === TRUE) {
			//echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;//*/
		}
		
		$conn->close();
	
	?>