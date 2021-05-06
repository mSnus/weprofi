<?php $__env->startSection('content'); ?>

    <?php if(session('status')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

	 <?php
	 	function shortenLocation($location){
				$lng = substr($location, 0, strpos($location, ','));
				$lat = substr($location, strpos($location, ',') + 1);
				$precision = 4;
				$lng = trim(substr($lng, 0, strpos($lng, '.')+$precision));
				$lat = trim(substr($lat, 0, strpos($lat, '.')+$precision));

				return $lng.",".$lat;
			}

								function mapboxDurations($location){
				$allmasters = App\Models\Master::all();
			$mapboxAccessToken = 'pk.eyJ1IjoibXNudXMiLCJhIjoiY2tvNGdweGxnMTI4bDJ4bHBtdG93emo0bSJ9.T7mUOCjIaSp_z5ylugLHyA';
			$master_coords = [];
			$master_coords['src'] = '--fill-it-later-with-source-coords--';



			foreach($allmasters as $master) {
				$master_coords[$master->userid] = shortenLocation($master->location);
			}

									$master_coords['src'] = shortenLocation($location);

									$mapboxMatrixRequest = "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/"
									.join(';', $master_coords).
									"?sources=0&annotations=duration&access_token=".$mapboxAccessToken;


									$result = file_get_contents($mapboxMatrixRequest);
									$durations = json_decode($result)->durations[0];

									for ($i = 0; $i < count($durations); $i++){
										$durations[$i] = intval(floor(floatval($durations[$i]) / 60));
									}

									return $durations;
								}
	?>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-header">Ваши заказы:</div>

                    <div class="card-body">
                        <div class="offers-container">
                            <?php
                                $client_id = Auth::user()->id;
                                $all_offers = App\Models\Offer::where('client', $client_id)->get();
                            ?>
                            <?php $__currentLoopData = $all_offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="offer">

                                    <div class="offer-title">
                                        <b><?php echo e($offer->title); ?></b>
                                        <br>

                                        <?php
                                            $masters = $offer->masters;
                                            $btnClass = $masters->count() == 0 ? 'btn-outline-success' : 'btn-success';
                                            $btnText = $masters->count() == 0 ? '' : '(+' . $masters->count() . ')';
                                        ?>

                                    </div>


                                    <div class="offer-actions d-flex flex-nowrap align-items-start">
                                        <a class="ml-4 btn <?php echo e($btnClass); ?>" data-toggle="modal" data-target="#offerModal_<?php echo e($offer->id); ?>">
                                            Посмотреть&nbsp;<?php echo e($btnText); ?>

                                        </a>
                                    </div>


                                </div>
                                <!-- Modal: <?php echo e($offer->id); ?> -->
                                <div class="modal fade" id="offerModal_<?php echo e($offer->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e($offer->title); ?></h5>
																<a class="ml-4 btn btn-outline-warning" onclick="window.location.href = '<?php echo e(route('client.edit-offer', [$offer->id])); ?>';">
																	Редактировать
																  </a>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo e($offer->descr); ?>

                                                <br><br>

                                                <?php
																	if ($offer->location) {
																	 $durations = mapboxDurations($offer->location);
																	}

                                                    $mapbox = ['no_autocenter' => true, 'height' => '100%'];

                                                    $location = $offer->location;

                                                    if ($location != '') {
                                                        $lng = substr($location, 0, strpos($location, ','));
                                                        $lat = substr($location, strpos($location, ',') + 1);
                                                        $mapbox['lng'] = $lng;
                                                        $mapbox['lat'] = $lat;
                                                        $mapbox['id'] = 'map_' . $offer->id;
                                                    }

																	$cnt = 0;
                                                ?>

                                                <?php if($offer->location != ''): ?>
                                                    <?php echo $__env->make('mapbox_static', $mapbox, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>


                                                <?php if($masters->count() > 0): ?>
                                                    <div class="master-list">
                                                        Получены предложения от:
                                                        <?php $__currentLoopData = $masters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	 			<?php
																	 				$cnt++;
																				?>
                                                            <div class="master-item <?php if($offer->master == $master->userid): ?> alert alert-success <?php endif; ?>">

                                                                <div class="master-details">
																						 <div class="master-name"><?php echo e($master->title); ?></div>
																						 <div class="master-descr"><?php echo e($master->descr); ?></div>
																						 <?php if($offer->location): ?>
																						 <div class="master-descr">Доедет за <?php echo e($durations[$cnt]); ?> минут</div>
																						 <?php endif; ?>
																						 <div class="master-score">
																						 <?php for($i = 0; $i < $master->score; $i++): ?>
																							  <img src="/img/star.svg" width="15" alt="star">
																						 <?php endfor; ?>

																						 </div>
																					 </div>


																					 <?php if($offer->master != $master->userid): ?>
                                                                <div class="master-form">
                                                                    <?php if (isset($component)) { $__componentOriginal482f2f94a511423fee1dd3ffdf704c90519dfbbc = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\Form::class, []); ?>
<?php $component->withName('form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('client.accept', [$offer->id, $master->userid])),'class' => ' d-flex flex-nowrap w-100 mb-4 justify-content-end']); ?>
                                                                        <?php echo method_field('PUT'); ?>
																									<?php if (isset($component)) { $__componentOriginald49072503c687d5977279cc274621cb08ed343b1 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormSubmit::class, []); ?>
<?php $component->withName('form-submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'ml-4']); ?>Выбрать <?php if (isset($__componentOriginald49072503c687d5977279cc274621cb08ed343b1)): ?>
<?php $component = $__componentOriginald49072503c687d5977279cc274621cb08ed343b1; ?>
<?php unset($__componentOriginald49072503c687d5977279cc274621cb08ed343b1); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                                                                     <?php if (isset($__componentOriginal482f2f94a511423fee1dd3ffdf704c90519dfbbc)): ?>
<?php $component = $__componentOriginal482f2f94a511423fee1dd3ffdf704c90519dfbbc; ?>
<?php unset($__componentOriginal482f2f94a511423fee1dd3ffdf704c90519dfbbc); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                                                                </div>
																					 <?php endif; ?>
                                                            </div>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Modal: <?php echo e($offer->id); ?> -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-5">
                <div class="d-flex justify-content-center">
                    <div class="">
                        <?php echo $__env->make('requests', ['password_required' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/clients_home.blade.php ENDPATH**/ ?>