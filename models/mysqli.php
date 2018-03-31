<?php
	function database_connect()
	{
		// $hostname = "127.0.0.1"; //for debugging
		$hostname = "db"; //for production
		$user = "root";
		$pass = "root";
		$db = "rush";

		$mysqli = mysqli_connect($hostname, $user, $pass, $db);
		if (mysqli_connect_errno($mysqli))
		{
			echo "Failed to connect to database: " . mysqli_connect_error();
			return (NULL);
		}
		return $mysqli;
	}
?>
