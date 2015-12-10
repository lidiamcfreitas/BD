<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"> 

		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<link href="../jumbotron-narrow.css" rel="stylesheet">

	    <title>Bloco de Notas</title>
	    <meta charset="utf-8">
	    <!-- <link rel="stylesheet" href="normalize.css"> -->
	    <link rel="stylesheet" href="bd.css">
	    <link rel="icon" href="favicon.png">
	</head>

	<body>

<div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right" role="tablist">
			<li role="presentation" class="active"><a href="patient">Patient</a></li>
			<li role="presentation"><a href="transfer">Transfer Devices</a></li>
        </ul>
        <h3 class="text-muted">Patient</h3>
      </div>
	    <div>
			<form method="post" class="form-inline" action="<?php echo $_SERVER["PHP_SELF"];?>"> 
				<div class="form-group">
					<label for="firstname">Name of patient</label>
					<input type="text" class="form-control" id="patient" name="patient" required="required" title="the name of the patient" placeholder="Name of patient">
				</div>
				<div class="form-group">
					<input type="submit" name="submit" class="btn btn-success" value="Show">
				</div>
			</form>
	    </div>

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

		<center><h2>Inserir novo tipo de registo</h2></center>
	    <form name="inserir_novo_tipo_registo" action="InserirNovoTipoRegisto.php" method="post" accept-charset="utf-8">
	    	    <li>
	            	<center><label for="userid">Identificação do Utilizador</label></center>
	            	<center><input type="number" name="userid" placeholder="ex: 11321" required></center>
	        	</li>
	            <li>
	            	<center><label for="nometiporegisto">Nome do Tipo de Registo</label></center>
	            	<center><input type="text" name="nometiporegisto" placeholder="Nome Tipo" required></center>
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