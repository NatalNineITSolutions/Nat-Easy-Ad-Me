<a tabindex="0" class="cmn-btn1 btnIcon swal_status_change d-flex">
    <button class="published_unpublished <?php if($published === 1): ?> published <?php endif; ?>"> </button>
</a>
<form method='post' action='<?php echo e($url); ?>' class="d-none">
    <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>'>
    <br>
    <button type="submit" class="swal_form_submit_btn d-none"></button>
</form>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/status/frontend-listing-published-change.blade.php ENDPATH**/ ?>