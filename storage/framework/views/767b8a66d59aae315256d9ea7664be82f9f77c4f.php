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
            $specs = App\Models\Users::where('usertype', 22)->
            //with('specs')
                ->get()
                ->all();
        ?>

        <div class="specs">
            <div class="h1">Уточните</div>

            <div class="search">
                <input type="text" name="spec_search" id="specSearch">
                <img src="/img/go.svg" alt="Search" width="32" height="32">
            </div>

            <?php $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $user_count = count($spec->users);
                ?>
                <div class="spec"><?php echo e($spec->title); ?> <?php echo e($user_count > 0 ? '(' . $user_count . ')' : ''); ?>


                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</div>
<?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/subspecs.blade.php ENDPATH**/ ?>