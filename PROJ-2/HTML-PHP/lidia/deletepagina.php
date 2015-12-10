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
            <li role="presentation" class="active"><a href="deletepagina.php"> Apagar Página </a></li>
            <li role="presentation"><a href="deletetiporegisto.php"> Apagar Tipo </a></li>
            <li role="presentation"><a href="deletecampotipo.php"> Apagar Campo de Tipo </a></li>
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Valores de Campos</a></li>
            <li role="presentation"><a href="pagina.php"> Ver Pagina </a></li>
        </ul>
        <h3 class="text-muted">Apagar Pagina</h3>
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

        $sql_pageid  = "SELECT pagecounter ";
        $sql_pageid .= "FROM pagina  ";
        $sql_pageid .= "WHERE userid = :userid ";
        $sql_pageid .= "  AND nome = :pagename";


        $getpageid = $connection->prepare($sql_pageid);
        $getpageid->bindParam(":userid", $uid);
        $getpageid->bindParam(":pagename", $pagename);

        $uid = $userid;
        $pagename = $nomepagina;
        $getpageid->execute();


        $getpagecounter = $getpageid->fetchColumn();


        $sql_delete  = "UPDATE pagina ";
        $sql_delete .= "SET ativa=0  ";
        $sql_delete .= "WHERE pagecounter=:pagecounter and userid = :userid";

        $delete_page = $connection->prepare($sql_delete);
        $delete_page->bindParam(":userid", $uid1);
        $delete_page->bindParam(":pagecounter", $pagec);
        $uid1 = $userid;
        $pagec = $getpagecounter;
        $delete_page->execute();

        }

    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
