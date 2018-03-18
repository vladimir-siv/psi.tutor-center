PSI projekat

Pinovano:
	-google.maps API key: AIzaSyCTmjv_17LFv0zZRK8TKPEY8Pghk_x2h0I
		
		<div id="map" class="border-boxed expanded solid-border border-xs border-gray rounded-xxs" style="height:500px"></div>
		<script>function initMap() { var mapCanvas = document.getElementById("map"); var mapCenter = new google.maps.LatLng(44.805468, 20.4758449); var mapOptions = { center: mapCenter, zoom: 10, mapTypeId: google.maps.MapTypeId.HYBRID }; var map = new google.maps.Map(mapCanvas, mapOptions); var marker = new google.maps.Marker({ position: mapCenter, animation: google.maps.Animation.BOUNCE }); marker.setMap(map); }</script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTmjv_17LFv0zZRK8TKPEY8Pghk_x2h0I0&callback=initMap" type="text/javascript"></script>

Verzije:
	-"Project Base"
		1. Dodata "about.html" stranica, kao i google.maps navigacija na njoj
		2. Dodata "subjects.html" stranica, kao i funkcionalnost pretrage samo kategorija
		3. Dodata "tutors.html" stranica, kao i paginacija prikaza samih tutora
		4. Dodata "library.html" stranica, kao i ajax-funkcija za dalju pretragu kategorija i oblasti
		5. Dodat "storage" folder za èuvanje dodatnih podataka, kao što su avatari korisnika i slièno
		6. Ispravljeni manji bagovi
	-"Initial Commit"
		1. Postavljena osnovna dokumentacija sa SSU
		2. Osnovni dizajn i ponasanje kreirano, kao i index stranica