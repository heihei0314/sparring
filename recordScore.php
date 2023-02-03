	<?php 
		$court = $_GET['court'];
		$round = $_GET['round'];
		$redScore = $_GET['r_score'];
		$RHead = $_GET['RHead'];
		$RBody = $_GET['RBody'];
		$RSpinBody = $_GET['RSpinBody'];
		$RSpinHead = $_GET['RSpinHead'];
		$RPunch = $_GET['RPunch'];
		$RWarning = $_GET['RWarning'];

		$blueScore = $_GET['b_score'];	
		$BHead = $_GET['BHead'];
		$BBody = $_GET['BBody'];
		$BSpinBody = $_GET['BSpinBody'];
		$BSpinHead = $_GET['BSpinHead'];
		$BPunch = $_GET['BPunch'];
		$BWarning = $_GET['BWarning'];

		$roundWinner = $_GET['roundWinner'];
	
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "INSERT INTO gamerecord (court, round, redScore, RPunch, RBody, RSpinBody, RSpinHead, RHead, RWarning, blueScore, BPunch, BBody, BSpinBody, BSpinHead, BHead, BWarning, roundWinner) VALUES ('$court', '$round', '$redScore', '$RPunch', '$RBody', '$RSpinBody', '$RSpinHead', '$RHead', '$RWarning', '$blueScore', '$BPunch', '$BBody', '$BSpinBody', '$BSpinHead', '$BHead', '$BWarning', '$roundWinner')";
		echo $sql;
		if ($conn->query($sql) === TRUE) {
			//echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;//*/
		}
		
		$conn->close();
	
	?>
	