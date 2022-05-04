	<?php 
	
		$court = '0123';
		$RB = 'R';
		$referee = 'r1';
		
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "SELECT * FROM `scoreevent` WHERE court='$court' AND referee='$referee' AND RB='$RB'";
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysql_error());
		}
		$row = $retval->fetch_assoc();	
		echo $row['time'];	
/*
		$sql = "DELETE FROM `scoreevent` WHERE time>=DATE_SUB(NOW(),INTERVAL 1 SECOND) AND court='$court' AND referee='$referee' AND RB='$RB'";
		$retval = $conn->query( $sql);
		$conn->close();
	*/
	?>