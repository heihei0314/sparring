	<?php 
	
		$court = $_GET['court'];
		//$RB = $_GET['RB'];
		//$referee = $_GET['referee'];
		$checkScoreSecond = 1000*1000;
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "SELECT referee, scoreType, RB FROM `scoreevent` WHERE time>=DATE_SUB(NOW(),INTERVAL $checkScoreSecond MICROSECOND) AND court='$court'";
		//$sql = "SELECT referee, scoreType, RB FROM `scoreevent` WHERE time>=DATE_SUB(NOW(),INTERVAL 2 DAY) AND court='$court'";
		//echo $sql;
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysqli_error());
		}
		$rowcount=mysqli_num_rows($retval);
		$i=0;
		$output='{"scoreEvent":[';
		while ($row = $retval->fetch_assoc()){	
		    $output = $output.'{"referee":"'.$row['referee'].'",';
			$output = $output.'"scoreType":"'.$row['scoreType'].'",';
			$output = $output.'"RB":"'.$row['RB'].'"}';
			$i++;
			if ($i<$rowcount)	{
				$output = $output.',';
			}
		}
		$output = $output.']}';
		echo $output;
		
		$sql = "DELETE FROM `scoreevent` WHERE time>=DATE_SUB(NOW(),INTERVAL $checkScoreSecond MICROSECOND)";
		//$sql = "DELETE FROM `scoreevent` WHERE time>=DATE_SUB(NOW(),INTERVAL 2 DAY) AND court='$court' AND referee='$referee' AND RB='$RB'";
		$retval = $conn->query( $sql);
		$conn->close();
	    
	?>