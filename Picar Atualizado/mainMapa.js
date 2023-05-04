		// Definir a variável do contêiner do mapa
		var mapContainer = document.getElementById('map');

		// Definir as opções do mapa
		var mapOptions = {
		center: [38.7238099,-9.1342295],
		zoom: 13,
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
