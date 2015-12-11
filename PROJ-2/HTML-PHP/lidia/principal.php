<?php
session_start();
include './imprimir_tabelas.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bloco de Notas</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../bootstrap/css/jumbotron-narrow.css" rel="stylesheet">

  </head>
  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right" role="tablist">
            <li role="presentation" class="active"><a href="insertpagina.php"> Inserir Página </a></li>
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Tipo </a></li>
            <li role="presentation"><a href="insertcampo.php"> Inserir Campos </a></li>
            <li role="presentation"><a href="deletepagina.php"> Apagar Página </a></li>
            <li role="presentation"><a href="deletetiporegisto.php"> Apagar Tipo </a></li>
            <li role="presentation"><a href="deletepagina.php"> Apagar Campo de Tipo </a></li>
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Valores de Campos</a></li>
            <li role="presentation"><a href="pagina.php"> Ver Pagina </a></li>
        </ul>
        <h3 class="text-muted">Inserir Pagina</h3>
      </div>
        <div>
            <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
            	<table cellspacing="10">
            	<tr>
                <div class="form-group">
                    <td><label for="nomepagina">Nome da Página</label></td>
                    <td><input type="text" name="nomepagina" placeholder="Nome da Página" required></td>
                </div><br>
              </tr>
                </table>
                    <br><input type="submit" name="submit" class="btn btn-success" value="Show">
                </div>
            </form>
        </div>
    <?php

        require "connect.php";

    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["nomepagina"] != "")){

        $nomepagina = $_POST["nomepagina"];
		    $userid = $_SESSION['userid'];

        // cria sequencia
        $query_cria = "INSERT INTO sequencia (moment, userid) VALUES (current_timestamp, :userid )";
        $sequencia_ip = $connection->prepare($query_cria);
    		$sequencia_ip->bindParam(":userid", $user_ipseq);
        $user_ipseq = $userid;
    		$sequencia_ip->execute();

        $imprimeisto = $connection->query("SELECT * FROM utilizador");
        imprime_tabelas($imprimeisto);

        $sql_maxmom  = "SELECT s.contador_sequencia ";
        $sql_maxmom .= "FROM sequencia s  ";
        $sql_maxmom .= "WHERE s.userid = :userid ";
        $sql_maxmom .= "  AND s.moment = all ";
        $sql_maxmom .= "    ( SELECT max(s2.moment) ";
        $sql_maxmom .= "     FROM sequencia s2  ";
        $sql_maxmom .= "     WHERE s2.userid = :userid)";

        $getmoment = $connection->prepare($sql_maxmom);
        $getmoment->bindParam(":userid", $uid);
        $uid = $userid;
		    $getmoment->execute();

        //$result = $getmoment->setFetchMode(PDO::FETCH_ASSOC);
        //$result = $getmoment->fetchAll();

        //print_result($result);

        $sql_maxpc  = "SELECT p.pagecounter ";
        $sql_maxpc .= "FROM pagina p  ";
        $sql_maxpc .= "WHERE p.userid = :userid ";
        $sql_maxpc .= "  AND p.pagecounter = all ";
        $sql_maxpc .= "    ( SELECT max(p2.pagecounter) ";
        $sql_maxpc .= "     FROM pagina p2  ";
        $sql_maxpc .= "     WHERE p2.userid = :userid)";

        $getmaxpc = $connection->prepare($sql_maxpc);
        $getmaxpc->bindParam(":userid", $uid2);
        $uid2 = $userid;
        $getmaxpc->execute();



        //$result = $getmaxpc->setFetchMode(PDO::FETCH_ASSOC);
        //$result = $getmaxpc->fetchAll();

        //print_result($result);

        $getseq = $getmoment->fetchColumn();
        $getmaxpcount = $getmaxpc->fetchColumn();
        ++$getmaxpcount;

        $pagina = $connection->prepare("INSERT INTO pagina (userid, pagecounter, nome, idseq, ativa, ppagecounter) VALUES (:userid, :pagecounter, :nomepagina, :idseq, 1 , NULL)");
        $pagina->bindParam(":nomepagina", $nomep);
        $pagina->bindParam(":idseq", $pagemoment);
        $pagina->bindParam(":pagecounter", $maxpc);
        $pagina->bindParam(":userid", $uid3);

        $nomep  = $nomepagina;
        $uid3   = $userid;
        $pagemoment = $getseq;
        $maxpc  = $getmaxpcount;
        $pagina->execute();

    } else {

    }
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
