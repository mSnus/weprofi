<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		MapBox test
	</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src='/js/app.js'></script>
	<script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
	<link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
	<!-- Load the `mapbox-gl-geocoder` plugin. -->
	<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
	<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">

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
</head>

<body>
	<!-- MapBox -->
	<div class="mapbox-container">
		<div id='map' style='width: 660px; height: 660px; margin-top: 20px;'></div>
		<pre id="coordinates" class="coordinates"></pre>
	</div>

	<script>
		mapboxgl.accessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2tvNGdweGxnMTI4bDJ4bHBtdG93emo0bSJ9.T7mUOCjIaSp_z5ylugLHyA';


		var geolOptions = {
			enableHighAccuracy: true,
			timeout: 5000,
			maximumAge: 0
		};

		var moscowLng = 37.613067626953125;
		var moscowLat = 55.750303644490394;

		function geolSuccess(pos) {
			crd = pos.coords;
			map = loadMap(crd.longitude, crd.latitude);
		};

		function geolError(err) {
			console.log(`ERROR(${err.code}): ${err.message}`);
			map = loadMap(moscowLng, moscowLat);
		};

		if ("geolocation" in navigator) {
			navigator.geolocation.getCurrentPosition(geolSuccess, geolError, geolOptions);
		}

		function loadMap(lng, lat) {
			mapboxgl.accessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2tvNGdweGxnMTI4bDJ4bHBtdG93emo0bSJ9.T7mUOCjIaSp_z5ylugLHyA';
			var newMap = new mapboxgl.Map({
				container: 'map',
				style: 'mapbox://styles/mapbox/streets-v11',
				center: [lng, lat],
				zoom: 13
			});

			return newMap;
		}

		$(document).ready(() => {
			var map = loadMap(moscowLng, moscowLat);

			map.on('load', function() {



				map.addControl(
					new MapboxGeocoder({
						accessToken: mapboxgl.accessToken,
						mapboxgl: mapboxgl
					})
				);

				map.addControl(new mapboxgl.NavigationControl());
				map.setLayoutProperty('country-label', 'text-field', [
					'get',
					'name_ru'
				]);

				var coordinates = document.getElementById('coordinates');

				var marker = new mapboxgl.Marker({
						draggable: true
					})
					.setLngLat([moscowLng, moscowLat])
					.addTo(map);

				function onDragEnd() {
					var lngLat = marker.getLngLat();
					coordinates.style.display = 'block';
					coordinates.innerHTML =
						'Longitude: ' + lngLat.lng + '<br />Latitude: ' + lngLat.lat;
				}

				marker.on('dragend', onDragEnd);
			});
		});
	</script>
</body>

</html>