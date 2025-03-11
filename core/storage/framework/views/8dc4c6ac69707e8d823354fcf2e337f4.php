<?php if(session()->has('msg')): ?>
    <div class="alert alert-<?php echo e(session('type')); ?>">
        <?php echo purify_html(session('msg')); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/msg/response-message.blade.php ENDPATH**/ ?>