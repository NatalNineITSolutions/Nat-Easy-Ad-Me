<script src="<?php echo e(asset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/common/js/jquery-migrate-3.4.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/common/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/backend/js/slick.js')); ?>"></script>
<script src="<?php echo e(asset('assets/backend/js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('assets/backend/js/fancybox.umd.js')); ?>"></script>
<script src="<?php echo e(asset('assets/backend/js/main.js')); ?>"></script>
<script src="<?php echo e(asset('assets/common/js/toastr.min.js')); ?>"></script>
<?php if (isset($component)) { $__componentOriginal569452b5e21325d03292b882fe8e7b45 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal569452b5e21325d03292b882fe8e7b45 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.backend.password-show-hide-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('backend.password-show-hide-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal569452b5e21325d03292b882fe8e7b45)): ?>
<?php $attributes = $__attributesOriginal569452b5e21325d03292b882fe8e7b45; ?>
<?php unset($__attributesOriginal569452b5e21325d03292b882fe8e7b45); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal569452b5e21325d03292b882fe8e7b45)): ?>
<?php $component = $__componentOriginal569452b5e21325d03292b882fe8e7b45; ?>
<?php unset($__componentOriginal569452b5e21325d03292b882fe8e7b45); ?>
<?php endif; ?>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<?php if (isset($component)) { $__componentOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn.custom','data' => ['id' => 'update','title' => __('Submitting')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('btn.custom'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('update'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Submitting'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c)): ?>
<?php $attributes = $__attributesOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c; ?>
<?php unset($__attributesOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c)): ?>
<?php $component = $__componentOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c; ?>
<?php unset($__componentOriginal0d2c7aa13a8cfe9d02ef315fc9a4b31c); ?>
<?php endif; ?>

<?php echo $__env->yieldContent('scripts'); ?>

<?php if (isset($component)) { $__componentOriginal9cf0f030cf2491f76cc8ff253ab02f1e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9cf0f030cf2491f76cc8ff253ab02f1e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.popup.default-js-popup','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('popup.default-js-popup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9cf0f030cf2491f76cc8ff253ab02f1e)): ?>
<?php $attributes = $__attributesOriginal9cf0f030cf2491f76cc8ff253ab02f1e; ?>
<?php unset($__attributesOriginal9cf0f030cf2491f76cc8ff253ab02f1e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9cf0f030cf2491f76cc8ff253ab02f1e)): ?>
<?php $component = $__componentOriginal9cf0f030cf2491f76cc8ff253ab02f1e; ?>
<?php unset($__componentOriginal9cf0f030cf2491f76cc8ff253ab02f1e); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/backend/partials/footer.blade.php ENDPATH**/ ?>