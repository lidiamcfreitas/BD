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
	
$TOBEDONE=0

//$resultado = $connection->prepare('SELECT * FROM pagina WHERE nome = :nomepagina');
$resultado = $connection->prepare('INSERT INTO pagina (userid, pagecounter, nome, idseq, ativa,ppagecounter) VALUES (:userid, :TOBEDONE, :nomepagina, :TOBEDONE, :TOBEDONE, :TOBEDONE'); 
echo ($resultado);

/*
$resultado->bindParam(":userid", $$userid);
$resultado->bindParam(":TOBEDONE", $TOBEDONE);
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->execute();


$resultado = $connection->prepare('SELECT * FROM pagina WHERE nome = :nomepagina');
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->execute();
$result = $resultado->fetchAll();

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


$resultado->bindParam(":userid", $$userid);
$resultado->bindParam(":TOBEDONE", $TOBEDONE);
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->execute();


$resultado = $connection->prepare('SELECT * FROM pagina WHERE nome = :nomepagina');
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->execute();
$result = $resultado->fetchAll();

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


$resultado->bindParam(":userid", $$userid);
$resultado->bindParam(":TOBEDONE", $TOBEDONE);
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->execute();


$resultado = $connection->prepare('SELECT * FROM pagina WHERE nome = :nomepagina');
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->execute();
$result = $resultado->fetchAll();

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
*/
?>

<form name="regressaindex" action="index.html" method="post" accept-charset="utf-8" >
	<input type="submit" value="Voltar Para Vista Geral"></li>
</form>
</center></section>

</body>
</html>
