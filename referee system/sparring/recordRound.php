	<?php 
		$court = $_GET['court'];
		$round = $_GET['round'];
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$output=',';		
		
		$sql = "SELECT sum(`RPunch`), sum(`RBody`), sum(`RHead`), sum(`RSpinBody`), sum(`RSpinHead`), sum(`RWarning`), sum(`BPunch`), sum(`BBody`), sum(`BHead`), sum(`BSpinBody`), sum(`BSpinHead`), sum(`BWarning`) FROM `gamerecord` WHERE court='$court' and round='$round' GROUP by `court`";
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysql_error());
		}
		$row = $retval->fetch_assoc();	
		$output = $output.$row['sum(`RPunch`)'].",".$row['sum(`RBody`)'].",".$row['sum(`RHead`)'].",".$row['sum(`RSpinBody`)'].",".$row['sum(`RSpinHead`)'].",".$row['sum(`RWarning`)'].",".$row['sum(`BPunch`)'].",".$row['sum(`BBody`)'].",".$row['sum(`BHead`)'].",".$row['sum(`BSpinBody`)'].",".$row['sum(`BSpinHead`)'].",".$row['sum(`BWarning`)'];
		
		echo $output;		
		$conn->close();
	
	?>