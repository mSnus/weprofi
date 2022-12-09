<div class="d-flex justify-content-center section-requests">

    <div class="page-specs">
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


        <div class="h1">Мы - профи. Кто вам нужен?</div>

        <div class="search">
            <input type="text" name="spec_search" id="specSearch">
            <img src="/img/go.svg" alt="Search" width="32" height="32">
        </div>

        <div class="specs">
            <?php
                $specs = App\Models\Spec::get()->all();
            ?>
            <?php $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="spec">
                    <a href="/spec/<?php echo e($spec->id); ?>"><?php echo e($spec->title); ?></a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</div>
<?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/specs.blade.php ENDPATH**/ ?>