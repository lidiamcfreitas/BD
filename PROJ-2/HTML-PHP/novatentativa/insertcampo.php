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
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Tipo </a></li>
            <li role="presentation" class="active"><a href="insertcampo.php"> Inserir Campos </a></li>
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
                        <td><label for="nomecampo">Nome do Campo</label></td>
                        <td><input type="text" name="nomecampo" placeholder="Nome da Campo" required></td>
                    </div><br>
                </tr>
                <tr>
                    <div class="form-group">
                        <td><label for="nometipo">Nome do Tipo</label></td>
                        <td><input type="text" name="nometipo" placeholder="Nome do Tipo" required></td>
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
        
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["userid"] != "") && ($_POST["nomecampo"] != "") && ($_POST["nometipo"] != "")){

        $nomecampo = $_POST["nomecampo"];
        $nometipo = $_POST["nometipo"];
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

            $sqlmaxmom  = "SELECT s.contador_sequencia ";
            $sqlmaxmom .= "FROM sequencia s  ";
            $sqlmaxmom .= "WHERE s.userid = :userid ";
            $sqlmaxmom .= "  AND s.moment = all ";
            $sqlmaxmom .= "    ( SELECT max(s2.moment) ";
            $sqlmaxmom .= "     FROM sequencia s2  ";
            $sqlmaxmom .= "     WHERE s2.userid = :userid)";

            $get_moment = $connection->prepare($sqlmaxmom);
            $get_moment->bindParam(":userid", $uid_maxmom);
            $uid_maxmom = $userid;
            $get_moment->execute();

            $id_sequenciaa = $get_moment->fetchColumn();


            $sqltypeid1  = "SELECT typecnt ";
            $sqltypeid1 .= "FROM tipo_registo  ";
            $sqltypeid1 .= "WHERE userid = :userid";
            $sqltypeid1 .= "  AND nome = :nometiporegisto";
            $sqltypeid1 .= "  AND ativo = 1";

            $gettype1 = $connection->prepare($sqltypeid1);
            $gettype1->bindParam(":userid", $uid_type1);
            $gettype1->bindParam(":nometiporegisto", $nometr);
            $uid_type1 = $userid;
            $nometr = $nometipo;
            $gettype1->execute();

            $idtipo_type = $gettype1->fetchColumn();


            $sql_campocnt  = "SELECT c.campocnt ";
            $sql_campocnt .= "FROM campo c  ";
            $sql_campocnt .= "WHERE c.userid = :userid  ";
            $sql_campocnt .= "  AND c.campocnt = ALL  ";
            $sql_campocnt .= "    (SELECT max(c1.campocnt) ";
            $sql_campocnt .= "     FROM campo c1  ";
            $sql_campocnt .= "     WHERE c1.userid = c.userid)";

            $getcampo_counter = $connection->prepare($sql_campocnt);
            $getcampo_counter->bindParam(":userid", $uid1_campocounter);
            $uid1_campocounter = $userid;

            $getcampo_counter->execute();

            $campocounter_insertcampo = $getcampo_counter->fetchColumn();


            ++$campocounter_insertcampo;

            $campo_insertquery = "INSERT INTO campo (userid, typecnt, campocnt, nome, idseq, ativo) VALUES (:userid, :tipoid, :campoid ,:nomecampo,:seqid,1)";

             //$print_campo_insertquery = "INSERT INTO campo (userid, typecnt, campocnt, nome, idseq, ativo) VALUES ($userid, $idtipo_type, $campocounter_insertcampo ,\"$nomecampo\",$id_sequenciaa,1)";
             //echo $print_campo_insertquery;

            $insert_campo = $connection->prepare($campo_insertquery);


            $insert_campo->bindParam(":userid", $uid2_ic);
            $insert_campo->bindParam(":tipoid", $tipoid2_ic);
            $insert_campo->bindParam(":campoid", $campoid2_ic);
            $insert_campo->bindParam(":nomecampo", $camponome2_ic);
            $insert_campo->bindParam(":seqid", $seqid2_ic);
            $uid2_ic= $userid;
            $tipoid2_ic = $idtipo_type;
            $campoid2_ic = $campocounter_insertcampo;
            $camponome2_ic = $nomecampo;
            $seqid2_ic = $id_sequenciaa;
            $insert_campo->execute();


    }
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>