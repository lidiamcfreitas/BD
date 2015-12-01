<!DOCTYPE html>
<html>
<head>
	<title>Sistema de leilões de Recursos Marítimos</title>
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
 $userid = test_input($_POST["userid"]);
 $nomepagina = test_input($_POST["nomepagina"]);
}
 
$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist172619"; // -> substituir pelo nome de utilizador
$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador

$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, 
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

