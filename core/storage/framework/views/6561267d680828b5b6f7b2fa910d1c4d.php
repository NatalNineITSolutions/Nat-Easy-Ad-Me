<a tabindex="0" class="cmn-btn1 cmn-btn-danger btnIcon swal_delete_button">
    <i class="las la-trash-alt"></i>
    <?php echo e($title ?? __('Delete Ads')); ?>

</a>
<form method='post' action='<?php echo e($url); ?>' class="d-none">
    <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>'>
    <br>
    <button type="submit" class="cmnBtn btn_5 btn_small swal_form_submit_btn d-none"></button>
</form>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/popup/frontend-listing-delete-popup.blade.php ENDPATH**/ ?>