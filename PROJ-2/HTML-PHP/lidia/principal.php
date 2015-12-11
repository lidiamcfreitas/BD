
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
          <li role="presentation" class="active"><a href="principal.php"> Página Principal </a></li>
            <li role="presentation"><a href="insertpagina.php"> Inserir Página </a></li>
            <li role="presentation"><a href="inserttiporegisto.php"> Inserir Tipo de Registo</a></li>
        </ul>
        <h3 class="text-muted">Página Principal</h3>
      </div>

        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
                <table cellspacing="10">
                <tr>
                  <div class="form-group">
                      <td><label for="nomepagina">Nome da Página</label></td>
                      <td><input type="text" name="nomepagina" placeholder="Nome da Página" required></td>
                      <td><input type="submit" name="submit" class="btn btn-success" value="Ver Página"></td>
                  </div><br>
                </tr>
                  </table>

                </form>
              </div>

              <div class="col-md-6">
                <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
                  <table cellspacing="10">
                  <tr>
                    <div class="form-group">
                        <td><label for="nomeregisto">Nome da Registo</label></td>
                        <td><input type="text" name="nomeregisto" placeholder="Nome da Registo" required></td>
                        <td><input type="submit" name="submit" class="btn btn-success" value="Ver Registo"></td>
                    </div><br>
                  </tr>
                    </table>

                  </form>
              </div>

        </div>
      </div>
    </div>

    <?php

        require "connect.php";

		    $userid = $_SESSION['userid'];

        $query_tabelas = "select nome as Paginas from pagina where userid = ?";
        $resultado_tabelas = $connection->prepare($query_tabelas);
        $resultado_tabelas->execute(array($userid));
        $resultado_print = $resultado_tabelas->fetchAll(PDO::FETCH_ASSOC);

        $query_tipos = "select nome as Registos from tipo_registo where userid = ?";
        $resultado_tabelas = $connection->prepare($query_tipos);
        $resultado_tabelas->execute(array($userid));
        $resultado_print_tipo = $resultado_tabelas->fetchAll(PDO::FETCH_ASSOC);


        ?>
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h1>Tabela de Páginas</h1>
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
            echo "<td><a href=\"insertpagina.php?pagename=$valor_coluna\">$valor_coluna</a></td>";
          }
          echo "</tr>";
        } ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <h1>Tabela de Registos</h1>
      <table class="table table-striped table-hover table-responsive">
        <thead>
          <tr>
            <?php
            foreach($resultado_print_tipo[0] as $nome_coluna => $valor_coluna){
              echo "<td>$nome_coluna</td>";
            }
            ?>
          </tr>
        </thead>
        <tbody>
      <?php
      foreach($resultado_print_tipo as $num=>$row){
        echo "<tr>";
        foreach($row as $nome_coluna => $valor_coluna){
          echo "<td>$valor_coluna</td>";
        }
        echo "</tr>";
      } ?>
      </tbody>
      </table>
    </div>
  </div>
    </div>


<?php
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
