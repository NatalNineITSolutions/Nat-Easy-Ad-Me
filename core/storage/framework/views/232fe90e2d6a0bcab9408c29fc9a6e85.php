<?php if(session()->has('msg')): ?>
    <div class="mt-3 alert alert_margin alert_<?php echo e(session('type')); ?> alert_dismissible fade show mt-3 mb-2" role="alert">
        <?php echo purify_html(session('msg')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="alert alert_margin alert_danger alert_dismissible fade show mt-3 mb-2" role="alert">
        <ul style="list-style:none;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class=""><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/validation/error.blade.php ENDPATH**/ ?>