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
            <li role="presentation" class="active"><a href="criarutilizador.php"> Criar Utilizador</a></li>
            <li role="presentation"><a href="login.php"> Login</a></li>
        </ul>
        <h3 class="text-muted">Criar Utilizador</h3>
      </div>
        <div>

          <form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>">
            <table cellspacing="10">
              <tr>
                <div class="form-group">
                    <td><label for="email">Email</label></td>
                    <td><input type="text" name="email" placeholder="Ndsa@dsamk.com" required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="nome">Nome</label></td>
                    <td><input type="text" name="nome" placeholder="Joaquim" required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="password">Password</label></td>
                    <td><input type="password" name="password" placeholder="******" required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="questao1">Questao1</label></td>
                    <td><input type="text" name="questao1" placeholder="?" required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="resposta1">Resposta1</label></td>
                    <td><input type="text" name="resposta1" placeholder="." required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="questao2">Questao2</label></td>
                    <td><input type="text" name="questao2" placeholder="?" required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="resposta2">Resposta2</label></td>
                    <td><input type="text" name="resposta2" placeholder="." required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="pais">Pais</label></td>
                    <td><input type="text" name="pais" required></td>
                </div><br>
              </tr>
              <tr>
                <div class="form-group">
                    <td><label for="categoria">Categoria</label></td>
                    <td><input type="text" name="categoria" placeholder="" required></td>
                </div><br>
              </tr>
            </table>
                  <br><input type="submit" name="submit" class="btn btn-success" value="Show">
              </div>
          </form>

        </div>
    <?php

    require "connect.php";

    if (($_SERVER["REQUEST_METHOD"] == "POST")  && ($_POST["nome"] != "") && ($_POST["email"] != "") && ($_POST["questao1"] != "") && ($_POST["questao2"] != "") && ($_POST["resposta1"] != "") && ($_POST["resposta2"] != "")){

        session_start();

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $questao1 = $_POST["questao1"];
        $resposta1 = $_POST["resposta1"];
        $questao2 = $_POST["questao2"];
        $resposta2 = $_POST["resposta2"];
        $pais = $_POST["pais"];
        $categoria = $_POST["categoria"];

        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email ;
        $_SESSION['password'] = $password;
        $_SESSION['questao1'] = $questao1;
        $_SESSION['resposta1'] = $resposta1;
        $_SESSION['questao2'] = $questao2;
        $_SESSION['resposta2'] = $resposta2;
        $_SESSION['pais'] = $pais;
        $_SESSION['categoria'] = $categoria;

        $connection->beginTransaction();
        $query_cria = "INSERT INTO utilizador (userid , email , nome , password , questao1, resposta1, questao2, resposta2, pais, categoria) VALUES (:userid, :email, :nome, :password, :questao1, :resposta1, :questao2, :resposta2, :pais, :categoria)";
        $utilizador_obj = $connection->prepare($query_cria);
    		$utilizador_obj->bindParam(":userid", $userid_aux);
        $utilizador_obj->bindParam(":email", $email_aux);
        $utilizador_obj->bindParam(":nome", $nome_aux);
        $utilizador_obj->bindParam(":password", $password_aux);
        $utilizador_obj->bindParam(":questao1", $questao1_aux);
        $utilizador_obj->bindParam(":resposta1", $resposta1_aux);
        $utilizador_obj->bindParam(":questao2", $questao2_aux);
        $utilizador_obj->bindParam(":resposta2", $resposta2_aux);
        $utilizador_obj->bindParam(":pais", $pais_aux);
        $utilizador_obj->bindParam(":categoria", $categoria_aux);

        $nome_aux = $nome;
        $email_aux = $email ;
        $password_aux = $password;
        $questao1_aux = $questao1;
        $resposta1_aux = $resposta1;
        $questao2_aux = $questao2;
        $resposta2_aux = $resposta2;
        $pais_aux = $pais;
        $categoria_aux = $categoria;
    		$utilizador_obj->execute();


        $teste1 = "select userid from utilizador where email = :email ";
        $testarseexiste1 =$connection->prepare($teste1);
        $testarseexiste1->bindParam(":email", $email_teste1);
        $email_teste1 = $email;
        $testarseexiste1->execute();
        $idutilizador3 = $testarseexiste1->fetchColumn();

        $_SESSION['userid'] = $idutilizador3;

        $connection->commit();
        header("Location: principal.php");
        }

    $connection = null;
    ?>

    </div> <!-- /container -->
  </body>
</html>
