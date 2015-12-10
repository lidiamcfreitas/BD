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
            <li role="presentation" class="active"><a href="patient">Ver Pagina</a></li>
            <li role="presentation"><a href="transfer"> Outras Queries </a></li>
        </ul>
        <h3 class="text-muted">Ver Pagina</h3>
      </div>
        <div>
            <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>"> 
                <div class="form-group">
                    <label for="nomepagina">Nome da Página</label>
                    <input type="text" name="nomepagina" placeholder="Nome da Página" required>
                </div>
                <div class="form-group">
                    <label for="userid">Identificação do Utilizador</label>
                    <input type="number" name="userid" placeholder="ex: 11321" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success" value="Show">
                </div>
            </form>
        </div>
    <?php
    echo "<p>diz qualquer coisa</p>";
        
        require "connect.php";
        
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["userid"] != "") && ($_POST["nomepagina"] != "")){
		echo "estou aqui mãe";
        $nomepagina = $_POST["nomepagina"];
		$userid = $_POST["userid"];
		echo "user: ".$userid;
		echo "nomepagina: ".$nomepagina;
        class TableRows extends RecursiveIteratorIterator { 
            
            function __construct($it) { 
                parent::__construct($it, self::LEAVES_ONLY); 
            }

            function current() {
                return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
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

		echo "estou aqui</br>";
        $resultado = $connection->prepare($sql);
        echo "fiz bind pai! </br>";
		$resultado->bindParam(":nomepagina", $nomepagina);
		echo "fiz bind pai! </br>";
        $resultado->bindParam(":userid", $userid);
        echo "fiz bind pai! </br>";
		$resultado->execute();
		echo "fiz bind pai! </br>";
		
		$result = $resultado->setFetchMode(PDO::FETCH_ASSOC); 
		$result = $resultado->fetchAll();

        if (empty($result)) {
            echo "<p>Não existe uma pagina com esse nome</p>";
        } else {
            echo "<table>";
            echo("<tr><th>Registos da Página " . $nomepagina . "</th></tr>\n");
            foreach(new TableRows(new RecursiveArrayIterator($result)) as $k=>$v) { 
                echo  $v;
            }
            echo "</table>";
        }

    } else {
    	echo "please";
    }
    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>