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
			 	$nreg = test_input($_POST["nomeregisto"]);
			 	$uid = test_input($_POST["userid"]);
			}

			$sequencia = $connection->prepare("INSERT INTO sequencia (moment, userid) VALUES (current_timestamp, $uid)");
			$sequencia->execute();

			$sql_maxmom  = "SELECT s.contador_sequencia ";
			$sql_maxmom .= "FROM sequencia s  ";
			$sql_maxmom .= "WHERE s.userid = :userid ";
			$sql_maxmom .= "  AND s.moment = all ";
			$sql_maxmom .= "    ( SELECT max(s2.moment) ";
			$sql_maxmom .= "     FROM sequencia s2  ";
			$sql_maxmom .= "     WHERE s2.userid = :userid)";

			$getseq = $connection->prepare($sql_maxmom);
			$getseq = $bindParam(":userid", $userid);
			$userid = $uid;
			$getseq->execute();

			$sql_maxtc  = "SELECT r.typecnt ";
			$sql_maxtc .= "FROM tipo_registo r  ";
			$sql_maxtc .= "WHERE r.userid = :userid ";
			$sql_maxtc .= "  AND r.typecnt = ALL  ";
			$sql_maxtc .= "    (SELECT max(r2.typecnt) ";
			$sql_maxtc .= "     FROM tipo_registo r2  ";
			$sql_maxtc .= "     WHERE r2.userid = :userid)";

			$getmaxtc = $connection->prepare($sql_maxpc);
			$getmaxtc = $bindParam(":userid", $userid);
			$userid = $uid;
			$getmaxtc->execute();

			$tiporegisto = $connection->prepare("INSERT INTO tipo_registo (userid, typecnt, nome, idseq, ativo) VALUES (:userid, :typecnt, :nome, :idseq, 1)");

			$tiporegisto->bindParam(":userid", $userid);
			$userid = $uid;
			$tiporegisto->bindParam(":typecnt", $typecnt);
			$tiporegisto->bindParam(":nome", $nomeregisto);
			$tiporegisto->bindParam(":idseq", $idseq);

			$nomeregisto = $nreg;
			$userid = $uid;
			$typecnt = $getmaxtc->fetchColumn();
			$idseq = $getseq->fetchColumn() + 1;

			$tiporegisto->execute();

	} catch (PDOException $e){
			echo("<p>ERROR: {$e->getMessage()}</p>");
		}
	$connection = null;
	?>


	</body>
	</html>


