<script>
    (function ($){
        "use strict";

        $('#reload').on('click', function(){
            location.reload();
        });

        $('.dark_mode_check').on('click', function(){
            var mode = $("#darkModeValue").val();
            $.ajax({
                type:'GET',
                url:  '<?php echo e(route("admin.dark.mode.toggle")); ?>',
                data:{mode:mode},
                success: function(){
                    location.reload();
                },error: function(){
                }
            });
        });

        $(document).on('click','.swal_delete_button',function(e){
            e.preventDefault();
            Swal.fire({
                title: '<?php echo e(__("Are you sure?")); ?>',
                text: '<?php echo e(__("You would not be able to revert this item!")); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "<?php echo e(__('Yes, Delete it!')); ?>",
                cancelButtonText: "<?php echo e(__('Cancel')); ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).next().find('.swal_form_submit_btn').trigger('click');
                }
            });
        });


        $(document).on('click','.swal_delete_all_lang_data_button',function(e){
            e.preventDefault();
            Swal.fire({
                title: '<?php echo e(__("Are you sure?")); ?>',
                text: '<?php echo e(__("It will delete All language data..!")); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "<?php echo e(__('Yes, Delete it!')); ?>",
                cancelButtonText: "<?php echo e(__('Cancel')); ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).next().find('.swal_form_submit_btn').trigger('click');
                }
            });
        });

        $(document).on('click','.swal_change_language_button',function(e){
            e.preventDefault();
            Swal.fire({
                title: '<?php echo e(__("Are you sure to make this language as a default language?")); ?>',
                text: '<?php echo e(__("Languages will be turn changed as default")); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "<?php echo e(__('Yes, Change it!')); ?>",
                cancelButtonText: "<?php echo e(__('Cancel')); ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).next().find('.swal_form_submit_btn').trigger('click');
                }
            });
        });

    })(jQuery);
</script>

<script>
    //toastr warning
    function toastr_warning_js(msg){
        Command: toastr["warning"](msg, "Warning !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    //toastr warning
    function toastr_success_js(msg){
        Command: toastr["success"](msg, "Success !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    //toastr info
    function toastr_info_js(msg){
        Command: toastr["info"](msg, "Info !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    //toastr error
    function toastr_error_js(msg){
        Command: toastr["error"](msg, "Error !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/popup/default-js-popup.blade.php ENDPATH**/ ?>