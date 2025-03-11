<?php if(!empty($listing)): ?>
    <?php if(!is_null($listing->user?->identity_verify) && $listing->user?->identity_verify?->status === 1): ?>
        <span class="varified">
        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.7775 4.37L9.0975 3.58C8.9675 3.43 8.8625 3.15 8.8625 2.95V2.1C8.8625 1.57 8.4275 1.135 7.8975 1.135H7.0475C6.8525 1.135 6.5675 1.03 6.4175 0.899999L5.6275 0.219999C5.2825 -0.0750012 4.7175 -0.0750012 4.3675 0.219999L3.5825 0.904999C3.4325 1.03 3.1475 1.135 2.9525 1.135H2.0875C1.5575 1.135 1.1225 1.57 1.1225 2.1V2.955C1.1225 3.15 1.0175 3.43 0.8925 3.58L0.2175 4.375C-0.0725 4.72 -0.0725 5.28 0.2175 5.625L0.8925 6.42C1.0175 6.57 1.1225 6.85 1.1225 7.045V7.9C1.1225 8.43 1.5575 8.865 2.0875 8.865H2.9525C3.1475 8.865 3.4325 8.97 3.5825 9.1L4.3725 9.78C4.7175 10.075 5.2825 10.075 5.6325 9.78L6.4225 9.1C6.5725 8.97 6.8525 8.865 7.0525 8.865H7.9025C8.4325 8.865 8.8675 8.43 8.8675 7.9V7.05C8.8675 6.855 8.9725 6.57 9.1025 6.42L9.7825 5.63C10.0725 5.285 10.0725 4.715 9.7775 4.37ZM7.0775 4.055L4.6625 6.47C4.5925 6.54 4.4975 6.58 4.3975 6.58C4.2975 6.58 4.2025 6.54 4.1325 6.47L2.9225 5.26C2.7775 5.115 2.7775 4.875 2.9225 4.73C3.0675 4.585 3.3075 4.585 3.4525 4.73L4.3975 5.675L6.5475 3.525C6.6925 3.38 6.9325 3.38 7.0775 3.525C7.2225 3.67 7.2225 3.91 7.0775 4.055Z" fill="white"/>
        </svg>
            <?php echo e(__('VERIFIED')); ?>

        </span>
    <?php endif; ?>
    <?php if (isset($component)) { $__componentOriginald998d8e8eb033009ebef1fd5cdc25544 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald998d8e8eb033009ebef1fd5cdc25544 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge.membership-badge','data' => ['listing' => $listing]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('badge.membership-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald998d8e8eb033009ebef1fd5cdc25544)): ?>
<?php $attributes = $__attributesOriginald998d8e8eb033009ebef1fd5cdc25544; ?>
<?php unset($__attributesOriginald998d8e8eb033009ebef1fd5cdc25544); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald998d8e8eb033009ebef1fd5cdc25544)): ?>
<?php $component = $__componentOriginald998d8e8eb033009ebef1fd5cdc25544; ?>
<?php unset($__componentOriginald998d8e8eb033009ebef1fd5cdc25544); ?>
<?php endif; ?>
<?php endif; ?>

<?php if(!empty($user)): ?>
    <?php if(!is_null($user->identity_verify) && $user->identity_verify->status === 1): ?>
        <span class="varified">
        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.7775 4.37L9.0975 3.58C8.9675 3.43 8.8625 3.15 8.8625 2.95V2.1C8.8625 1.57 8.4275 1.135 7.8975 1.135H7.0475C6.8525 1.135 6.5675 1.03 6.4175 0.899999L5.6275 0.219999C5.2825 -0.0750012 4.7175 -0.0750012 4.3675 0.219999L3.5825 0.904999C3.4325 1.03 3.1475 1.135 2.9525 1.135H2.0875C1.5575 1.135 1.1225 1.57 1.1225 2.1V2.955C1.1225 3.15 1.0175 3.43 0.8925 3.58L0.2175 4.375C-0.0725 4.72 -0.0725 5.28 0.2175 5.625L0.8925 6.42C1.0175 6.57 1.1225 6.85 1.1225 7.045V7.9C1.1225 8.43 1.5575 8.865 2.0875 8.865H2.9525C3.1475 8.865 3.4325 8.97 3.5825 9.1L4.3725 9.78C4.7175 10.075 5.2825 10.075 5.6325 9.78L6.4225 9.1C6.5725 8.97 6.8525 8.865 7.0525 8.865H7.9025C8.4325 8.865 8.8675 8.43 8.8675 7.9V7.05C8.8675 6.855 8.9725 6.57 9.1025 6.42L9.7825 5.63C10.0725 5.285 10.0725 4.715 9.7775 4.37ZM7.0775 4.055L4.6625 6.47C4.5925 6.54 4.4975 6.58 4.3975 6.58C4.2975 6.58 4.2025 6.54 4.1325 6.47L2.9225 5.26C2.7775 5.115 2.7775 4.875 2.9225 4.73C3.0675 4.585 3.3075 4.585 3.4525 4.73L4.3975 5.675L6.5475 3.525C6.6925 3.38 6.9325 3.38 7.0775 3.525C7.2225 3.67 7.2225 3.91 7.0775 4.055Z" fill="white"/>
        </svg>
            <?php echo e(__('VERIFIED')); ?>

        </span>
    <?php endif; ?>
    <?php if (isset($component)) { $__componentOriginald998d8e8eb033009ebef1fd5cdc25544 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald998d8e8eb033009ebef1fd5cdc25544 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge.membership-badge','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('badge.membership-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald998d8e8eb033009ebef1fd5cdc25544)): ?>
<?php $attributes = $__attributesOriginald998d8e8eb033009ebef1fd5cdc25544; ?>
<?php unset($__attributesOriginald998d8e8eb033009ebef1fd5cdc25544); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald998d8e8eb033009ebef1fd5cdc25544)): ?>
<?php $component = $__componentOriginald998d8e8eb033009ebef1fd5cdc25544; ?>
<?php unset($__componentOriginald998d8e8eb033009ebef1fd5cdc25544); ?>
<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/badge/user-verified-badge.blade.php ENDPATH**/ ?>