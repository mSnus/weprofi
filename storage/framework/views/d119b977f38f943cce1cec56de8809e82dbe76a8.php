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

        <div class="specs">
            <div class="h1">Мы - профи. Кто вам нужен?</div>
            
            <div class="search">
                <input type="text" name="spec_search" id="specSearch">
                <img src="/img/go.svg" alt="Search" width="32" height="32">
            </div>

            <?php
                $specs = App\Models\Spec::with('users')->get()->all();
            ?>
            <?php $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $subspec_count = count($spec->subspecs);
                ?>

                <div class="spec">
                    <a href="/spec/<?php echo e($spec->id); ?>"><?php echo e($spec->title); ?></a>

                    <?php if($subspec_count > 0): ?>
                        <?php $__currentLoopData = $spec->subspecs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subspec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="subspec"><li><a href="/spec/<?php echo e($spec->id); ?>/<?php echo e($subspec->id); ?>"><?php echo e($subspec->title); ?></a></li></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                    <?php endif; ?>
                    
                    
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</div>
<?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/specs.blade.php ENDPATH**/ ?>