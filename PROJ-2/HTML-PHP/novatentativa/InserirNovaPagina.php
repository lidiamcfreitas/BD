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


		$sequencia = $connection->prepare("INSERT INTO sequencia (userid, moment) VALUES (:userid, NOW())");
		$sequencia = $bindParam(":userid", $userid);

		$sql_maxmom  = "SELECT s.contador_sequencia ";
		$sql_maxmom .= "FROM sequencia s  ";
		$sql_maxmom .= "WHERE s.userid = :userid ";
		$sql_maxmom .= "  AND s.moment = all ";
		$sql_maxmom .= "    ( SELECT max(s2.moment) ";
		$sql_maxmom .= "     FROM sequencia s2  ";
		$sql_maxmom .= "     WHERE s2.userid = :userid)";

		// idseq quando o momento e maximo
		$getmoment = $connection->prepare($sql_maxmom);
		$getmoment = $bindParam(":userid", $userid);
		$getmoment->execute();


		$sql_maxpc  = "SELECT p.pagecounter ";
		$sql_maxpc .= "FROM pagina p  ";
		$sql_maxpc .= "WHERE p.userid = :userid ";
		$sql_maxpc .= "  AND p.pagecounter = all ";
		$sql_maxpc .= "    ( SELECT max(p2.pagecounter) ";
		$sql_maxpc .= "     FROM pagina p2  ";
		$sql_maxpc .= "     WHERE p2.userid = :userid)";

		// maximo page counter do utilizador
		$getmaxpc = $connection->prepare($sql_maxpc);
		$getmaxpc = $bindParam(":userid", $userid);
		$getmaxpc->execute();


		$pagina = $connection->prepare("INSERT INTO pagina (userid, pagecounter, nome, idseq, ativa, ppagecounter) VALUES (:userid, :pagecounter, :nomepagina, :idseq, 1 , NULL)");
		$pagina->bindParam(":nomepagina", $nomepagina);
		$pagina->bindParam(":idseq", $pagemoment);
		$pagina->bindParam(":pagecounter", $maxpc);
		$pagina->bindParam(":userid", $userid);


		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		 	$nomepagina = test_input($_POST["nomepagina"]);
		 	$userid = test_input($_POST["userid"]);
		}
		$pagemoment = $getmoment->fetchColumn();
		$maxpc = $getmaxpc->fetchColumn() + 1;
		echo $pagemoment;
		echo $maxpc;
		$pagina->execute();


	} catch (PDOException $e){
		echo("<p>ERROR: {$e->getMessage()}</p>");
	}
$connection = null;
?>


</body>
</html>
