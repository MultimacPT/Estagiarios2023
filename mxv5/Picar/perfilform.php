<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Assiduidades</title>
	<link rel="stylesheet" href="themes/aa.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  	<link rel="icon" href="images/logo.ico" type="images/favicon">
	<link rel="shortcut icon" href="images/logo.ico" type="images/favicon">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="javascript/logout.js"></script>
</head>
<body>
	<div data-role="page">
		<div data-role="header" data-theme="a" class="ui-header-fixed">
  			<div style="width: 75px; height: 75px; float: left;">
    				<img src="images/logo-hito-3.png" alt="Hito">
			</div>
  			<a href="#menu-popup" data-rel="popup" data-transition="slide" data-popup="true" data-icon="bars" data-iconpos="notext" class="ui-btn-right ui-btn-inline" style="width: 60px;height: 60px;background-color: black !important;color: white !important;">Menu</a>
  			<div data-role="popup" id="menu-popup" data-theme="a" class="ui-popup-anchor">
    			<ul data-role="listview" data-inset="true" style="min-width:210px;">
					<li><a id="btn-page-picar">Picar</a></li>
					<li><a href="#" id="notificacao">Notificações<span id="contar-not"></span></a></li>
					<li><a href="#" id="btn-page-guias">Guias de transporte</a></li>
					<li><a href="#" class="logout-btn" id="logout">Logout</a></li>
    			</ul>
  			</div>
		</div>

		<?php session_start();?>
	    <div data-role="form" data-theme="a" class="ui-content">
		<form>
			<br>
			<br>
			<br>
			<div data-role="content">
				<ul data-role="listview" data-inset="true">
				  <li data-role="list-divider">Informações de Perfil</li>
				  <li><h2>ID: <?php echo $_SESSION['id']; ?> </h2></li>
				  <li><h2>Nome: <?php echo $_SESSION['name']; ?></h2></li>
				  <li><h2>Email:  <?php echo $_SESSION['email']; ?></h2></li>
				  <li><button type="button" class="logout-btn" id="logout"><h2>Logout</h2><p>Clique aqui para encerrar sessão.</p></button></li>
				</ul>
			</div>
		</form>
			<?php
				
				// verifica se o utilizador está autenticado
				if (!isset($_SESSION["username"])) {
					header("Location: login.php");
					exit();
				}
			?>

			<script src="javascript/enviar_notificacao.js"></script>
			<script src="javascript/btns_mudar_perfil.js"></script>

		</div>
	</div>
</body>
</html>