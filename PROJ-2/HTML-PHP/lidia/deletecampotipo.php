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
            <li role="presentation" class="active"><a href="deletecampotipo.php"> Apagar Campo de Tipo </a></li>
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Valores de Campos</a></li>
            <li role="presentation"><a href="pagina.php"> Ver Pagina </a></li>

        </ul>
        <h3 class="text-muted">Apagar Tipo</h3>

      </div>
        <div>
            <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
            	<table cellspacing="10">
                <tr>
                <div class="form-group">
                    <td><label for="Tipo">Tipo de Registo</label></td>
                    <td><input type="text" name="tiporegisto" placeholder="Tipo de Registo" required></td>
                </div><br>
                </tr>
            	<tr>
                <div class="form-group">
                    <td><label for="Tipo">Nome do Campo a retirar</label></td>
                    <td><input type="text" name="nomecampoaretirar" placeholder="Nome do Campo a Retirar" required></td>
                </div><br>
                </tr>

                <div class="form-group">
                </table>
                    <br><input type="submit" name="submit" class="btn btn-success" value="Show">
                </div>
            </form>
        </div>
    <?php
        //RETIRARCAMPODETIPOREGISTO
        require "connect.php";

    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["nomecampoaretirar"] != "")&& ($_POST["tiporegisto"] != "")){

        $tiporegisto = $_POST["tiporegisto"];
        $nomecampoaretirar = $_POST["nomecampoaretirar"];
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



        $sql_typecnt  = "SELECT typecnt ";
        $sql_typecnt .= "FROM tipo_registo  ";
        $sql_typecnt .= "WHERE userid = :userid ";
        $sql_typecnt .= "  AND nome = :nome";


        $gettypecnt = $connection->prepare($sql_pageid);
        $gettypecnt->bindParam(":userid", $userid);
        $gettypecnt->bindParam(":nome", $nometiporetirar);

        $uid = $userid;
        $gettypeid->execute();

        $getcnt = $gettypeid->fetchColumn();

        $sql_delete  = "UPDATE campo ";
        $sql_delete .= "SET ativo=0  ";
        $sql_delete .= "WHERE typecnt=:typecnt AND userid = :userid";
        $sql_delete .= "AND nome = :nomecampo ";

        $delete_field = $connection->prepare($sql_delete);
        $delete_field->bindParam(":userid", $uid);
        $delete_field->bindParam(":typecnt", $getcenas2);
        $uid = $userid;
        $delete_field->bindParam(":nomecampo",$nomecampoaremover);
        $nomecampoaremover = $nomecampoaretirar;
        $getcenas2 = $gettipos;
        $delete_field->execute();

    }


    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
