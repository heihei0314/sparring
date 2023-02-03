	<?php 
		$court = $_GET['court'];
		$referee = $_GET['referee'];
		$RB = $_GET['RB'];
		$scoreType = $_GET['scoreType'];
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "INSERT INTO scoreevent (court, referee, RB, scoreType) VALUES ('$court', '$referee', '$RB', '$scoreType')";
		if ($conn->query($sql) === TRUE) {
			echo $sql;
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;//*/
		}
		
		$conn->close();
	
	?>