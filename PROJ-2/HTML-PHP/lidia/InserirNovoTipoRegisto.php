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

			require "connect.php";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$uid = test_input($_POST["userid"]);
			 	$nreg = test_input($_POST["nometiporegisto"]);
			}


			$connection->beginTransaction();

			$sequencia = $connection->prepare("INSERT INTO sequencia (moment, userid) VALUES (current_timestamp, $uid)");
			$sequencia->execute();

			$sql_maxmom  = "SELECT s.contador_sequencia ";
			$sql_maxmom .= "FROM sequencia s  ";
			$sql_maxmom .= "WHERE s.userid = ".$uid;
			$sql_maxmom .= " AND s.moment = all ";
			$sql_maxmom .= "( SELECT max(s2.moment) ";
			$sql_maxmom .= "FROM sequencia s2  ";
			$sql_maxmom .= "WHERE s2.userid = ".$uid.')';


			$getseq = $connection->prepare($sql_maxmom);

			//$getseq = $bindParam(":userid", $uid);
			$getseq->execute();



			$sql_maxtc  = "SELECT r.typecnt ";
			$sql_maxtc .= "FROM tipo_registo r  ";
			$sql_maxtc .= "WHERE r.userid = ".$uid;
			$sql_maxtc .= "  AND r.typecnt = ALL  ";
			$sql_maxtc .= "    (SELECT max(r2.typecnt) ";
			$sql_maxtc .= "     FROM tipo_registo r2  ";
			$sql_maxtc .= "     WHERE r2.userid = ".$uid.')';


			$getmaxtc = $connection->prepare($sql_maxtc);
			//$getmaxtc = $bindParam(":userid", $userid);
			//$userid = $uid;
			$getmaxtc->execute();

			$cenas2 = $getmaxtc->fetchColumn();

			++$cenas2;



			$cenas = $getseq->fetchColumn();

			++$cenas;


			$preparation = "INSERT INTO tipo_registo (userid, typecnt, nome, idseq, ativo) VALUES (".$uid.','.$cenas2.',"'.$nreg.'",'.$cenas.',1)';

			$tiporegisto = $connection->prepare($preparation);
			$tiporegisto->execute();


			//$tiporegisto->bindParam(":userid", $userid);
			//$userid = $uid;
			//$tiporegisto->bindParam(":typecnt", $typecnt);
			//$tiporegisto->bindParam(":nome", $nomeregisto);
			//$tiporegisto->bindParam(":idseq", $idseq);

			//$nomeregisto = $nreg;
			//$userid = $uid;
			$connection->commit();

	} catch (PDOException $e){
			echo("<p>ERROR: {$e->getMessage()}</p>");
		}
	$connection = null;
	?>


	</body>
	</html>
