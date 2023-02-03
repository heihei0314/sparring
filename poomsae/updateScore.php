	<?php 
	
		$court = $_GET['court'];
		$referee = $_GET['referee'];
		$accuracyScore = $_GET['accuracyScore'];
		$presentationScore = $_GET['presentationScore'];
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "INSERT INTO scoreEvent (court, referee, accuracyScore, presentationScore) VALUES ('$court', '$referee', '$accuracyScore', '$presentationScore')";
		if ($conn->query($sql) === TRUE) {
			//echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;//*/
		}
		
		$conn->close();
	
	?>