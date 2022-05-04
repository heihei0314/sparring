	<?php 
	
		$court = $_GET['court'];
		$referee = $_GET['referee'];
		$AP = $_GET['AP'];
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "SELECT * FROM `scoreEvent` WHERE court='$court' AND referee='$referee'";
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysql_error());
		}
		$row = $retval->fetch_assoc();	
		
		if ($AP == "A"){
			echo $row['accuracyScore'];	
		}
		else if ($AP == "P"){
			echo $row['presentationScore'];	
		}

		$conn->close();
	
	?>