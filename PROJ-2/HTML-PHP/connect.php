<?php

	$host="localhost";	// MySQL is hosted in this machine
	$user="";	// <== replace istxxx by your IST identity
	$password="";	// <== paste here the password assigned by mysql_reset
	$dbname = "";	// Do nothing here, your database has the same name as your username.



	try
	{
		$con = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password);
	}
	catch(PDOException $exception)
	{		
		echo "<div class=\"alert alert-danger\" role=\"alert\">{$exception->getMessage()}</div>";
		exit();
	}
?>