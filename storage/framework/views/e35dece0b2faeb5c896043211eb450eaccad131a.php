<?php $__env->startSection('head'); ?>
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

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2tvNGdweGxnMTI4bDJ4bHBtdG93emo0bSJ9.T7mUOCjIaSp_z5ylugLHyA';

        var moscowLng = 37.613067626953125;
        var moscowLat = 55.750303644490394;
        var noAutocenter = <?php echo e(isset($mapbox['no_autocenter']) && $mapbox['no_autocenter'] == true ? 'true' : 'false'); ?>;

    </script>
<?php $__env->stopSection(); ?>


<div class="mapbox-container">

    <div id='<?php echo e($mapbox['id']); ?>' style='width: <?php echo e(isset($mapbox['width']) ? $mapbox['width'] : '100%'); ?>; height: <?php echo e(isset($mapbox['width']) ? $mapbox['height'] : '300px'); ?>; margin-top: 20px;'></div>
    <pre id="coordinates" class="coordinates"></pre>


    <script>
        $(document).ready(() => {
            var obj_<?php echo e($mapbox['id']); ?> = {
                map: {},
					 marker: {},
					 navcon: {},
                startLng: <?php echo e(isset($mapbox['lng']) ? $mapbox['lng'] : 'moscowLng'); ?>,
                startLat: <?php echo e(isset($mapbox['lat']) ? $mapbox['lat'] : 'moscowLat'); ?>,

                loadMap: function() {
                    this.map = new mapboxgl.Map({
                        container: '<?php echo e($mapbox['id']); ?>',
                        style: 'mapbox://styles/mapbox/streets-v11',
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

								console.log("Map obj_<?php echo e($mapbox['id']); ?> loaded.");

							});
                },

            };

            obj_<?php echo e($mapbox['id']); ?>.loadMap();
            var map_id = $(obj_<?php echo e($mapbox['id']); ?>.map);
        });

    </script>
</div>
<?php /**PATH /home/admin/web/pochinim.online/public_html/app/resources/views/mapbox_static.blade.php ENDPATH**/ ?>