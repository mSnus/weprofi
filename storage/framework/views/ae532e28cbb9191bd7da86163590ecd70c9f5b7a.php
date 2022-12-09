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

            <h1 onclick="window.location.href='/'"><?php echo e($spec->title); ?></h1>

            <div class="search">
                <input type="text" name="spec_search" id="specSearch">
                <img src="/img/go.svg" alt="Search" width="32" height="32">
            </div>

            <?php
                $subspec_count = count($spec->subspecs);
            ?>
            
            <div class="specs<?php echo e(($subspec_count < 4 ? ' single-column' : '')); ?>">

                <?php if($subspec_count > 0): ?>
                    <?php $__currentLoopData = $spec->subspecs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subspec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="spec"><a
                                href="/spec/<?php echo e($spec->id); ?>/<?php echo e($subspec->id); ?>"><?php echo e($subspec->title); ?></a></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            </div>

            <?php if(!is_null($persons) && count($persons)): ?>
                <div class="users">

                    <?php $__currentLoopData = $persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="user" onclick="window.location.href='/user/<?php echo e($person->user_id); ?>'">
                            <div class="avatar"><img src="<?php echo e($person->avatar ?? '/img/avatar.png'); ?>" alt="User avatar">
                            </div>
                            <div class="title"><?php echo e($person->title); ?></div>
                            <div class="rating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <img src="/img/star.svg" alt="star">
                                <?php endfor; ?>
                            </div>
                            <div class="tagline"><?php echo e($person->tagline ?? 'профи'); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="empty-result">Тут пока никого нет</div>
            <?php endif; ?>

        </div>
    </div>

    <?php echo $__env->make('components.register', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/profi_list.blade.php ENDPATH**/ ?>