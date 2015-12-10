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
            <li role="presentation" class="active"><a href="insertpagina">Apagar Pagina</a></li>
            <li role="presentation"><a href="pagina"> Ver Pagina </a></li>
            <li role="presentation"><a href="insertpagina"> Inserir Pagina </a></li>
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
        
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["userid"] != "") && ($_POST["nomepagina"] != "")){

        $nomepagina = $_POST["nomepagina"];
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

        $sql_pageid  = "SELECT pagecounter ";
        $sql_pageid .= "FROM pagina  ";
        $sql_pageid .= "WHERE userid = :userid ";
        $sql_pageid .= "  AND nome = :pagename";
        echo "2";

        $getpageid = $connection->prepare($sql_maxpc);
        $getpageid->bindParam(":userid", $uid);
        $getpageid->bindParam(":pagename", $pagename);
        echo "3";
        $uid = $userid;
        $pagename = $nomepagina;
        $getpageid->execute();

        echo "1:".$pagename;
        echo "1:".$uid;

        foreach($getpageid as $row)
        {
        echo("<p>$row</p>");
        }

        $getpagecounter = $getpageid->fetchColumn();
        echo "1:".$getpagecounter;


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