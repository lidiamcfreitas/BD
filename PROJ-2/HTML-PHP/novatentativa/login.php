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
        <div>
            <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
            	<table cellspacing="10">
            	<tr>
                <div class="form-group">
                    <td><label for="email">Email de Utilizador</label></td>
                    <td><input type="text" name="email" placeholder="Email de Utilizador" required></td>
                </div><br>
                </tr>
                <tr>
                <div class="form-group">
                    <td><label for="userid">Palavra Passe</label></td>
                    <td><input type="password" name="password" placeholder="" required></td>
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

    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["email"] != "") && ($_POST["password"] != "")){

        $email = $_POST["email"];
        $password = $_POST["password"];


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

        $teste = "select count(1) as deu from utilizador where email = :email AND password = :password";
        $testarseexiste =$connection->prepare($teste);
        $testarseexiste->bindParam(":email", $email_teste);
        $email_teste = $email;
        $testarseexiste->bindParam(":password", $password_teste);
        $password_teste = $password;
        $testarseexiste->execute();

        while ($row = $testarseexiste->fetch(PDO::FETCH_ASSOC))
        {
          $deu= $row['deu'];
        }

        $teste = "select  userid from utilizador where email = :email";
        $testarseid =$connection->prepare($teste);
        $testarseid->bindParam(":email", $email_);
        $email_ = $email;
        $testarseid->execute();


        while ($row = $testarseid->fetch(PDO::FETCH_ASSOC))
        {
          $userid= $row['userid'];
        }


    /*    while($row = $testarseexiste->fetch(PDO::FETCH_ASSOC)){
            $deu= $row['deu'];
            $userid_1= $row['userid'];
            $email_1= $row['email'];
}*/
        echo "deu:".$deu;
        echo "userid:".$userid_1;


        if ($deu == 0) {
          echo "<h1>Username ou Palavra passe errada </h1>";

          $teste = "select userid from utilizador where email = :email ";
          $testarseexiste =$connection->prepare($teste);
          $testarseexiste->bindParam(":email", $email_teste);
          $email_teste = $email;
          $testarseexiste->execute();
          $idutilizador = $testarseexiste->fetchColumn();

          $query_cria = "INSERT INTO login (userid, sucesso) VALUES (:userid, 0);";
          $sequencia_itr = $connection->prepare($query_cria);
          $sequencia_itr->bindParam(":userid", $user_ipseq_tr);
          $user_ipseq_tr = $idutilizador;
          $sequencia_itr->execute();
          exit();
        }else{
          echo "<h1>Login efectuado com sucesso ! </h1>";

          $teste = "select count(1) userid from utilizador where email = :email ";
          $testarseexiste =$connection->prepare($teste);
          $testarseexiste->bindParam(":email", $email_teste);
          $email_teste = $email;
          $testarseexiste->execute();
          $idutilizador2 = $testarseexiste->fetchColumn();

          $query_cria = "INSERT INTO login (userid, sucesso) VALUES (:userid, 1);";

          $sequencia_itr = $connection->prepare($query_cria);
            $sequencia_itr->bindParam(":userid", $user_ipseq_tr);
            $user_ipseq_tr = $idutilizador2;
            $sequencia_itr->execute();

        }
      }

        $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
