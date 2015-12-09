<!DOCTYPE html>
<html>
<head>
	<title>Bloco de Notas</title>
	<meta charset="utf-16">
	<link rel="stylesheet" href="normalize.css">
	<link rel="stylesheet" type='text/css' href="./bd.css">
	<link rel="icon" href="favicon.png">
</head>
<body>
	<div id="wrap">

<?php 
	try{
		// inicia sessão para passar variaveis entre ficheiros php
		session_start();

		// Função para limpar os dados de entrada
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			
			return $data;
		}

		$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
		$user="ist172619"; // -> substituir pelo nome de utilizador
		$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
		$dbname = $user; // a BD tem nome identico ao utilizador

		$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


		$resultado = $connection->prepare("INSERT INTO pagina (userid, pagecounter, nome, idseq, ativa, ppagecounter) VALUES (:userid, 5179, :nomepagina, 1151988, 1 , NULL)");
		$resultado->bindParam(":nomepagina", $nomepagina);
		$resultado->bindParam(":userid", $userid);


		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		 	$nomepagina = test_input($_POST["nomepagina"]);
		 	$userid = test_input($_POST["userid"]);
		}

		$resultado->execute();


	} catch (PDOException $e){
		echo("<p>ERROR: {$e->getMessage()}</p>");
	}
$connection = null;
?>


</body>
</html>
