<!DOCTYPE html>
<html>
<head>
	<title>Bloco de Notas</title>
	<meta charset="utf-16">
	<link rel="stylesheet" href="normalize.css">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="favicon.png">
</head>
<body>
	<div id="wrap">
		<?php 
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

}


$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist169720"; // -> substituir pelo nome de utilizador
$password="gfca6559"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador

$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


$sql = "SELECT * FROM pagina WHERE nome = nomepagina"; 
$result = $connection->query($sql);
//echo("<table border=\"1\">\n");
echo('<div id="left">');
echo('<table class="center"> ');

echo("<tr><th>UserID</th><th>pagecounter</th><th>nome</th><th>IDSeq</th><th>ativa</th><th>ppagecounter</th></tr>\n");
$nome = 0;foreach($result as $row){
	if ( $row["nome"] == 1){
		echo($row["userid"]); echo("</td><td>");
		echo($row["pagecounter"]); echo("</td><td>");
		echo($row["nome"]); echo("</td><td>");
		echo($row["idseq"]); echo("</td><td>");
		echo($row["ativa"]); echo("</td><td>");
		echo($row["ppagecounter"]); echo("</td></tr>");
		$leilao[$idleilao]= array($row["nif"],$row["diahora"],$row["nrleilaonodia"]);
	}
}

?>
</body>
</html>
