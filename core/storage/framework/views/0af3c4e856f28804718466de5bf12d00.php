<?php if (isset($component)) { $__componentOriginal55a1d5b0a95dff492d3406dfb13bece9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55a1d5b0a95dff492d3406dfb13bece9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.relevant-ads-view','data' => ['listings' => $related_listings]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.relevant-ads-view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related_listings)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55a1d5b0a95dff492d3406dfb13bece9)): ?>
<?php $attributes = $__attributesOriginal55a1d5b0a95dff492d3406dfb13bece9; ?>
<?php unset($__attributesOriginal55a1d5b0a95dff492d3406dfb13bece9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55a1d5b0a95dff492d3406dfb13bece9)): ?>
<?php $component = $__componentOriginal55a1d5b0a95dff492d3406dfb13bece9; ?>
<?php unset($__componentOriginal55a1d5b0a95dff492d3406dfb13bece9); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/pages/listings/relevant-markup.blade.php ENDPATH**/ ?>