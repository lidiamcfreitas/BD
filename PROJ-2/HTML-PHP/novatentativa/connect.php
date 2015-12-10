<?php

$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist172619"; // -> substituir pelo nome de utilizador
$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador



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