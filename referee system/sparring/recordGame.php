	<?php 
		$court = $_GET['court'];
	
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$output=',';
		$sql = "SELECT count(`roundWinner`) FROM `gamerecord` WHERE court='$court' AND roundWinner='R' GROUP by `court`";
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysql_error());
		}
		$row = $retval->fetch_assoc();	
		
		if(is_array($row)){
		    $output = $output.$row['count(`roundWinner`)'];
		}
		else {
		    $output = $output.'0';
		}
		
		$sql = "SELECT count(`roundWinner`) FROM `gamerecord` WHERE court='$court' AND roundWinner='B' GROUP by `court`";
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysql_error());
		}
		$row = $retval->fetch_assoc();			
		if(is_array($row)){
		    $output = $output.",".$row['count(`roundWinner`)'];
		}
		else {
		    $output = $output.'0';
		}
		
		
		$sql = "SELECT sum(`redScore`), sum(`RSpinBody`), sum(`RSpinHead`), sum(`RWarning`), sum(`blueScore`), sum(`BSpinBody`), sum(`BSpinHead`), sum(`BWarning`) FROM `gamerecord` WHERE court='$court' GROUP by `court`";
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysql_error());
		}
		$row = $retval->fetch_assoc();	
		$output = $output.",".$row['sum(`redScore`)'].",".$row['sum(`RSpinBody`)'].",".$row['sum(`RSpinHead`)'].",".$row['sum(`RWarning`)'].",".$row['sum(`blueScore`)'].",".$row['sum(`BSpinBody`)'].",".$row['sum(`BSpinHead`)'].",".$row['sum(`BWarning`)'];
		
		echo $output;		
		$conn->close();
	
	?>