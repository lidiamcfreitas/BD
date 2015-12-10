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
            <li role="presentation" class="active"><a href="deletetiporegisto.php">Apagar Tipo</a></li>
            <li role="presentation"><a href="pagina.php"> Ver Pagina </a></li>
            <li role="presentation"><a href="insertpagina.php"> Inserir Pagina </a></li>
            <li role="presentation"><a href="deletepagina.php"> Apagar Pagina </a></li>
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
                <tr>
                <div class="form-group">
                    <td><label for="userid">Identificação do Utilizador</label></td>
                    <td><input type="number" name="userid" placeholder="ex: 11321" required></td>
                </div>
                </tr>
                <div class="form-group">
                </table>
                    <br><input type="submit" name="submit" class="btn btn-success" value="Show">
                </div>
            </form>
        </div>
    <?php
        
        require "connect.php";
        
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["userid"] != "") && ($_POST["nometiporegisto"] != "")){

        $nometiporegisto = $_POST["nometiporegisto"];
		$userid = $_POST["userid"];

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
        $sql_pageid .= "WHERE userid = ".$uid;
        $sql_pageid .= "  AND nome = ".$pagename;


        $gettypecnt = $connection->prepare($sql_pageid);
        //$gettypecnt->bindParam(":userid", $uid);
       // $gettypecnt->bindParam(":pagename", $nometiporegisto);
        $uid = $userid;
        $gettypecnt->execute();
        $cenas=$gettypecnt->fetchColumn();
        echo $cenas;


       $cenas=45464;
       $uid=1695;

        $sql_delete  = "UPDATE tipo_registo ";
        $sql_delete .= "SET ativo=0  ";
        $sql_delete .= "WHERE typecnt=".$cenas;

        $sql_delete .= "and userid ="+$uid;
  

        $delete_campo = $connection->prepare($sql_delete);
        //$delete_campo->bindParam(":typecnt", $cenas);
        //$delete_campo->bindParam(":userid", $uid);
        //$uid = $userid;
        $delete_campo->execute();
 
        }

    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>