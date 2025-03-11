<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            //update profile
            $(document).on('click','.deposit_amount_to_wallet',function(e){
                let amount  = parseInt($('#amount').val());
                let max_amount = parseInt("<?php echo e(get_static_option('deposit_amount_limitation_for_user') ?? '5000'); ?>");
                if(amount == '' || isNaN(amount) || amount <= 0){
                    toastr_warning_js("<?php echo e(__('Please enter your deposit amount.')); ?>");
                    return false;
                }
                if(amount  > max_amount){
                    toastr_warning_js("<?php echo e(__('Deposit amount must not greater than the max limit.')); ?>");
                    return false;
                }
            })

            // pagination
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                histories(page);
            });
            function histories(page){
                $.ajax({
                    url:"<?php echo e(route('user.wallet.paginate.data').'?page='); ?>" + page,
                    success:function(res){
                        $('.search_result').html(res);
                    }
                });
            }

            // search category
            $(document).on('keyup','#string_search',function(){
                let string_search = $(this).val();
                $.ajax({
                    url:"<?php echo e(route('user.wallet.search')); ?>",
                    method:'GET',
                    data:{string_search:string_search},
                    success:function(res){
                        if(res.status=='nothing'){
                            $('.search_result').html('<h5 class="text-center text-danger mb-5 mt-5">'+"<?php echo e(__('Nothing Found')); ?>"+'</h5>');
                        }else{
                            $('.search_result').html(res);
                        }
                    }
                });
            })
        });
    }(jQuery));
</script>
<?php /**PATH C:\laragon\www\easyadme\core\Modules/Wallet\resources/views/user/wallet/wallet-js.blade.php ENDPATH**/ ?>