	<?php
		$court = $_GET["court"];
		$player = $_GET["player"];
		$finalScore = $_GET["finalScore"];
		$finalAccuracyScore = $_GET["finalAccuracyScore"];
		$finalPresentationScore = $_GET["finalPresentationScore"];
		// connect to database
		require_once 'db_configs.php';
		$conn = new mysqli(host, username, password, dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "DELETE FROM `scoreEvent`";
		$retval = $conn->query( $sql);
		
		if ($conn->connect_error) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		}
		$sql = "INSERT INTO `gameRecord` (court, player, finalScore, finalAccuracyScore, finalPresentationScore) VALUES ('$court', '$player', '$finalScore', '$finalAccuracyScore', '$finalPresentationScore')";
		$retval = $conn->query( $sql);
		$conn->close();
		// connect to database
	?>