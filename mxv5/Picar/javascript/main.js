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

  L.marker(e.latlng).addTo(map).openPopup();

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

      document.getElementById("localizacao").value = address;
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
