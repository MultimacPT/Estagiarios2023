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
	<link rel="icon" href="images/logo.ico" type="images/favicon">
	<link rel="shortcut icon" href="images/logo.ico" type="images/favicon">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="leaflet/leaflet.css" />
	<script src="leaflet/leaflet.js"></script>
	<script src="javascript/picar.js"></script>
	<script src="javascript/logout.js"></script>
</head>

<body>
	
	<div data-role="page" data-theme="a">
		<div data-role="header" data-theme="a" class="ui-header-fixed">
  			<div style="width: 75px; height: 75px; float: left;">
    				<img src="images/logo-hito-3.png" alt="Hito">
			</div>
  			<a href="#menu-popup" data-rel="popup" data-transition="slide" data-popup="true" data-icon="bars" data-iconpos="notext" class="ui-btn-right ui-btn-inline" style="width: 60px;height: 60px;background-color: black !important;color: white !important;">Menu</a>
  			<div data-role="popup" id="menu-popup" data-theme="a" class="ui-popup-anchor">
    			<ul data-role="listview" data-inset="true" style="min-width:210px;">
					<li><a href="#" id="btn-page-perfil">Perfil de utilizador</a></li>
					<li><a href="#" id="notificacao">Notificações<span id="contar-not"></span></a></li>
					<li><a href="#" id="btn-page-guias">Guias de transporte</a></li>
					<li><a href="#" class="logout-btn" id="logout">Logout</a></li>
    			</ul>
  			</div>
		</div>
		
		<div data-role="popup" id="notification-popup" 
            data-overlay-theme="b" data-theme="b" 
            data-dismissible="false"
            style="max-width:400px;">
              
            <div data-role="header" data-theme="a">
                <h1>Notificação</h1>
            </div>
              
			<div role="main" class="ui-content" style="background-color: white;">
				<h3 class="ui-title">
					Existe atualmente notificações não lidas no CRM.
				</h3>
				
				<a href="#" class="ui-btn ui-corner-all 
					ui-shadow ui-btn-inline ui-btn-b" 
					data-rel="close">OK
				</a>
			</div>
        </div>
		

		<div data-role="form" data-theme="a" style="padding-bottom: 50px;">

			<div id="loader"><img src="themes/images/ajax-loader.gif"></div>

			<button id="btn-locate" style="display: none;">Localizar minha posição</button>

			<div id="map">
				<form method="post" id="myForm" action="phpsystems/picar.php">
					<input type="hidden" name="localizacao" id="localizacao">
					<div style="display: flex; justify-content: center; align-items: center; height: 365px;">
					<div id="tempo"></div>
						<button href="#" id="submitButton" type="submit"
							style="background-color: black;color: white;border-radius: 50%; display: block; margin: 0 auto; text-align: center; width: 75px; height: 75px; font-size: 13px;">Picar
						</button>
					</div>
				</form>
			</div>

			<div id="lista"></div>

			<?php
			session_start(); // inicia a sessão
			
			// verifica se o utilizador está autenticado
			if (!isset($_SESSION["username"])) {
				header("Location: login.php");
				exit();
			}
			?>
			
			<script src="javascript/enviar_notificacao.js"></script>

			<script src="javascript/mapa.js"></script>
			<script src="javascript/main.js"></script>
			<script src="javascript/btns_mudar_picar.js"></script>
		</div>
	</div>
</body>

</html>