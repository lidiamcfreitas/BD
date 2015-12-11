<?php
session_start();
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
          <li role="presentation"><a href="principal.php"> Página Principal </a></li>
            <li role="presentation"><a href="insertpagina.php"> Inserir Página </a></li>
            <li role="presentation" class="active"><a href="inserttiporegisto.php"> Inserir Tipo de Registo</a></li>
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




        $connection->beginTransaction();
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



        $tp_query = "INSERT INTO tipo_registo (userid, typecnt, nome, idseq, ativo) VALUES (:userid, :typecnt, :nome, :idseq, 1)";

        $print_tp_query = "INSERT INTO tipo_registo (userid, typecnt, nome, idseq, ativo) VALUES ($userid, $gettypecounter, $nometiporegisto, $getseqcounter, 1)";

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
    $connection->commit();
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
