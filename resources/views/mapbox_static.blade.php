@section('head')
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

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2tvNGdweGxnMTI4bDJ4bHBtdG93emo0bSJ9.T7mUOCjIaSp_z5ylugLHyA';

        var moscowLng = 37.613067626953125;
        var moscowLat = 55.750303644490394;
        var noAutocenter = {{ isset($mapbox['no_autocenter']) && $mapbox['no_autocenter'] == true ? 'true' : 'false' }};

    </script>
@endsection


<div class="mapbox-container">

    <div id='{{ $mapbox['id'] }}' style='width: {{ isset($mapbox['width']) ? $mapbox['width'] : '100%' }}; height: {{ isset($mapbox['width']) ? $mapbox['height'] : '300px' }}; margin-top: 20px;'></div>
    <pre id="coordinates" class="coordinates"></pre>


    <script>
        $(document).ready(() => {
            var obj_{{ $mapbox['id'] }} = {
                map: {},
					 marker: {},
					 navcon: {},
                startLng: {{ isset($mapbox['lng']) ? $mapbox['lng'] : 'moscowLng' }},
                startLat: {{ isset($mapbox['lat']) ? $mapbox['lat'] : 'moscowLat' }},

                loadMap: function() {
                    this.map = new mapboxgl.Map({
                        container: '{{ $mapbox['id'] }}',
                        style: 'mapbox://styles/mapbox/streets-v12',
                        center: [this.startLng, this.startLat],
                        zoom: 16,
                    });

						  this.marker = new mapboxgl.Marker({
							  draggable: false,
							  color: 'red',
							  scale: 1.2,
						 })
						 .setLngLat({lng: this.startLng, lat: this.startLat})
						 .addTo(this.map);

						 this.navcon = new mapboxgl.NavigationControl();
						 this.map.addControl(this.navcon);

						 this.map.on('styledata', function() {
								this.setLayoutProperty('country-label', 'text-field', [
									'get',
									'name_ru'
								]);

								console.log("Map obj_{{ $mapbox['id'] }} loaded.");

							});
                },

            };

            obj_{{ $mapbox['id'] }}.loadMap();
            var map_id = $(obj_{{ $mapbox['id'] }}.map);
        });

    </script>
</div>
