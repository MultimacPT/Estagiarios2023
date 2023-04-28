<!DOCTYPE html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Entradas e saidas</title>
	<link rel="stylesheet" href="themes/tema.min.css" />
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
			<h1>Picar entrada e saida</h1>
		</div>
		<div data-role="content" data-theme="a">
		<div id="loader"><img src="themes/images/ajax-loader.gif"></div>

            <form action="Picar.php" id="myForm" method="post">
                <input type="submit" value="validar entrada">
            </form>

			<button id="btn-locate" style="display: none;">Localizar minha posição</button>
			<div id="map"></div>

			<div id="lista"></div>

			<div data-role="footer" data-theme="a"> 
			<h4>Multimac</h4> 
			</div>
		</div>

	</div>
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
</body>
</html>
