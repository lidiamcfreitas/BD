<?php
session_start();
$userid = $_SESSION['userid'];
$nomeregisto = $_SESSION["nomeregisto"];
$typecnt = $_SESSION["tipoderegisto"];
require "connect.php";
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
      <h3 class="text-muted">Inserir Campos</h3>
    </div>

    <?php


    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["nomeregisto"] != "") && ($_POST["tipoderegisto"] != "")){

      // get campos para dado tipo
      $sql_campos  = "SELECT campocnt, nome ";
      $sql_campos .= "FROM campo  ";
      $sql_campos .= "WHERE typecnt = ? ";
      $sql_campos .= "  AND ativo = 1;";
      $obj_campos = $connection->prepare($sql_campos);
      $obj_campos->bindParam(array($typecnt));

      $result_campos = $obj_campos->fetchAll(PDO::FETCH_ASSOC);

      foreach($result_campos as $row){
        echo "<td><label for=\"nomeregisto\">".$row["nome"]."</label></td>";
        echo "<td><input type=\"text\" name=\"valorcampo[]\" placeholder=\"Valor\" required></td>";
      }

      }
    $connection = null;
    ?>

  </div> <!-- /container -->
</body>
</html>
