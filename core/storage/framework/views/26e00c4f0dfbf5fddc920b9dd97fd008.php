<?php if(session()->has('msg')): ?>
    <div class="alert alert-<?php echo e(session('type')); ?>">
        <?php echo purify_html(session('msg')); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/msg/response-message.blade.php ENDPATH**/ ?>