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
	<script src="picagem-main-picar.js"></script>
	<script src="leaflet/leaflet.js"></script>
</head>
<body>
	<div data-role="page">
		<div data-role="header" data-theme="b" class="ui-header-fixed">
            <div style="text-align: center; margin: 0 auto;">
                <h1>Home</h1>
            </div>
	    </div>

	    <div data-role="form" data-theme="a" style="padding-bottom: 50px;">

		    <div id="loader"><img src="themes/images/ajax-loader.gif"></div>

		    <div id="map">
                <form method="post" id="myForm" action="picagem-picar.php">
                    <div style="display: flex; justify-content: center; align-items: center; height: 365px;">
                        <button href="#" type="submit" style="border-radius: 50%; display: block; margin: 0 auto; text-align: center; width: 75px; height: 75px; font-size: 13px;">Picar</button>
                    </div>
                </form>
			</div>	

		    	<button id="btn-locate" style="display: none;">Localizar minha posição</button>
			
			    <div id="lista"></div>
			    <script>
					// Definir a variável do contêiner do mapa
					var mapContainer = document.getElementById('map');
					// Definir as opções do mapa
					var mapOptions = {
					    center: [38.7238099,-9.1342295],
					    zoom: 13,
					// desabilitar o zoom com o scroll do mouse
					    scrollWheelZoom: false,
				     	dragging: false,
					    touchZoom: false,
					    zoomControl: false,
					    doubleClickZoom: false
				    };
					// Criar o mapa Leaflet com as opções definidas
					var map = L.map('map', mapOptions);
					// Adicionar camada do mapa base
					L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
 					   attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
 					   maxZoom: 19
					}).addTo(map);
					// Adicionar o código para interromper o zoom com o scroll do mouse
					mapContainer.addEventListener('wheel', function(event) {
 					   event.preventDefault();
					}, { passive: false });
				</script>
			    <script src="main.js"></script>
			
        </div>

	    <div data-role="footer" class="ui-footer-fixed">
			<footer>
				<div data-role="navbar">
					<ul>
					  <li><a href="relatorio-layout.php">Relatório</a></li>
					  <li><a href="picagem-layout.php" class="ui-btn-active">Picagem</a></li>
					  <li><a href="perfil-layout.php">Perfil</a></li>
					</ul>
				  </div>
			</footer>
	    </div>
	</div>
</body>
</html>