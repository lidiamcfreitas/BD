<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	    <title>Bloco de Notas</title>
	    <meta charset="utf-8">
	    <!-- <link rel="stylesheet" href="normalize.css"> -->
	    <link rel="stylesheet" href="bd.css">
	    <link rel="icon" href="favicon.png">
	</head>

	<body>
		<center><h2>Inserir nova página</h2></center>
	    <form name="inserir_nova_pagina" action="InserirNovaPagina.php" method="post" accept-charset="utf-8">
	            <li>
	            	<center><label for="nomepagina">Nome da Página</label></center>
	            	<center><input type="text" name="nomepagina" placeholder="ex: 12321" required></center>
	        	</li>
	        	<li>
	            	<center><label for="userid">Identificação do Utilizador</label></center>
	            	<center><input type="number" name="userid" placeholder="ex: 11321" required></center>
	        	</li>
	        <center><input type="submit" value="Aceder"></center>
	    </form>


	    <center><h2>Ver uma página com os registos nela contido</h2></center>
	    <form name="ver_pagina_com_registos" action="VerPaginaRegistos.php" method="post" accept-charset="utf-8">
	    		<li>
	            	<center><label for="userid">Identificação do Utilizador</label></center>
	            	<center><input type="number" name="userid" placeholder="ex: 11321" required></center>
	        	</li>
	            <li>
	            <center><label for="nomepagina">Nome da Página</label></center>
	            <center><input type="text" name="nomepagina" placeholder="Nome da Página" required></center>
	        	</li>
	        <center><input type="submit" value="Aceder"></center>
	    </form>


	</body>
</html>