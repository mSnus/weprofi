<button <?php echo $attributes->merge([
    'class' => 'btn btn-primary',
    'type' => 'submit'
]); ?>>
    <?php echo trim($slot) ?: __('Submit'); ?>

</button><?php /**PATH /home/admin/web/pochinim.online/public_html/app/resources/views/vendor/form-components/bootstrap-4/form-submit.blade.php ENDPATH**/ ?>