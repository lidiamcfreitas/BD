<?php
echo "estou aqui";
function imprime_tabelas($query_obj){
  //$resultado = $connection->query("SELECT * FROM utilizador")->fetchAll(PDO::FETCH_ASSOC);
  $resultado = $query_obj->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <table class=\"table table-striped table-hover table-responsive\">
    <thead>
      <tr>
        <?php
        foreach($resultado[0] as $nome_coluna => $valor_coluna){
          echo "<td>$nome_coluna</td>";
        }
        ?>
      </tr>
    </thead>
    <tbody>
  <?php
  foreach($resultado as $num=>$row){
    echo "<tr>";
    foreach($row as $nome_coluna => $valor_coluna){
      echo "<td>$valor_coluna</td>";
    }
    echo "</tr>";
  }
}
?>
