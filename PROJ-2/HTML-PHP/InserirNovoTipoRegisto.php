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

// Carregamento das variáveis username e pin do form HTML através do metodo POST;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$TipoRegistoNovo = test_input($_POST["TipoRegistoNovo"]);
		}
		
$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist172619"; // -> substituir pelo nome de utilizador
$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador

$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, 
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$TOBEDONE=0

//CREATE TABLE IF NOT EXISTS t i p o r e g i s t o (
//u s e r i d INT NOT NULL,
//t y p e c n t INT NOT NULL,
//nome MEDIUMTEXT NOT NULL,
//a ti v o TINYINT ( 1 ) NOT NULL,
//i d s e q INT NULL,
//p typecn t INT


$sql = "INSERT INTO tiporegisto (userid, typecnt, nome, ativa, idseq, ptypecnt) VALUES ($userid, $TOBEDONE, $nometiporegisto, $TOBEDONE, $TOBEDONE, $TOBEDONE)"; 
$result = $connection->query($sql);
if (!$result) {
	echo("<p> Novo Tipo de Registo não criado: Erro na Query</p>");
	exit();
}else{
	echo'<section class="loginform cf">';
	echo("<center><p> Novo tipo de Registo ($TipoRegistoNovo) criada pelo utilizador ($userid) com sucesso</p>");

}


// to be continued….
//termina a sessão
session_destroy();
?>

<form name="regressaindex" action="index.html" method="post" accept-charset="utf-8" >
	<input type="submit" value="Voltar Para Vista Geral"></li>
</form>
</center></section>

</body>
</html>
