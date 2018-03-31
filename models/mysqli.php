<?php
	function database_connect()
	{
		$add = "db";
		$user = "root";
		$pass = "root";
		$db = "rush";

		$mysqli = mysqli_connect($add, $user, $pass, $db);
		if (mysqli_connect_errno($mysqli))
		{
			echo "Failed to connect to database: " . mysqli_connect_error();
			return (NULL);
		}
		return $mysqli;
	}
