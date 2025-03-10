<?php
    $footer_variant = !is_null(get_footer_style()) ? get_footer_style() : '02';
?>
<?php echo $__env->make('frontend.layout.partials.footer-variant.footer-'.$footer_variant, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('frontend.layout.partials.js.basic-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(asset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/frontend/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/frontend/js/bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('assets/frontend/js/plugin.js')); ?>"></script>
<script src="<?php echo e(asset('assets/frontend/js/main.js')); ?>"></script>
<script src="<?php echo e(asset('assets/frontend/js/dynamic-script.js')); ?>"></script>
<script src="<?php echo e(asset('assets/common/js/toastr.min.js')); ?>"></script>
<?php echo Toastr::message(); ?>

<script src="<?php echo e(asset('assets/backend/js/select2.min.js')); ?>"></script>
<?php echo $__env->make('frontend.layout.partials.js.common-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.layout.partials.gdpr-cookie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(moduleExists("Membership")): ?>
    <?php if(membershipModuleExistsAndEnable("Membership")): ?>
        <?php if (isset($component)) { $__componentOriginal21944edd4f66dcab9decef8c4355830f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal21944edd4f66dcab9decef8c4355830f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.payment.payment-gateway-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('payment.payment-gateway-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal21944edd4f66dcab9decef8c4355830f)): ?>
<?php $attributes = $__attributesOriginal21944edd4f66dcab9decef8c4355830f; ?>
<?php unset($__attributesOriginal21944edd4f66dcab9decef8c4355830f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal21944edd4f66dcab9decef8c4355830f)): ?>
<?php $component = $__componentOriginal21944edd4f66dcab9decef8c4355830f; ?>
<?php unset($__componentOriginal21944edd4f66dcab9decef8c4355830f); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal508283823aceae1ae64ac8dfc522942f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal508283823aceae1ae64ac8dfc522942f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.membership.membership-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('membership.membership-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal508283823aceae1ae64ac8dfc522942f)): ?>
<?php $attributes = $__attributesOriginal508283823aceae1ae64ac8dfc522942f; ?>
<?php unset($__attributesOriginal508283823aceae1ae64ac8dfc522942f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal508283823aceae1ae64ac8dfc522942f)): ?>
<?php $component = $__componentOriginal508283823aceae1ae64ac8dfc522942f; ?>
<?php unset($__componentOriginal508283823aceae1ae64ac8dfc522942f); ?>
<?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginal8238ec7fc95eabf1505d506c1ef94fba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8238ec7fc95eabf1505d506c1ef94fba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-favorite-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-favorite-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8238ec7fc95eabf1505d506c1ef94fba)): ?>
<?php $attributes = $__attributesOriginal8238ec7fc95eabf1505d506c1ef94fba; ?>
<?php unset($__attributesOriginal8238ec7fc95eabf1505d506c1ef94fba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8238ec7fc95eabf1505d506c1ef94fba)): ?>
<?php $component = $__componentOriginal8238ec7fc95eabf1505d506c1ef94fba; ?>
<?php unset($__componentOriginal8238ec7fc95eabf1505d506c1ef94fba); ?>
<?php endif; ?>
<?php echo $__env->make('frontend.pages.listings.listings-search-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.layout.partials.search.home-search-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.layout.partials.js.toastr-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.layout.partials.js.slick-slider-configuration-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.layout.partials.js.newsletter-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(!empty(get_static_option('google_map_settings_on_off'))): ?>
    <?php echo $__env->make('frontend.layout.partials.search.google-map-search-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<!--page script-->
<?php if (isset($component)) { $__componentOriginal216a2ad2432d9a708d654a58f9f35f02 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal216a2ad2432d9a708d654a58f9f35f02 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.advertisement-script','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.advertisement-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal216a2ad2432d9a708d654a58f9f35f02)): ?>
<?php $attributes = $__attributesOriginal216a2ad2432d9a708d654a58f9f35f02; ?>
<?php unset($__attributesOriginal216a2ad2432d9a708d654a58f9f35f02); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal216a2ad2432d9a708d654a58f9f35f02)): ?>
<?php $component = $__componentOriginal216a2ad2432d9a708d654a58f9f35f02; ?>
<?php unset($__componentOriginal216a2ad2432d9a708d654a58f9f35f02); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginale4abb09a1606ce81b3c4e80a006f569f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale4abb09a1606ce81b3c4e80a006f569f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn.frontend-update-btn','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('btn.frontend-update-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale4abb09a1606ce81b3c4e80a006f569f)): ?>
<?php $attributes = $__attributesOriginale4abb09a1606ce81b3c4e80a006f569f; ?>
<?php unset($__attributesOriginale4abb09a1606ce81b3c4e80a006f569f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale4abb09a1606ce81b3c4e80a006f569f)): ?>
<?php $component = $__componentOriginale4abb09a1606ce81b3c4e80a006f569f; ?>
<?php unset($__componentOriginale4abb09a1606ce81b3c4e80a006f569f); ?>
<?php endif; ?>

<?php echo $__env->yieldContent('scripts'); ?>

<?php echo renderBodyEndHooks(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/layout/partials/footer.blade.php ENDPATH**/ ?>