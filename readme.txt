PSI projekat

Pinovano:
	-google.maps API key: AIzaSyCTmjv_17LFv0zZRK8TKPEY8Pghk_x2h0I
		
		<div id="map" class="border-boxed expanded solid-border border-xs border-gray rounded-xxs" style="height:500px"></div>
		<script>function initMap() { var mapCanvas = document.getElementById("map"); var mapCenter = new google.maps.LatLng(44.805468, 20.4758449); var mapOptions = { center: mapCenter, zoom: 10, mapTypeId: google.maps.MapTypeId.HYBRID }; var map = new google.maps.Map(mapCanvas, mapOptions); var marker = new google.maps.Marker({ position: mapCenter, animation: google.maps.Animation.BOUNCE }); marker.setMap(map); }</script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTmjv_17LFv0zZRK8TKPEY8Pghk_x2h0I0&callback=initMap" type="text/javascript"></script>

Verzije:
	-"Initial impl"
		1. Promenjena bit tip u bazi na tinyint(1)
		2. Dodat doctrine i generisani entiteti
	-"UML"
		1. Dodat UML model aplikacije
	-"Prototype"
		1. Prototip uraðen do kraja
		2. Iz tmp foldera izbrisan CodeIgniter 3.0.0
		3. Raspakovan CodeIgniter 3.1.8 u public_html i podešen
	-"FR"
		1. Folder "sistem" preimenovan u "public_html"
		2. Kreiran folder "tmp"
		3. Kreirana stranica public_html/index.php (prazna)
		4. Uploadovan CodeIgniter framework (upakovan) u tmp folder
		5. Uraðen FR (arhiviran u okviru foldera dokumentacija)
	-"DB Model"
		1. Dodat model baze podataka
		2. Dokumentovan model baze podataka
		3. Dodat MySQL Export (samo prazne tabele)
		4. Dokumentacija transakcija promenjena (PZ, SSU Zakljuèavanje i Transakcije)
		5. Folder "sistem" preimenovan u "prototip"
		6. Kreiran folder "sistem"
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