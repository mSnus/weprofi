<div class="mapbox-container">

    <div
        id='{{ $mapbox['id'] }}'
        style='width: {{ isset($mapbox['width']) ? $mapbox['width'] : '100%' }};
              height: {{ isset($mapbox['width']) ? $mapbox['height'] : '100%' }};
              margin-top: 20px;'
    ></div>

    <pre id="coordinates" class="coordinates"></pre>

    <script>
        document.addEventListener("DOMContentLoaded", ()=>{
            mapboxgl.accessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2xjcDR6aXl6MW1ucjNucnlla2QxMDlxNyJ9.TkJDK4vDlvyO62e_OVbJ3A';

            var defaultLng = 35.074002;
		        var defaultLat = 32.930288;
            var noAutocenter = {{ isset($mapbox['no_autocenter']) && $mapbox['no_autocenter'] == true ? 'true' : 'false' }};

            var obj_{{ $mapbox['id'] }} = {
                map: {},
                marker: {},
                navcon: {},

                startLng: {{ isset($mapbox['lng']) ? $mapbox['lng'] : 'defaultLng' }},
                startLat: {{ isset($mapbox['lat']) ? $mapbox['lat'] : 'defaultLat' }},

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

                    this.map.addControl(new mapboxgl.NavigationControl());

                    this.map.addControl(new mapboxgl.GeolocateControl({
                        positionOptions: {
                            enableHighAccuracy: true
                        },
                        trackUserLocation: true,
                        showUserLocation: true,
                        showUserHeading: true,
                        fitBoundsOptions: {
                            maxZoom: 20
                        }
                    }));

                    this.map.addControl(new mapboxgl.ScaleControl());

                    this.map.on('styledata', function() {
                        this.setLayoutProperty('country-label', 'text-field', [
                            'get',
                            'name_en'
                        ]);

                        // console.log("Map obj_{{ $mapbox['id'] }} loaded.", self);

                    });
                },

            };

            obj_{{ $mapbox['id'] }}.loadMap();
            // var map_id = $(obj_{{ $mapbox['id'] }}.map);
        });

    </script>
</div>

@if (isset($mapbox['lng']) && isset($mapbox['lat']))
    <div class="map-routes">
      <a href="https://www.waze.com/ul?ll={{ $mapbox['lat'] }}%2C{{ $mapbox['lng'] }}&navigate=yes&zoom=17"><img src="/img/waze.png" width="32"></a>
      <a href="https://www.google.com/maps/dir/?api=1&destination={{ $mapbox['lat'] }}%2C{{ $mapbox['lng'] }}&dir_action=navigate&zoom=17"><img src="/img/gmaps-icon.svg" width="32"></a>
    </div>
@endif
