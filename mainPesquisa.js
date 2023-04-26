
  function searchAddress() {
    const morada = document.getElementById('addressInput').value;
    const url = `https://nominatim.openstreetmap.org/search?q=${morada}&format=json&limit=1`;
  
    fetch(url)
      .then(response => response.json())
      .then(data => {
        const lat = data[0].lat;
        const lng = data[0].lon;
        map.setView([lat, lng], 15);
        L.marker([lat, lng]).addTo(map);
      })
      .catch(error => {
        console.error('Error searching address:', error);
      });
  }
  
  
