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
            <li role="presentation"><a href="insertcampo.php"> Inserir Campos </a></li>
            <li role="presentation"><a href="deletepagina.php"> Apagar Página </a></li>
            <li role="presentation"><a href="deletetiporegisto.php"> Apagar Tipo </a></li>
            <li role="presentation"><a href="deletecampotipo.php"> Apagar Campo de Tipo </a></li>
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Valores de Campos</a></li>
            <li role="presentation" class="active"><a href="pagina.php"> Ver Pagina </a></li>
        </ul>
        <h3 class="text-muted">Ver Pagina</h3>
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
                
                <div class="form-group">
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

        $sql  = "SELECT r.regcounter ";
        $sql .= "FROM registo AS r  ";
        $sql .= "WHERE r.ativo = 1 ";
        $sql .= "  AND r.userid = :userid ";
        $sql .= "  AND EXISTS  ";
        $sql .= "    (SELECT rp.pageid,  ";
        $sql .= "            rp.regid ";
        $sql .= "     FROM reg_pag AS rp  ";
        $sql .= "     WHERE r.regcounter = rp.regid ";
        $sql .= "       AND rp.userid = :userid  ";
        $sql .= "       AND rp.ativa = 1 ";
        $sql .= "       AND EXISTS  ";
        $sql .= "         (SELECT p.pagecounter ";
        $sql .= "          FROM pagina AS p  ";
        $sql .= "          WHERE p.pagecounter = rp.pageid ";
        $sql .= "            AND p.userid = :userid ";
        $sql .= "            AND p.nome = :nomepagina ";
        $sql .= "            AND p.ativa = 1))";

        $resultado = $connection->prepare($sql);
		$resultado->bindParam(":nomepagina", $nomepagina);
        $resultado->bindParam(":userid", $userid);
		$resultado->execute();


		$result = $resultado->setFetchMode(PDO::FETCH_ASSOC);
		$result = $resultado->fetchAll();

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

    } else {

    }
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
