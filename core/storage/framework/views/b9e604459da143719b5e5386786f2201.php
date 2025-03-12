<a tabindex="0" class="cmnBtn btn_5 btn_bg_blue btnIcon radius-5 swal_email_verify_button"><?php echo e($title); ?></a>
<form method='post' action='<?php echo e($url); ?>' class="d-none">
    <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>'>
    <br>
    <button type="submit" class="swal_form_submit_btn d-none"></button>
</form>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/status/table/email-verify.blade.php ENDPATH**/ ?>