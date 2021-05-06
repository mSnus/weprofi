<button <?php echo $attributes->merge([
    'class' => 'btn btn-primary',
    'type' => 'submit'
]); ?>>
    <?php echo trim($slot) ?: __('Submit'); ?>

</button><?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/vendor/form-components/bootstrap-4/form-submit.blade.php ENDPATH**/ ?>