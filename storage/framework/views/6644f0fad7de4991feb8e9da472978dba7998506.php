<?php $__env->startSection('title', 'Редактирование заявки - Починим.Онлайн'); ?>

<?php $__env->startSection('content'); ?>


    <div class="container d-flex justify-content-center">
        <div class="flex shadow p-3 mb-5 bg-white rounded">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(Auth::user() && Auth::user()->isClient()): ?>
                <!-- регистрация клиента и новая заявка -->
                <?php if(session('status')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('status')); ?>

                    </div>
					<?php endif; ?>

					<?php
							$mapbox = ['no_autocenter' => true, 'height' => '100%'];
						  	$offer = \App\Models\Offer::find($offer_id);
							$location = $offer->location;

							if ($location != '') {
								$lng = substr($location, 0, strpos($location, ','));
								$lat = substr($location, strpos($location, ',') + 1);
								$mapbox['lng'] = $lng;
								$mapbox['lat'] = $lat;
							}

					?>
               <?php echo $__env->make('requests', ['password_required' => false, 'mapbox' => $mapbox, 'mode'=>'edit', 'offer_title' => $offer->title, 'offer_descr' => $offer->descr, 'offer_id' => $offer_id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/edit-offer.blade.php ENDPATH**/ ?>