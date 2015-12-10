<?php

	$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
	$user="ist172619"; // -> substituir pelo nome de utilizador
	$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
	$dbname = $user; // a BD tem nome identico ao utilizador



	try
	{
		$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname.";charset=utf-8", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	}
	catch(PDOException $exception)
	{
		echo "<div class=\"alert alert-danger\" role=\"alert\">{$exception->getMessage()}</div>";
		exit();
	}
?>
