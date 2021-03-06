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
          <li role="presentation"><a href="insertvaloresregisto.php"> Inserir Registo</a></li>
          <li role="presentation"><a href="deletecampotipo.php"> Apagar Campo de Tipo </a></li>
          <li role="presentation" class="active"><a href="pagina.php"> Ver Pagina </a></li>

        </ul>
        <h3 class="text-muted">Apagar Tipo</h3>

      </div>
        <div>
            <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
            	<table cellspacing="10">
            	<tr>
                <div class="form-group">
                    <td><label for="Tipo">Nome do Tipo</label></td>
                    <td><input type="text" name="nometiporegisto" placeholder="Nome da Página" required></td>
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



        $sql_pageid  = "SELECT typecnt ";
        $sql_pageid .= "FROM tipo_registo  ";
        $sql_pageid .= "WHERE userid = :userid ";
        $sql_pageid .= "  AND nome = :nome";


        $getpageid = $connection->prepare($sql_pageid);
        $getpageid->bindParam(":userid", $userid);
        $getpageid->bindParam(":nome", $nometiporegisto);

        $uid = $userid;
        $getpageid->execute();

        $gettipos = $getpageid->fetchColumn();

        $teste = "select count(*) from utilizador where userid = :userid";
        $testarseexiste =$connection->prepare($teste);
        $testarseexiste->bindParam(":userid", $userid_teste);
        $userid_teste = $userid;
        $testarseexiste->execute();
        $deu = $testarseexiste->fetchColumn();

        if ($deu == 0) {
          echo "<h1>O Utilizador não existe </h1>";
          exit();
        }


        $sql_delete  = "UPDATE tipo_registo ";
        $sql_delete .= "SET ativo=0  ";
        $sql_delete .= "WHERE typecnt=:typecnt and userid = :userid";

        $delete_page = $connection->prepare($sql_delete);
        $delete_page->bindParam(":userid", $uid);
        $delete_page->bindParam(":typecnt", $getcenas);
        $uid = $userid;

        $getcenas = $gettipos;
        $delete_page->execute();

    }


    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
