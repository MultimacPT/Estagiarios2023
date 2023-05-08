<!DOCTYPE html>
<html lang="pt-pt">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Entradas e saidas</title>
	<link rel="stylesheet" href="themes/aa.min.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<link rel="icon" href="images/favicon.ico" type="images/favicon">
	<link rel="shortcut icon" href="images/favicon.ico" type="images/favicon">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="leaflet/leaflet.css" />
	<script src="leaflet/leaflet.js"></script>
	<script src="javascript/picar.js"></script>
</head>

<body>
	<div data-role="page" data-theme="a">
		<div data-role="header" class="ui-header-fixed">
			<div style="text-align: center; margin: 0 auto;">
				<img src="images/logo-hito-3.png" alt="Hito">
			</div>
		</div>

		<div data-role="form" data-theme="a" style="padding-bottom: 50px;">

			<div id="loader"><img src="themes/images/ajax-loader.gif"></div>

			<button id="btn-locate" style="display: none;">Localizar minha posição</button>

			<div id="map">
				<form method="post" id="myForm" action="phpsystems/picar.php">
					<input type="hidden" name="localizacao" id="localizacao">
					<div style="display: flex; justify-content: center; align-items: center; height: 365px;">
						<button href="#" id="submitButton" type="submit"
							style="background-color: black;color: white;border-radius: 50%; display: block; margin: 0 auto; text-align: center; width: 75px; height: 75px; font-size: 13px;">Picar</button>
					</div>
				</form>
			</div>

			<div id="lista"></div>

			<form action="phpsystems/logout.php" id="logout" method="post">
				<button href="#" type="submit" value="Logout"
					style="background-color: black;color: white;">Logout</button>
			</form>

			<?php
			session_start(); // inicia a sessão
			
			// verifica se o utilizador está autenticado
			if (!isset($_SESSION["username"])) {
				header("Location: login.php");
				exit();
			}
			?>

			<script src="javascript/logout.js"></script>
			<script src="javascript/mapa.js"></script>
			<script src="javascript/main.js"></script>
		</div>
	</div>
</body>

</html>