<div class="form-group">
    <?php if (isset($component)) { $__componentOriginal1ae4545b1c02a29629ea1aadee55f0673d45229b = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormLabel::class, ['label' => $label]); ?>
<?php $component->withName('form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->get('id') ?: $id())]); ?>
<?php if (isset($__componentOriginal1ae4545b1c02a29629ea1aadee55f0673d45229b)): ?>
<?php $component = $__componentOriginal1ae4545b1c02a29629ea1aadee55f0673d45229b; ?>
<?php unset($__componentOriginal1ae4545b1c02a29629ea1aadee55f0673d45229b); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    <textarea
        <?php if($isWired()): ?>
            wire:model<?php echo $wireModifier(); ?>="<?php echo e($name); ?>"
        <?php else: ?>
            name="<?php echo e($name); ?>"
        <?php endif; ?>

        <?php if($label && !$attributes->get('id')): ?>
            id="<?php echo e($id()); ?>"
        <?php endif; ?>

        <?php echo $attributes->merge(['class' => 'form-control ' . ($hasError($name) ? 'is-invalid' : '')]); ?>

    ><?php if (! ($isWired())): ?><?php echo $slot; ?><?php endif; ?> </textarea>

    <?php echo $help ?? null; ?>


    <?php if($hasErrorAndShow($name)): ?>
        <?php if (isset($component)) { $__componentOriginalcdcbbf1f95eb56fbb71a017e50568490be43a3e2 = $component; } ?>
<?php $component = $__env->getContainer()->make(ProtoneMedia\LaravelFormComponents\Components\FormErrors::class, ['name' => $name]); ?>
<?php $component->withName('form-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalcdcbbf1f95eb56fbb71a017e50568490be43a3e2)): ?>
<?php $component = $__componentOriginalcdcbbf1f95eb56fbb71a017e50568490be43a3e2; ?>
<?php unset($__componentOriginalcdcbbf1f95eb56fbb71a017e50568490be43a3e2); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    <?php endif; ?>
</div><?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/vendor/form-components/bootstrap-4/form-textarea.blade.php ENDPATH**/ ?>