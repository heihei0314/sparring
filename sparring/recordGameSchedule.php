<?php 
		$court = $_GET['court'];
		$name = $_GET['name'];
		$color = $_GET['color'];
		$Day = $_GET['Day'];
		$year = $_GET['year'];
	
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "INSERT INTO seasonGame (court, 'name', color, 'Day', 'year') VALUES ('$court', '$name', '$color', '$Day', '$year')";
		echo $sql;
		if ($conn->query($sql) === TRUE) {
			//echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;//*/
		}
		
		$conn->close();
	
	?>