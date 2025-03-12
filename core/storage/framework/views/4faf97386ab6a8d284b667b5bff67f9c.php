<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            // password check
            $(document).on('click', '.toggle-password', function() {
                $(this).toggleClass('show');
                let input = $(this).siblings('input');
                let icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('la-eye-slash').addClass('la-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('la-eye').addClass('la-eye-slash');
                }
            });
        });
    }(jQuery));
</script>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/backend/password-show-hide-js.blade.php ENDPATH**/ ?>