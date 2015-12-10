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

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		 $nomepagina = test_input($_POST["nomepagina"]);
		 $userid = test_input($_POST["userid"]);
		}

		$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
		$user="ist172619"; // -> substituir pelo nome de utilizador
		$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
		$dbname = $user; // a BD tem nome identico ao utilizador

		class TableRows extends RecursiveIteratorIterator { 
			
		    function __construct($it) { 
		        parent::__construct($it, self::LEAVES_ONLY); 
		    }

		    function current() {
		        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
		    }

		    function beginChildren() { 
		        echo "<tr>"; 
		    } 

		    function endChildren() { 
		        echo "</tr>" . "\n";
		    } 
		}

		$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		
		$sql  = "SELECT r.regcounter ";
		$sql .= "FROM registo AS r  ";
		$sql .= "WHERE r.ativo = 1 ";
		$sql .= "  AND r.userid = :userid ";
		$sql .= "  AND EXISTS  ";
		$sql .= "    (SELECT rp.pageid,  ";
		$sql .= "            rp.regid ";
		$sql .= "     FROM reg_pag AS rp  ";
		$sql .= "     WHERE r.regcounter = rp.regid ";
		$sql .= "       AND rp.userid = :userid  ";
		$sql .= "       AND rp.ativa = 1 ";
		$sql .= "       AND EXISTS  ";
		$sql .= "         (SELECT p.pagecounter ";
		$sql .= "          FROM pagina AS p  ";
		$sql .= "          WHERE p.pagecounter = rp.pageid ";
		$sql .= "            AND p.userid = :userid ";
		$sql .= "            AND p.nome = :nomepagina ";
		$sql .= "            AND p.ativa = 1))";


/*
		$sql  = "SELECT r.regcounter ";
		$sql .= "FROM registo AS r  ";
		$sql .= "WHERE r.ativo = 1 AND r.userid = :userid";
		$sql .= "  AND EXISTS  ";
		$sql .= "    ( SELECT rp.pageid,  ";
		$sql .= "             rp.regid ";
		$sql .= "     FROM reg_pag AS rp  ";
		$sql .= "     WHERE r.regcounter = rp.regid and rp.userid = :userid";
		$sql .= "       AND ativa = 1 ";
		$sql .= "       AND rp.pageid = :nomepagina ";
		$sql .= "       AND EXISTS  ";
		$sql .= "         ( SELECT p.pagecounter ";
		$sql .= "          FROM pagina AS p  ";
		$sql .= "          WHERE p.pagecounter = rp.pageid and p.userid = :userid";
		$sql .= "            AND p.ativa = 1))";
*/
		$resultado = $connection->prepare($sql);
		$resultado->bindParam(":nomepagina", $nomepagina);
                $resultado->bindParam(":userid", $userid);
		$resultado->execute();

		$result = $resultado->setFetchMode(PDO::FETCH_ASSOC); 
		$result = $resultado->fetchAll();


		echo('<div id="left">');
		echo('<table class="center"> ');
		if (empty($result)) {
			echo "<p>Não existe uma pagina com esse nome";
		} else {
			echo "<table style='border: solid 1px black;'>";
		echo("<tr><th>Registos da Página " . $nomepagina . "</th></tr>\n");
		    foreach(new TableRows(new RecursiveArrayIterator($result)) as $k=>$v) { 
		    	echo  $v;
		    }
		echo "</table>";
		}

	}
catch (PDOException $e)
{
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
$connection = null;

?>


</body>
</html>
