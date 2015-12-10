<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"> 
    <title>Patient's readings and settings</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../bootstrap/css/jumbotron-narrow.css" rel="stylesheet">
    
  </head>
  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right" role="tablist">
            <li role="presentation"><a href="deletetiporegisto.php">Apagar Tipo</a></li>
            <li role="presentation"><a href="pagina.php"> Ver Pagina </a></li>
            <li role="presentation class="active""><a href="insertpagina.php"> Inserir Pagina </a></li>
            <li role="presentation"><a href="deletepagina.php"> Apagar Pagina </a></li>
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

        echo $nomecampo."<br>";
        echo $nometipo."<br>";
        echo $userid."<br>";

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
            echo "1";
            $sql_maxmom  = "SELECT s.contador_sequencia + 1";
            $sql_maxmom .= "FROM sequencia s  ";
            $sql_maxmom .= "WHERE s.userid = :userid ";
            $sql_maxmom .= "  AND s.moment = all ";
            $sql_maxmom .= "    ( SELECT max(s2.moment) ";
            $sql_maxmom .= "     FROM sequencia s2  ";
            $sql_maxmom .= "     WHERE s2.userid = :userid)";

            $getmoment2 = $connection->prepare($sql_maxmom);
            echo "2";
            $getmoment2->bindParam(":userid", $u_id);
            echo "3";
            $u_id = $userid;
            $getmoment2->execute();
            echo "4<br>";
            $getseq = $getmoment2->fetchColumn();
            echo $getseq;

            $sqltypeid  = "SELECT typecnt ";
            $sqltypeid .= "FROM tipo_registo  ";
            $sqltypeid .= "WHERE userid = :userid";
            $sqltypeid .= "  AND nome = :nometiporegisto";
            $sqltypeid .= "  AND ativo = 1";

            $gettype = $connection->prepare($sqltypeid);
            $gettype->bindParam(":userid", $uid);
            $gettype>bindParam(":nometiporegisto", $nometr);
            $uid = $userid;
            $nometr = $nometipo;
            $gettype->execute();

            $idtipo = $gettype->fetchColumn();
            echo "id do tipo: ".$idtipo;


            $campocnt  = "SELECT c.campocnt + 1 ";
            $campocnt .= "FROM campo c  ";
            $campocnt .= "WHERE c.userid = :userid";
            $campocnt .= "  AND c.typecnt = :tipoid";
            $campocnt .= "  AND c.ativo = 1 ";
            $campocnt .= "  AND c.campocnt = all ";
            $campocnt .= "    ( SELECT max(c1.campocnt) ";
            $campocnt .= "     FROM campo c1  ";
            $campocnt .= "     WHERE c1.userid = c.userid ";
            $campocnt .= "       AND c1.typecnt = c.typecnt ";
            $campocnt .= "       AND c1.ativo = 1)";

            $getcampocounter = $connection->prepare($campocnt);
            $getcampocounter->bindParam(":userid", $uid1);
            $getcampocounter>bindParam(":tipoid", $tipoid1);
            $uid1 = $userid;
            $tipoid1 = $idtipo;
            $getcampocounter->execute();

            $campocounter = $getcampocounter->fetchColumn();
            echo "counter campo: ".$campocounter;


            $pagina = $connection->prepare("INSERT INTO pagina (userid, pagecounter, nome, idseq, ativa, ppagecounter) VALUES (:userid, :pagecounter, :nomepagina, :idseq, 1 , NULL)");

            $campo = "INSERT INTO campo (userid, typecnt, campocnt, nome, idseq, ativo) VALUES (:userid, :tipoid, :campoid ,:nomecampo,:seqid,1)";
            $insert = $connection->prepare($campocnt);
            $insert->bindParam(":userid", $uid2);
            $insert>bindParam(":tipoid", $tipoid2);
            $insert>bindParam(":campoid", $campoid2);
            $insert>bindParam(":nomecampo", $camponome2);
            $insert>bindParam(":seqid", $seqid2);
            $uid2 = $userid;
            $tipoid2 = $idtipo;
            $campoid2 = $campocounter;
            $camponome2 = $nomecampo;
            $seqid2 = $getseq;
            $insert->execute();
            echo "ola";

    }
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>