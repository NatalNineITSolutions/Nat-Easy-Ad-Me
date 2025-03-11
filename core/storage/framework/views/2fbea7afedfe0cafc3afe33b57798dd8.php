<div class="single-input">
    <label class="label-title"><?php echo e($title ?? ''); ?> <?php if($required): ?> <span class="text-danger">*</span> <?php endif; ?></label>
    <select name="<?php echo e($name ?? ''); ?>" id="<?php echo e($id ?? ''); ?>" class="select2_activation">
        <option value=""><?php echo e(__('Select Country')); ?></option>
        <?php $__currentLoopData = $all_countries = \Modules\CountryManage\app\Models\Country::all_countries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($country->id); ?>" <?php if(Auth::guard('web')->check() && $country->id == Auth::guard('web')->user()->country_id): ?> selected <?php endif; ?>><?php echo e($country->country); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <span class="country_info"></span>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/form/country-dropdown.blade.php ENDPATH**/ ?>