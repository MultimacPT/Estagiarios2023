// Definir manipulador de eventos para o botão de localização
document.getElementById("btn-locate").onclick = function () {
    map.locate({ setView: true, maxZoom: 16 });
  };
  
  // Manipulador de eventos para a localização encontrada com sucesso
  function onLocationFound(e) {
    map.eachLayer(function (layer) {
        if (layer instanceof L.Marker || layer instanceof L.Circle) {
          layer.remove();
        }
      });
    var radius = e.accuracy / 2;
  
    L.marker(e.latlng).addTo(map).bindPopup("Esta é a sua localização").openPopup();
  
    L.circle(e.latlng, radius).addTo(map);

    if (!localStorage.getItem('locationMessageShown')) {
        alert("Sua localização foi encontrada.");
        localStorage.setItem('locationMessageShown', true);
      }

      reverseGeocode(e.latlng.lat, e.latlng.lng);
  }

  function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
      .then(response => response.json())
      .then(data => {
        const address = data.display_name;
        console.log(address); // mostra a morada no console
        console.log(`${lat},${lng}`);
      });
  }
  // Manipulador de eventos para o evento locationerror
  function onLocationError(e) {
    alert(e.message);
  }

  setInterval(showLocation, 30000);
  // Adicionar manipuladores de eventos ao mapa
  map.on("locationfound", onLocationFound);
  map.on("locationerror", onLocationError);

  // Função para exibir a localização atual do utilizador
function showLocation() {
    map.locate({ setView: true, maxZoom: 16 });
  }
  
  
  // Definir manipulador de eventos para o botão de localização
  document.getElementById("btn-locate").onclick = showLocation;
  
  // Adicionar manipuladores de eventos ao mapa
  map.on("locationfound", onLocationFound);
  map.on("locationerror", onLocationError);
  
  // Exibir a localização do utilizador quando a página é carregada
  window.onload = showLocation;


  
  


  /*$( document ).on( "pagecreate", "#map-page", function() {
        var defaultLatLng = new google.maps.LatLng(34.0983425, -118.3267434);  // Default to Hollywood, CA when no geolocation support
        if ( navigator.geolocation ) {
        function success(pos) {
        // Location found, show map with these coordinates
            drawMap(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
            }
            function fail(error) {
                drawMap(defaultLatLng);  // Failed to find location, show default map
            }
            // Find the users current position.  Cache the location for 5 minutes, timeout after 6 seconds
            navigator.geolocation.getCurrentPosition(success, fail, {maximumAge: 500000, enableHighAccuracy:true, timeout: 6000});
        } else {
            drawMap(defaultLatLng);  // No geolocation support, show default map
        }
        function drawMap(latlng) {
            var myOptions = {
            zoom: 10,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
            / Add an overlay to the map of current lat/lng
            var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: "Greetings!"
            });
        }
    });

    */