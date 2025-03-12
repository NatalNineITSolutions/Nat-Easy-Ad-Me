<script>
    (function($){
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '#update', function () {
                $(this).addClass("disabled");
                var buttonText = $(this).text().trim();
                var title = (buttonText === 'Update') ? '<?php echo e(__("Updating")); ?>' : '<?php echo e(__("Submitting")); ?>';
                $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> ' + title);
            });
        });
    })(jQuery);
</script>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/btn/custom.blade.php ENDPATH**/ ?>