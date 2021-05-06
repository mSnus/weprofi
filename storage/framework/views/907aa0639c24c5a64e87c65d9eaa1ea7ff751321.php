<form method="<?php echo e($spoofMethod ? 'POST' : $method); ?>" <?php echo $attributes->merge([
    'class' => $hasError() ? 'needs-validation' : ''
]); ?>>
    <style>
        .inline-space > :not(template) {
            margin-right: 1.25rem;
        }
    </style>

<?php if (! (in_array($method, ['HEAD', 'GET', 'OPTIONS']))): ?>
    <?php echo csrf_field(); ?>
<?php endif; ?>

<?php if($spoofMethod): ?>
    <?php echo method_field($method); ?>
<?php endif; ?>

    <?php echo $slot; ?>

</form>
<?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/vendor/form-components/bootstrap-4/form.blade.php ENDPATH**/ ?>