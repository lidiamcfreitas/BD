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

}

$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist172619"; // -> substituir pelo nome de utilizador
$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador

$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$resultado = $connection->prepare('SELECT * FROM pagina WHERE nome = :nomepagina');
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->execute();
$result = $resultado->fetchAll();


//$sql = $connection->prepare('SELECT * FROM pagina WHERE nome = nomepagina');
//$sql->bindParam("nomepagina", $username);
//$sql->execute();
//$result = $sql->fetchAll();
//$result = $sql->query($sql);
//echo("<table border=\"1\">\n");

echo('<div id="left">');
echo('<table class="center"> ');

echo("<tr><th>UserID</th><th>pagecounter</th><th>nome</th><th>IDSeq</th><th>ativa</th><th>ppagecounter</th></tr>\n");

foreach($result as $row){
                echo("<tr><th>");
		echo($row["userid"]);
                echo("</th><th>");
		echo($row["pagecounter"]);
                echo("</th><th>");
		echo($row["nome"]);
                echo("</th><th>");
		echo($row["idseq"]);
                echo("</th><th>");
		echo($row["ativa"]);
                echo("</th><th>");
		echo($row["ppagecounter"]);
                echo("</th><tr>");

                echo "<br/>";


}
catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
}
?>
</body>
</html>
