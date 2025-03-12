<a tabindex="0" class="cmnBtn btn_5 btn_bg_danger btnIcon radius-5 swal_delete_button"><?php echo e($title ?? ''); ?> <i class="las la-trash-alt"></i></a>
<form method='post' action='<?php echo e($url); ?>' class="d-none">
    <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>'>
    <br>
    <button type="submit" class="cmnBtn btn_5 btn_small swal_form_submit_btn d-none"></button>
</form>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/popup/delete-popup.blade.php ENDPATH**/ ?>