<a tabindex="0" class="cmnBtn btn_5 btn_bg_warning radius-5 btnIcon <?php echo e($class ?? 'swal_status_change'); ?>"><?php echo e($title ?? ''); ?> <i class="las la-pen-square"></i> </a>
<form method='post' action='<?php echo e($url); ?>' class="d-none">
    <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>'>
    <input type='hidden' name='cancel_or_decline_order' value="<?php echo e($value ?? ''); ?>">
    <br>
    <button type="submit" class="cmnBtn btn_5 btn_small swal_form_submit_btn d-none"></button>
</form>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/status/table/status-change.blade.php ENDPATH**/ ?>