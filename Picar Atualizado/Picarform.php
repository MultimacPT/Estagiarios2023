<!DOCTYPE html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Entradas e saidas</title>
	<link rel="stylesheet" href="themes/Hitto.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="leaflet/leaflet.css" />
	<script src="mainPicar.js"></script>
	<script src="leaflet/leaflet.js"></script>
</head>
<body>
	<div data-role="page" data-theme="a">
		<div data-role="header">
			<img src="logo_hitto.png"> 
		</div>
		<div data-role="content" data-theme="a">
		<div id="loader"><img src="themes/images/ajax-loader.gif"></div>

            <form action="Picar.php" id="myForm" method="post">
				<input type="hidden" name="localizacao" id="localizacao">
                <input type="submit" value="validar entrada">
            </form>

			<button id="btn-locate" style="display: none;">Localizar minha posição</button>
			<div id="map"></div>

			<div id="lista"></div>

			<form action="Logout.php" id="logout" method="post">
                <input type="submit" value="Logout">
            </form>

			<div data-role="footer" data-theme="a"> 
			<h4>Multimac</h4> 
			</div>
		</div>
	</div>
	<?php
	session_start(); // inicia a sessão

	// verifica se o utilizador está autenticado
	if (!isset($_SESSION["username"])) {
	header("Location: Login.php");
	exit();
	}
	?>

	<script src="mainLogout.js"></script>
	<script src="mainMapa.js"></script>
    <script src="main.js"></script>
</body>
</html>
