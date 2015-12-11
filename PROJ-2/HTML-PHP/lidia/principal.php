
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
              </table>
                </div>
            </form>
        </div>

    <?php

        require "connect.php";

		    $userid = $_SESSION['userid'];

        $query_tabelas = "select * from pagina where userid = ?";
        $resultado_tabelas = $connection->prepare($query_tabelas);
        $resultado_tabelas->execute(array($userid));
        $resultado_print = $resultado_tabelas->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <table class="table table-striped table-hover table-responsive">
          <thead>
            <tr>
              <?php
              foreach($resultado_print[0] as $nome_coluna => $valor_coluna){
                echo "<td>$nome_coluna</td>";
              }
              ?>
            </tr>
          </thead>
          <tbody>
        <?php
        foreach($resultado_print as $num=>$row){
          echo "<tr>";
          foreach($row as $nome_coluna => $valor_coluna){
            echo "<td>$valor_coluna</td>";
          }
          echo "</tr>";
        }



    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
