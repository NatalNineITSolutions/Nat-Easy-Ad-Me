<div class="form__input__single mb-3">
    <label class="label-title"><?php echo e($title ?? ''); ?></label>
    <div class="form__input__single position-relative">
        <input type="<?php echo e($type ?? ''); ?>" name="<?php echo e($name ?? ''); ?>" id="<?php echo e($id ?? ''); ?>" class="<?php echo e($class ?? 'form__control'); ?>" placeholder="<?php echo e($placeholder ?? ''); ?>">
        <div class="icon toggle-password position-absolute">
            <i class="las la-eye"></i>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/form/password.blade.php ENDPATH**/ ?>