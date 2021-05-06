<?php $__env->startSection('head'); ?>
    <!-- MapBox -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js'></script>
    <!-- Load the `mapbox-gl-geocoder` plugin. -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

    <!-- Promise polyfill script is required -->
    <!-- to use Mapbox GL Geocoder in IE 11. -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
	 <style>
		.coordinates {
			 background: rgba(0, 0, 0, 0.5);
			 color: #fff;
			 position: absolute;
			 bottom: 40px;
			 left: 10px;
			 padding: 5px 10px;
			 margin: 0;
			 font-size: 11px;
			 line-height: 18px;
			 border-radius: 3px;
			 display: none;
		}

  </style>
<?php $__env->stopSection(); ?>


<div class="mapbox-container">

	<div id='map_id' style='width: <?php echo e(isset($mapbox['width']) ? $mapbox['width'] : '660px'); ?>; height: <?php echo e(isset($mapbox['width']) ? $mapbox['height'] : '660px'); ?>; margin-top: 20px;'></div>
	<pre id="coordinates" class="coordinates"></pre>


	<script>
		 mapboxgl.accessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2tvNGdweGxnMTI4bDJ4bHBtdG93emo0bSJ9.T7mUOCjIaSp_z5ylugLHyA';


		 var moscowLng = 35.074002;
		 var moscowLat = 32.930288;
		 var startLng = <?php echo e(isset($mapbox['lng']) ? $mapbox['lng'] : 'moscowLng'); ?>;
		 var startLat = <?php echo e(isset($mapbox['lat']) ? $mapbox['lat'] : 'moscowLat'); ?>;
		 var noAutocenter = <?php echo e((isset($mapbox['no_autocenter']) && $mapbox['no_autocenter'] == true) ? "true" : "false"); ?>;

		 function updateLocation(coords) {
			  let location = $('.form-with-map #location');
			  location.val(coords.lng+", "+coords.lat);
		 }


		 $(document).ready(() => {
			  var geolOptions = {
					enableHighAccuracy: true,
					timeout: 5000,
					maximumAge: 0
			  };

			  function geolSuccess(pos) {
					crd = pos.coords;
					map_id.setCenter({lng: crd.longitude, lat: crd.latitude});
					// map = loadMap(crd.longitude, crd.latitude);
			  };

			  function geolError(err) {
					console.log(`ERROR(${err.code}): ${err.message}`);
					map_id.setCenter({lng: startLng, lat: startLat});
					// map = loadMap(startLng, startLat);
			  };

			  if ("geolocation" in navigator && !noAutocenter) {
					navigator.geolocation.getCurrentPosition(geolSuccess, geolError, geolOptions);
			  }

			  function loadMap(lng, lat) {
					return new mapboxgl.Map({
						 container: 'map_id',
						 style: 'mapbox://styles/mapbox/streets-v12',
						 center: [lng, lat],
						 zoom: 13
					});

			  }

			  <?php
			  echo('/*mapid is '.($mapbox['id'] ?? '').' */' );
			  ?>


			  var <?php echo e(isset($mapbox['id']) ? $mapbox['id'] : 'map'); ?> = loadMap(startLng, startLat);
			  var map_id = eval(<?php echo isset($mapbox['id']) ? "'".$mapbox['id']."'" : "'map'"; ?>);

			  map_id.on('mouseup', function() {
					console.log('A mouseup event has occurred.');
			  });

			  map_id.on('load', function() {

					var geocoder = map_id.addControl(
						 new MapboxGeocoder({
							  accessToken: mapboxgl.accessToken,
							  mapboxgl: mapboxgl,
							  enableEventLogging: false,
							  countries: 'RU',
							  language: "ru_RU",
							  fuzzyMatch: true,
						 })
					);

					map_id.addControl(new mapboxgl.NavigationControl());
					map_id.setLayoutProperty('country-label', 'text-field', [
						 'get',
						 'name_ru'
					]);

					// var coordinates = document.getElementById('coordinates');

					const newcenter = map_id.getCenter();

					window.selfPositionMarker = new mapboxgl.Marker({
							  draggable: true,
							  color: 'red',
							  scale: 1.5,
						 })
						 .setLngLat(newcenter)
						 .addTo(map_id);
					updateLocation(newcenter);

					function onDragEnd() {
						 var lngLat = window.selfPositionMarker.getLngLat();
						 updateLocation(lngLat);
						 // coordinates.style.display = 'block';
						 // coordinates.innerHTML =
						 //     'Longitude: ' + lngLat.lng + '<br />Latitude: ' + lngLat.lat;
					}

					window.selfPositionMarker.on('dragend', onDragEnd);

					map_id.on('click', function(e) {
						 window.selfPositionMarker.setLngLat(e.lngLat);
						 updateLocation(e.lngLat);
					});

					map_id.on('moveend', async () => {
						 window.selfPositionMarker.setLngLat(map_id.getCenter());
						 updateLocation(map_id.getCenter());
					});

			  });



		 });

	</script>
</div>
<?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/mapbox.blade.php ENDPATH**/ ?>