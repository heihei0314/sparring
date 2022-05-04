	<?php 
	
		$court = $_GET['court'];
		// Establishing Connection with Database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		// Establishing Connection with Database
		$sql = "SELECT * FROM `gameRecord` WHERE court='$court' ORDER BY `finalScore` DESC";
		$retval = $conn->query( $sql);
		if(! $retval )	{
			die('Could not get data: ' . mysql_error());
		}
			
		$rownum = $retval->num_rows;
		echo "<center><h1>Court: ".$court."</h1></center>";
		echo "<table style='font-size: 48px' align=center border=1 width=90%>";
		echo "<tr><td>"."</td><td align=center>"."Player"."</td><td align=center>"."Total Score"."</td><td align=center>"."A / T"."</td><td align=center>"."P"."</td></tr>";
		for ($i=0; $i<$rownum; $i++){
			$row = $retval->fetch_assoc();
			$n=$i+1;
			echo "<tr><td align=center>".$n.".</td><td align=center>".$row['player']."</td><td align=center>".$row['finalScore']."</td><td align=center>".$row['finalAccuracyScore']."</td><td align=center>".$row['finalPresentationScore']."</td></tr>";
		}
		echo "</table>";
		
		$conn->close();
	
	?>