<div class="single-input">
    <label class="label-title"><?php echo e($title); ?> <?php if($required): ?> <span class="text-danger">*</span> <?php endif; ?> </label>
    <select name="<?php echo e($name ?? ''); ?>" id="<?php echo e($id ?? ''); ?>" class="select2_activation get_state_city city_select2">
        <option value=""><?php echo e(__('Select City')); ?></option>
        <?php $__currentLoopData = $all_cities = \Modules\CountryManage\app\Models\City::all_cities(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($city->id); ?>" <?php if($city->id == Auth::guard('web')->user()->city_id): ?> selected <?php endif; ?>><?php echo e($city->city); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <span class="city_info"></span>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/form/city-dropdown.blade.php ENDPATH**/ ?>