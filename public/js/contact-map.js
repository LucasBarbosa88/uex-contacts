let map;
let markers = [];
let infoWindow;

function initMap() {
  map = new google.maps.Map(document.getElementById('contact-map'), {
    center: { lat: -14.2350, lng: -51.9253 },
    zoom: 4
  });
  infoWindow = new google.maps.InfoWindow();
  loadContacts();
}

function loadContacts() {
  axios.get('/api/contacts', {
    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
  })
  .then(res => {
    const listEl = document.getElementById('contact-list');
    listEl.innerHTML = '';

    markers.forEach(marker => marker.setMap(null));
    markers = [];

    res.data.forEach(contact => {
      if (contact.latitude && contact.longitude) {
        const marker = new google.maps.Marker({
          position: { lat: parseFloat(contact.latitude), lng: parseFloat(contact.longitude) },
          map,
          title: contact.name
        });

        marker.addListener('click', () => {
          infoWindow.setContent(`<strong>${contact.name}</strong><br>${contact.address || ''}`);
          infoWindow.open(map, marker);
        });

        markers.push(marker);
      }

      const li = document.createElement('li');
      li.textContent = contact.name;
      li.style.cursor = 'pointer';
      li.style.padding = '5px 0';
      li.addEventListener('click', () => {
        if (contact.latitude && contact.longitude) {
          map.panTo({ lat: parseFloat(contact.latitude), lng: parseFloat(contact.longitude) });
          map.setZoom(15);
          infoWindow.setContent(`<strong>${contact.name}</strong><br>${contact.address || ''}`);
          infoWindow.open(map, markers.find(m => m.getTitle() === contact.name));
        }
      });
      listEl.appendChild(li);
    });

    if (markers.length) {
      const bounds = new google.maps.LatLngBounds();
      markers.forEach(m => bounds.extend(m.getPosition()));
      map.fitBounds(bounds);
    }
  })
  .catch(err => console.error("Erro ao carregar contatos:", err));
}
