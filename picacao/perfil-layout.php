<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Assiduidades</title>
	<link rel="stylesheet" href="themes/picacao.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<link rel="icon" href="images/favicon.ico" type="images/favicon">
	<link rel="shortcut icon" href="images/favicon.ico" type="images/favicon">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="leaflet/leaflet.css" />
	<script src="leaflet/leaflet.js"></script>
	<script src="javascript/reload.js"></script>
</head>
<body>
	<div data-role="page">
		<div data-role="header" data-theme="b" class="ui-header-fixed">
            <div style="text-align: center; margin: 0 auto;">
                <h1>Perfil</h1>
            </div>
	    </div>
		<?php include('phpsystems/perfil-buscar.php'); ?>
	    <div data-role="form" data-theme="a" class="ui-content">
		<form>
			<br>
			<br>
			<br>
			<div data-role="content">
				<ul data-role="listview" data-inset="true">
				  <li data-role="list-divider">Informações de Perfil</li>
				  <li><h2>ID: <?php echo $id_user ?> </h2></li>
				  <li><h2>Empresa: Multimac</h2></li>
				  <li><h2>Nome: <?php echo $name_user ?></h2></li>
				  <li><h2>Email:  <?php echo $email_user ?></h2></li>
				  <li><button type="button"><h2>Irregularidades</h2><p>Clique aqui para ver as suas irregularidades</p></button></li>
				  <li><button type="button" value="Logout"><h2>Logout</h2><p>Clique aqui para sair</p></button></li>
				</ul>
			</div>
		</form>
	</div>
	    <div data-role="footer" class="ui-footer-fixed">
			<footer>
				<div data-role="navbar">
					<ul>
					  <li><a href="relatorio-layout.php">Relatório</a></li>
					  <li><a href="picagem-layout.php">Picagem</a></li>
					  <li><a href="perfil-layout.php" class="ui-btn-active">Perfil</a></li>
					</ul>
				</div>
			</footer>
	    </div>
	</div>
</body>
</html>