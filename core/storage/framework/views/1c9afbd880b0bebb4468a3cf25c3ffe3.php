<div class="form__input__single <?php echo e($divClass ?? 'mb-3'); ?>">
    <label for="<?php echo e($id ?? ''); ?>" class="<?php echo e($labelClass ?? 'form__input__single__label'); ?>"><?php echo e($title ?? ''); ?> <?php if(!empty($required)): ?> <span class="text-danger">*</span> <?php endif; ?> </label>
    <input type="<?php echo e($type ?? ''); ?>" name="<?php echo e($name ?? ''); ?>" id="<?php echo e($id ?? ''); ?>" value="<?php echo e($value ?? ''); ?>" step="<?php echo e($step ?? ''); ?>" placeholder="<?php echo e($placeholder ?? ''); ?>" class="<?php echo e($class ?? 'form-control'); ?>" >
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/form/text.blade.php ENDPATH**/ ?>