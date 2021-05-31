@section('head')
    <!-- MapBox -->
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
@endsection


<div class="mapbox-container">

	<div id='map' style='width: {{ isset($mapbox['width']) ? $mapbox['width'] : '660px' }}; height: {{ isset($mapbox['width']) ? $mapbox['height'] : '660px' }}; margin-top: 20px;'></div>
	<pre id="coordinates" class="coordinates"></pre>


	<script>
		 mapboxgl.accessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2tvNGdweGxnMTI4bDJ4bHBtdG93emo0bSJ9.T7mUOCjIaSp_z5ylugLHyA';


		 var moscowLng = 37.613067626953125;
		 var moscowLat = 55.750303644490394;
		 var startLng = {{ isset($mapbox['lng']) ? $mapbox['lng'] : 'moscowLng' }};
		 var startLat = {{ isset($mapbox['lat']) ? $mapbox['lat'] : 'moscowLat' }};
		 var noAutocenter = {{ (isset($mapbox['no_autocenter']) && $mapbox['no_autocenter'] == true) ? "true" : "false" }};

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
					map.setCenter({lng: crd.longitude, lat: crd.latitude});
					// map = loadMap(crd.longitude, crd.latitude);
			  };

			  function geolError(err) {
					console.log(`ERROR(${err.code}): ${err.message}`);
					map.setCenter({lng: startLng, lat: startLat});
					// map = loadMap(startLng, startLat);
			  };

			  if ("geolocation" in navigator && !noAutocenter) {
					navigator.geolocation.getCurrentPosition(geolSuccess, geolError, geolOptions);
			  }

			  function loadMap(lng, lat) {
					return new mapboxgl.Map({
						 container: 'map',
						 style: 'mapbox://styles/mapbox/streets-v11',
						 center: [lng, lat],
						 zoom: 13
					});

			  }

			  var map = loadMap(startLng, startLat);

			  map.on('load', function() {
					var geocoder = map.addControl(
						 new MapboxGeocoder({
							  accessToken: mapboxgl.accessToken,
							  mapboxgl: mapboxgl,
							  enableEventLogging: false,
							  countries: 'RU',
							  language: "ru_RU",
							  fuzzyMatch: true,
						 })
					);

					map.addControl(new mapboxgl.NavigationControl());
					map.setLayoutProperty('country-label', 'text-field', [
						 'get',
						 'name_ru'
					]);

					// var coordinates = document.getElementById('coordinates');

					const newcenter = map.getCenter();

					window.selfPositionMarker = new mapboxgl.Marker({
							  draggable: true,
							  color: 'red',
							  scale: 1.5,
						 })
						 .setLngLat(newcenter)
						 .addTo(map);
					updateLocation(newcenter);

					function onDragEnd() {
						 var lngLat = window.selfPositionMarker.getLngLat();
						 updateLocation(lngLat);
						 // coordinates.style.display = 'block';
						 // coordinates.innerHTML =
						 //     'Longitude: ' + lngLat.lng + '<br />Latitude: ' + lngLat.lat;
					}

					window.selfPositionMarker.on('dragend', onDragEnd);

					map.on('click', function(e) {
						 window.selfPositionMarker.setLngLat(e.lngLat);
						 updateLocation(e.lngLat);
					});

					map.on('moveend', async () => {
						 window.selfPositionMarker.setLngLat(map.getCenter());
						 updateLocation(map.getCenter());
					});

			  });



		 });

	</script>
</div>
