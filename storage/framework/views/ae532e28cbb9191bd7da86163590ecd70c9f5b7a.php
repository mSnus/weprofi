<?php $__env->startSection('title', 'WeProfi'); ?>

<?php $__env->startSection('content'); ?>

    <div class="d-flex justify-content-center section-requests">

        <div class="newoffer-form mr-0">
            <!-- Validation Errors -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>



            <?php
                $spec = App\Models\Spec::where('id', $spec_id)->first();
            ?>

            <div class="specs">
                <h1><?php echo e($spec->title); ?></h1>

                <div class="search">
                    <input type="text" name="spec_search" id="specSearch">
                    <img src="/img/go.svg" alt="Search" width="32" height="32">
                </div>

                <?php if(!is_null($persons)): ?>
                    <div class="users">

                        <?php $__currentLoopData = $persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="user" onclick="window.location.href='/user/<?php echo e($person->user_id); ?>'">
                                <?php echo e($person->title); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="empty-result">Тут пока никого нет</div>
                <?php endif; ?>

            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/profi_list.blade.php ENDPATH**/ ?>