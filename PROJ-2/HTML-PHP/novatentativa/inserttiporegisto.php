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
                    <td><label for="nomepagina">Nome da Página</label></td>
                    <td><input type="text" name="nomepagina" placeholder="Nome da Página" required></td>
                </div><br>
                </tr>
                <tr>
                <div class="form-group">
                    <td><label for="userid">Identificação do Utilizador</label></td>
                    <td><input type="number" name="userid" placeholder="ex: 11321" required></td>
                </div>
                </tr>
                <div class="form-group">
                </table>
                    <br><input type="submit" name="submit" class="btn btn-success" value="Show">
                </div>
            </form>
        </div>
    <?php

        require "connect.php";

    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["userid"] != "") && ($_POST["nomepagina"] != "")){

        $nomepagina = $_POST["nomepagina"];
		$userid = $_POST["userid"];

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

            $uid = null;

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

        $uid = null;

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
        $teste = "select count(*) from utilizador where userid = ".$uid;
        $testarseexiste =$connection->prepare($teste);
        $testarseexiste->execute();
        $deu = $testarseexiste->fetchAll();

        if ($deu == 0) {
          echo "Esse Utilizador não existe";
        }

        $sequencia = $connection->prepare("INSERT INTO sequencia (moment, userid) VALUES (current_timestamp, $uid)");
  			$sequencia->execute();

  			$sql_maxmom  = "SELECT s.contador_sequencia ";
  			$sql_maxmom .= "FROM sequencia s  ";
  			$sql_maxmom .= "WHERE s.userid = ".$uid;
  			$sql_maxmom .= " AND s.moment = all ";
  			$sql_maxmom .= "( SELECT max(s2.moment) ";
  			$sql_maxmom .= "FROM sequencia s2  ";
  			$sql_maxmom .= "WHERE s2.userid = ".$uid.')';


  			$getseq = $connection->prepare($sql_maxmom);

  			//$getseq = $bindParam(":userid", $uid);
  			$getseq->execute();



  			$sql_maxtc  = "SELECT r.typecnt ";
  			$sql_maxtc .= "FROM tipo_registo r  ";
  			$sql_maxtc .= "WHERE r.userid = ".$uid;
  			$sql_maxtc .= "  AND r.typecnt = ALL  ";
  			$sql_maxtc .= "    (SELECT max(r2.typecnt) ";
  			$sql_maxtc .= "     FROM tipo_registo r2  ";
  			$sql_maxtc .= "     WHERE r2.userid = ".$uid.')';


  			$getmaxtc = $connection->prepare($sql_maxtc);
  			//$getmaxtc = $bindParam(":userid", $userid);
  			//$userid = $uid;
  			$getmaxtc->execute();

  			$cenas2 = $getmaxtc->fetchColumn();

  			++$cenas2;



  			$cenas = $getseq->fetchColumn();

  			++$cenas;


  			$preparation = "INSERT INTO tipo_registo (userid, typecnt, nome, idseq, ativo) VALUES (".$uid.','.$cenas2.',"'.$nreg.'",'.$cenas.',1)';
  			echo ' '.$preparation;
  			$tiporegisto = $connection->prepare($preparation);
  			$tiporegisto->execute();

  			echo "Executei sem erros";

    } else {

    }
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
