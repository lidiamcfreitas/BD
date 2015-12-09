
<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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

// Função para limpar os dados de entrada
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = test_input($_POST["userID"]);
    $nomepagina = test_input($_POST["nomepagina"]);
}
echo($userid);
echo($nomepagina);

$tobedone=0;

$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist172619"; // -> substituir pelo nome de utilizador
$password="oefc3659"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador

$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

echo( "cheguei aqui");

//$resultado = $connection->prepare('INSERT INTO pagina
//VALUES (':userid', ':TOBEDONE', ':nomepagina', ':TOBEDONE', ':TOBEDONE', :TOBEDONE');

//AQUI FALTA SABER COMO RECEBER O NUMERO SEGUINTE IDSEQ


$GETTYPECNT   = 0;
$GETIDSEQ     = 0;
$GETPPAGECOUNT= 0;

//$result =mysql_query("SELECT count(*) FROM utilizador WHERE exists `userid` = '$userid'");

$sql  = "SELECT count(*) ";
$sql .= "FROM utilizador ";
$sql .= "WHERE userid = :userid";
$stmt = $connection->prepare($sql);
$result->bindParam(":userid", $userid);
$result->execute();
echo "ja executei"

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
/*
if ($result  > 0)

    {
        echo 'ENCONTREI O USER !!'; 
    }
else
    {
    echo 'NAO FIND THA USSER !!';
    }
*/
$resultado = $connection->prepare('INSERT INTO pagina (userid,pagecounter,nome,idseq,ativa,ppagecounter) VALUES (:userid, :GETTYPECNT, :nomepagina, :IDSEQ, 1, :GETPPAGECOUNT)');

$resultado->bindParam(":userid", $userid);
$resultado->bindParam(":GETTYPECNT", $GETTYPECNT);
$resultado->bindParam(":nomepagina", $nomepagina);
$resultado->bindParam(":GETIDSEQ", $GETIDSEQ);
$resultado->bindParam(":GETPPAGECOUNT", $GETPPAGECOUNT);
$resultado->execute();





echo ("Acabai a query");
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
if (empty($result)) {
    echo "Não existe uma pagina com esse nome";
     } else{
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
}
?>

</body>
</html>
