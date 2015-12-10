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

		
		echo "1";

		require "connect.php";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		 	$npag = test_input($_POST["nomepagina"]);
		 	$uid = test_input($_POST["userid"]);
		}

		$sequencia = $connection->prepare("INSERT INTO sequencia (moment, userid) VALUES (current_timestamp, $uid)");
		$bindParam(":userid", $userid);
		$sequencia->execute();


		echo "2";
		$sql_maxmom  = "SELECT s.contador_sequencia ";
		$sql_maxmom .= "FROM sequencia s  ";
		$sql_maxmom .= "WHERE s.userid = :userid ";
		$sql_maxmom .= "  AND s.moment = all ";
		$sql_maxmom .= "    ( SELECT max(s2.moment) ";
		$sql_maxmom .= "     FROM sequencia s2  ";
		$sql_maxmom .= "     WHERE s2.userid = :userid)";

		echo "3";
		// idseq quando o momento e maximo
		$getmoment = $connection->prepare($sql_maxmom);
		$getmoment = $bindParam(":userid", $userid);
		$userid = $uid;
		$getmoment->execute();

		echo "4";

		$sql_maxpc  = "SELECT p.pagecounter ";
		$sql_maxpc .= "FROM pagina p  ";
		$sql_maxpc .= "WHERE p.userid = :userid ";
		$sql_maxpc .= "  AND p.pagecounter = all ";
		$sql_maxpc .= "    ( SELECT max(p2.pagecounter) ";
		$sql_maxpc .= "     FROM pagina p2  ";
		$sql_maxpc .= "     WHERE p2.userid = :userid)";

		echo "5";
		// maximo page counter do utilizador
		$getmaxpc = $connection->prepare($sql_maxpc);
		$getmaxpc = $bindParam(":userid", $userid);
		$userid = $uid;
		$getmaxpc->execute();
		echo "6";

		$pagina = $connection->prepare("INSERT INTO pagina (userid, pagecounter, nome, idseq, ativa, ppagecounter) VALUES (:userid, :pagecounter, :nomepagina, :idseq, 1 , NULL)");
		$pagina->bindParam(":nomepagina", $nomepagina);
		$pagina->bindParam(":idseq", $pagemoment);
		$pagina->bindParam(":pagecounter", $maxpc);
		$pagina->bindParam(":userid", $userid);

		echo "7";
		$nomepagina = $npag;
		$userid = $uid;
		$pagemoment = $getmoment->fetchColumn();
		$maxpc = $getmaxpc->fetchColumn();
		++$maxpc;
		echo "pagemoment:".$pagemoment;
		echo $maxpc;
		echo $nomepagina;
		echo $userid;
		$pagina->execute();
		echo "8";

	} catch (PDOException $e){
		echo("<p>ERROR: {$e->getMessage()}</p>");
	}
$connection = null;
?>


</body>
</html>
