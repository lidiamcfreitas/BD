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

			$sqltypeid  = "SELECT typecnt ";
			$sqltypeid .= "FROM tipo_registo  ";
			$sqltypeid .= "WHERE userid = :userid";
			$sqltypeid .= "  AND nome = :nometiporegisto";
			$sqltypeid .= "  AND ativo = 1";

			$getseq = $connection->prepare($sqltypeid);
			$getseq->bindParam(":userid", $uid);
			$getseq>bindParam(":tiporegisto", $tr);
			$getseq->execute();

			$sql_maxtc  = "SELECT r.typecnt + 1 ";
			$sql_maxtc .= "FROM tipo_registo r  ";
			$sql_maxtc .= "WHERE r.userid = :userid";
			$sql_maxtc .= "  AND r.typecnt = ALL  ";
			$sql_maxtc .= "    (SELECT max(r2.typecnt) ";
			$sql_maxtc .= "     FROM tipo_registo r2  ";
			$sql_maxtc .= "     WHERE r2.userid = :userid )";


			$getmaxtc = $connection->prepare($sql_maxtc);
			$getmaxtc->execute();

			$cenas2 = $getmaxtc->fetchColumn();

			$cenas = $getseq->fetchColumn();


			$campocnt  = "SELECT c.campocnt + 1 ";
			$campocnt .= "FROM campo c  ";
			$campocnt .= "WHERE c.userid =".$uid;
			$campocnt .= "  AND c.typecnt = ".$cenas2;
			$campocnt .= "  AND c.ativo = 1 ";
			$campocnt .= "  AND c.campocnt = all ";
			$campocnt .= "    ( SELECT max(c1.campocnt) ";
			$campocnt .= "     FROM campo c1  ";
			$campocnt .= "     WHERE c1.userid = c.userid ";
			$campocnt .= "       AND c1.typecnt = c.typecnt ";
			$campocnt .= "       AND c1.ativo = 1)";

			$campocounter = $connection->prepare($campocnt);
			$campocounter->execute();

			$preparation = "INSERT INTO campo (userid, typecnt, campocnt, nome, idseq, ativo) VALUES (".$uid.','.$cenas2.','.$campocounter.',"'.$ncampo.'",'.$cenas.',1)';

			echo ' '.$preparation;

			$final = $connection->prepare($preparation);
			$final->execute();
echo "3";
} catch (PDOException $e){
			echo("<p>ERROR: {$e->getMessage()}</p>");
		}
	$connection = null;
	?>


	</body>
	</html>






