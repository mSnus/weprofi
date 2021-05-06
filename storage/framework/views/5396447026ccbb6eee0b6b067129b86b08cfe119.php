<?php $__env->startSection('content'); ?>

    <?php if(session('status')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="container">
        <div class="row justify-content-center">
                <?php if(Auth::user() && Auth::user()->isMaster()): ?>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Доступные заказы:</div>

                            <div class="card-body">
                                <div class="offers-container">
                                    <?php $__currentLoopData = App\Models\Offer::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="offer">


                                            <div class="offer-title">
                                                <b><?php echo e($offer->title); ?></b> <i><?php echo e($offer->owner_title); ?></i>
                                                <br>

                                                <?php
                                                    $masters = $offer->masters;

                                                    $btnClass = $masters->contains('userid', Auth::user()->id) ? 'btn-outline-success' : 'btn-success';

                                                ?>

                                            </div>


                                            <div class="offer-actions d-flex flex-nowrap align-items-start">
                                                <a class="ml-4 btn <?php echo e($btnClass); ?>" data-toggle="modal" data-target="#offerModal_<?php echo e($offer->id); ?>">
                                                    Посмотреть
                                                </a>
                                            </div>


                                        </div>
                                        <!-- Modal: <?php echo e($offer->id); ?> -->
                                        <div class="modal fade" id="offerModal_<?php echo e($offer->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e($offer->title); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo e($offer->descr); ?>

                                                        <br><br>

																		  <?php
																				$mapbox = ['no_autocenter' => true, 'height' => '100%'];

																				$location = $offer->location;

																				if ($location != '') {
																					 $lng = substr($location, 0, strpos($location, ','));
																					 $lat = substr($location, strpos($location, ',') + 1);
																					 $mapbox['lng'] = $lng;
																					 $mapbox['lat'] = $lat;
																					 $mapbox['id'] = 'map_'.$offer->id;
																				}

																		  ?>

																		  <?php if($offer->location != ''): ?>
																		  	<?php echo $__env->make('mapbox_static', $mapbox, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
																		  <?php endif; ?>


                                                        <?php if($masters->count() > 0): ?>
                                                            Получены предложения от:
                                                            <ul>
                                                                <?php $__currentLoopData = $masters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li><?php echo e($master->title); ?></li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="modal-footer">
																		 <?php if($masters->contains('userid', Auth::user()->id)): ?>
																		 	<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
																		<?php else: ?>
                                                        <?php if (isset($component)) { $__componentOriginal482f2f94a511423fee1dd3ffdf704c90519dfbbc = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\Form::class, []); ?>
<?php $component->withName('form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master.respond', $offer->id)),'class' => ' d-flex flex-nowrap w-100 mb-4 justify-content-end']); ?>
                                                            <?php echo method_field('PUT'); ?>

                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                            <?php if (isset($component)) { $__componentOriginald49072503c687d5977279cc274621cb08ed343b1 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormSubmit::class, []); ?>
<?php $component->withName('form-submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'ml-4']); ?>Откликнуться <?php if (isset($__componentOriginald49072503c687d5977279cc274621cb08ed343b1)): ?>
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
																		  <?php endif; ?>
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
                <?php endif; ?>

                <div class="col-md-8 mt-5">
                    <div class="card">
                        <div class="card-header">Ваши отклики:</div>

                        <div class="card-body">

										<div class="offers-container">
												<ol>
													<?php $__currentLoopData = Auth::user()->offers()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<li><?php echo e($offer->title); ?></li>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</ol>
										</div>

                        </div>
                    </div>
                </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/pochinim.online/public_html/app/resources/views/masters_home.blade.php ENDPATH**/ ?>