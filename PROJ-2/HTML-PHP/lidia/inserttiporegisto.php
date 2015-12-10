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
            <li role="presentation"><a href="insertpagina.php"> Inserir Página </a></li>
            <li role="presentation" class="active"><a href="inserttiporegisto.php"> Inserir Tipo </a></li>
            <li role="presentation"><a href="insertcampo.php"> Inserir Campos </a></li>
            <li role="presentation"><a href="deletepagina.php"> Apagar Página </a></li>
            <li role="presentation"><a href="deletetiporegisto.php"> Apagar Tipo </a></li>
            <li role="presentation"><a href="deletepagina.php"> Apagar Campo de Tipo </a></li>
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Valores de Campos</a></li>
            <li role="presentation"><a href="pagina.php"> Ver Pagina </a></li>
        </ul>
        <h3 class="text-muted">Inserir Tipo de Registo</h3>
      </div>
        <div>
            <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
            	<table cellspacing="10">
            	<tr>
                <div class="form-group">
                    <td><label for="nometiporegisto">Nome do Tipo</label></td>
                    <td><input type="text" name="nometiporegisto" placeholder="Nome do Tipo" required></td>
                </div><br>
                </tr>
                
                <div class="form-group">
                </table>
                    <br><input type="submit" name="submit" class="btn btn-success" value="Show">
                </div>
            </form>
        </div>
    <?php

        require "connect.php";

    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["nometiporegisto"] != "")){

        $nometiporegisto = $_POST["nometiporegisto"];
		    $userid = $_SESSION['userid'];

        class TableRows extends RecursiveIteratorIterator {

            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }

            function current() {
                return "<td >" . parent::current(). "</td>";
            }

            function beginChildren() {
                echo "<tr>";
            }

            function endChildren() {
                echo "</tr>" . "\n";
            }
        }

        function print_result($result){


            if (empty($result)) {
                echo "<p>Não existe uma pagina com esse nome</p>";
            } else {
                echo "<div style='width=100px;'><br><br>";
                echo "<table class=\"table table-striped\">";
                echo("<tr><th>Registos da Página " . $nomepagina . "</th></tr>\n");
                foreach(new TableRows(new RecursiveArrayIterator($result)) as $k=>$v) {
                    echo  $v;
                }
                echo "</table>";
                echo "</div>";
            }
        }

        $teste = "select count(*) from utilizador where userid = :userid";
        $testarseexiste =$connection->prepare($teste);
        $testarseexiste->bindParam(":userid", $userid_teste);
        $userid_teste = $userid;
        $testarseexiste->execute();
        $deu = $testarseexiste->fetchColumn();

        if ($deu == 0) {
          echo "Esse Utilizador não existe";
          exit();
        }
        echo "<h1>Utilizador existe</h1>";

        // cria sequencia
        $query_cria = "INSERT INTO sequencia (moment, userid) VALUES (current_timestamp, :userid )";
        $sequencia_itr = $connection->prepare($query_cria);
    		$sequencia_itr->bindParam(":userid", $user_ipseq_tr);
        $user_ipseq_tr = $userid;
    		$sequencia_itr->execute();

        $sql_maxmom_itr  = "SELECT s.contador_sequencia ";
        $sql_maxmom_itr .= "FROM sequencia s  ";
        $sql_maxmom_itr .= "WHERE s.userid = :userid ";
        $sql_maxmom_itr .= "  AND s.moment = all ";
        $sql_maxmom_itr .= "    ( SELECT max(s2.moment) ";
        $sql_maxmom_itr .= "     FROM sequencia s2  ";
        $sql_maxmom_itr .= "     WHERE s2.userid = :userid)";

        $getmoment = $connection->prepare($sql_maxmom_itr);
        $getmoment->bindParam(":userid", $uid_itr);
        $uid_itr = $userid;
		    $getmoment->execute();
        $getseqcounter = $getmoment->fetchColumn();

/*
        echo "vai buscar typecounter seguinte";
        $sql_maxtr  = "SELECT r.typecnt";
  			$sql_maxtr .= "FROM tipo_registo r  ";
  			$sql_maxtr .= "WHERE r.userid = :userid ";
  			$sql_maxtr .= "  AND r.typecnt = ALL  ";
  			$sql_maxtr .= "    (SELECT max(r2.typecnt) ";
  			$sql_maxtr .= "     FROM tipo_registo r2  ";
  			$sql_maxtr .= "     WHERE r2.userid = :userid )";

        $typecounterobj = $connection->prepare($sql_maxtr);
        $typecounterobj->bindParam(":userid", $useridobj);
        $useridobj = $userid;
        $typecounterobj->execute();
        $gettypecounter = $typecounterobj->fetchColumn();

        echo $gettypecounter; */


        $sql_maxtc  = "SELECT r.typecnt + 1 ";
        $sql_maxtc .= "FROM tipo_registo r  ";
        $sql_maxtc .= "WHERE r.userid = ".$userid;
        $sql_maxtc .= "  AND r.typecnt = ALL  ";
        $sql_maxtc .= "    (SELECT max(r2.typecnt) ";
        $sql_maxtc .= "     FROM tipo_registo r2  ";
        $sql_maxtc .= "     WHERE r2.userid = ".$userid.')';

        $getmaxtc = $connection->prepare($sql_maxtc);
        //$getmaxtc = $bindParam(":userid", $userid);
        //$userid = $uid;
        $getmaxtc->execute();

        $gettypecounter = $getmaxtc->fetchColumn();

        echo $gettypecounter;
        echo $getseqcounter;

        $tp_query = "INSERT INTO tipo_registo (userid, typecnt, nome, idseq, ativo) VALUES (:userid, :typecnt, :nome, :idseq, 1)";

$print_tp_query = "INSERT INTO tipo_registo (userid, typecnt, nome, idseq, ativo) VALUES ($userid, $gettypecounter, $nometiporegisto, $getseqcounter, 1)";
  echo $print_tp_query;
        $tiporegisto_tp = $connection->prepare($tp_query);
        $tiporegisto_tp->bindParam(":userid", $uid_tp);
        $tiporegisto_tp->bindParam(":typecnt", $typecnt_tp);
        $tiporegisto_tp->bindParam(":nome", $nome_tp);
        $tiporegisto_tp->bindParam(":idseq", $idseq_tp);
        $uid_tp = $userid;
        $typecnt_tp = $gettypecounter;
        $nome_tp = $nometiporegisto;
        $idseq_tp = $getseqcounter;
        $tiporegisto_tp->execute();

    } else {

    }
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
