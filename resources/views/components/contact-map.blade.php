<div style="display: flex; gap: 20px;">
  {{-- Lista de contatos --}}
  <div style="width: 30%; max-height: 500px; overflow-y: auto;">
    <ul id="contact-list">

    </ul>
  </div>

  <div id="contact-map" style="width: 70%; height: 500px;"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=GOOGLE_API_KEY&callback=initMap" async defer></script>
<script src="{{ asset('js/contact-map.js') }}"></script>