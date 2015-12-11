<?php
session_start();
$userid = $_SESSION['userid'];
require "connect.php";
$lol = 1;
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
        <li role="presentation"><a href="insertpagina.php"> Inserir Página </a></li>
        <li role="presentation"><a href="inserttiporegisto.php"> Inserir Tipo </a></li>
        <li role="presentation"><a href="insertcampo.php"> Inserir Campos </a></li>
        <li role="presentation"><a href="deletepagina.php"> Apagar Página </a></li>
        <li role="presentation" class="active"><a href="deletetiporegisto.php"> Apagar Tipo </a></li>
        <li role="presentation"><a href="deletecampotipo.php"> Apagar Campo de Tipo </a></li>
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
              <td><label for="nomeregisto">Nome do Registo</label></td>
              <td><input type="text" name="nomeregisto" placeholder="Nome do Registo" required></td>
              <?php
              echo $userid; ?>
            </div><br>
            <div class="form-group">
              <td><label for="tipoderegisto">Tipo de Registo</label></td>
              <td>
                <select name="tipoderegisto">
                  <?php
                  $sqltypeid1  = "SELECT nome, typecnt ";
                  $sqltypeid1 .= "FROM tipo_registo  ";
                  $sqltypeid1 .= "WHERE userid = ? ";
                  $sqltypeid1 .= "  AND ativo = 1";
                  $gettype1 = $connection->prepare($sqltypeid1);
                  $gettype1->execute(array($userid));

                  $result_tipos = $gettype1->fetchAll(PDO::FETCH_ASSOC);

                  echo "<option value=-1>Vazio</option>";
                  foreach($result_tipos as $row){
                    echo "<option value=\"".$row["typecnt"]."\">".$row["nome"]."</option>";
                  }
                  echo "</select>";

                  ?>
                </td>
                <td><input type="submit" name="submit" class="btn btn-success" value="Show"></td>
              </div><br>
            </tr>
          </table>
        </form>
      </div>

      <?php

      require "connect.php";


      if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["tipoderegisto"] != "") && ($lol == 1) ){
        $_SESSION["tipoderegisto"] = $_POST["tipoderegisto"];
        $_SESSION["nomeregisto"] = $_POST["nomeregisto"];


        $sql_maxtc_  = "SELECT r.regcounter + 1 as soma ";
        $sql_maxtc_ .= "FROM registo r  ";
        $sql_maxtc_ .= "WHERE r.userid = ?";
        $sql_maxtc_ .= "  AND r.regcounter = ALL  ";
        $sql_maxtc_ .= "    (SELECT max(r2.regcounter) ";
        $sql_maxtc_ .= "     FROM registo r2  ";
        $sql_maxtc_ .= "     WHERE r2.userid = ? )";

        $sql_maxtc_smt = $connection->prepare($sql_maxtc_);

        $sql_maxtc_smt->execute(array($userid, $userid));
        var_dump($sql_maxtc_smt);

        $sql_maxtc_result = $sql_maxtc_smt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($sql_maxtc_result);
        foreach($sql_maxtc_result as $row){
          $reg_counter_result = $row["soma"];
        }

        $tipoderegisto1 = $_SESSION["tipoderegisto"];
        $nomeregisto1 = $_SESSION["nomeregisto"];
        $lol = 0;
        echo "BADUM";
        $sql_cria_registo = "insert into registo (userid, regcounter, typecounter) values(?,?,?)";
        $sql_cria_qualquercoisa = $connection->prepare($sql_cria_registo);
        $sql_cria_qualquercoisa->execute(array($userid, $sql_counter_result, $tipoderegisto1));
        echo "TSSS";
        $sql_campos  = "SELECT campocnt, nome ";
        $sql_campos .= "FROM campo  ";
        $sql_campos .= "WHERE typecnt = ? and userid = ?";
        $sql_campos .= "  AND ativo = 1;";
        $obj_campos = $connection->prepare($sql_campos);
        $obj_campos->execute(array($tipoderegisto1, $userid));
        echo "QUASE A IR";

        $result_campos = $obj_campos->fetchAll(PDO::FETCH_ASSOC);
        echo " logo antes do var dumpesssssss";
        var_dump($result_campos);
        $_SESSION["result_campos"] = $result_campos;

        ?>
        <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
          <tr>
            <div class="form-group"> <?php
            echo "<input type=\"hidden\" name=\"foo\" value=\"foo\">";

            foreach($result_campos as $row){
              echo "<td><label for=\"nomeregisto\">".$row["nome"]."</label></td>";
              echo "<td><input type=\"text\" name=\"valorcampo[]\" placeholder=\"Valor\" required></td>";
            }

            ?>
            <td><input type="submit" name="submit" class="btn btn-success" value="Show"></td>
          </div>
        </tr>
      </form> <?php




      //header("Location: insertvalorescampo.php");
    } else if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["foo"] != "")) {

      $valoresdoscampos[] = $_POST["valorcampo"];

      $result_campos = $_SESSION["result_campos"];
      $cols = count($valoresdoscampos[0]);
      for ($x = 0; $x <= $cols; $x++) {
          echo $result_campos[$x]["nome"];
          echo $valoresdoscampos[0][$x]."<br>";


      }
    }
    $connection = null;
    ?>

  </div> <!-- /container -->
</body>
</html>
