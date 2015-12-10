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
			 	$ncampo = test_input($_POST["nomecampo"]);
			 	$ntiporeg = test_input($_POST["ntiporeg"]);
			}

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
			$getmaxtc->execute();

			$cenas2 = $getmaxtc->fetchColumn();

			++$cenas2;

			$cenas = $getseq->fetchColumn();

			++$cenas;

			$campocnt  = "SELECT c.campocnt + 1 ";
			$campocnt .= "FROM campo c  ";
			$campocnt .= "WHERE c.userid = 103 ";
			$campocnt .= "  AND c.typecnt = 13877 ";
			$campocnt .= "  AND c.ativo = 1 ";
			$campocnt .= "  AND c.campocnt = all ";
			$campocnt .= "    ( SELECT max(c1.campocnt) ";
			$campocnt .= "     FROM campo c1  ";
			$campocnt .= "     WHERE c1.userid = c.userid ";
			$campocnt .= "       AND c1.typecnt = c.typecnt ";
			$campocnt .= "       AND c1.ativo = 1)";

			$campocounter = $connection->prepare($campocnt);
			$campocounter->execute();

			$preparation = "INSERT INTO campo (userid, typecnt, campocnt, nome, idseq, ativo) VALUES (".$uid.','.$cenas2.','.$campocounter.',"'.$nomecampo.'",'.$cenas.',1)';
			echo ' '.$preparation;
			$final = $connection->prepare($preparation);
			$final->execute();

} catch (PDOException $e){
			echo("<p>ERROR: {$e->getMessage()}</p>");
		}
	$connection = null;
	?>


	</body>
	</html>





