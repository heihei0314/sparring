	<?php 
	
		$court = $_GET['court'];
		$referee = $_GET['referee'];
		$RB = $_GET['RB'];
		$score = $_GET['score'];
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "INSERT INTO scoreEvent (court, referee, RB, score) VALUES ('$court', '$referee', '$RB', '$score')";
		if ($conn->query($sql) === TRUE) {
			//echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;//*/
		}
		
		$conn->close();
	
	?>