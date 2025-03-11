<?php if($listings->count() >0): ?>
    <?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="single-add-card">
            <div class="single-add-image">
                <a href="<?php echo e(route('frontend.listing.details', $listing->slug)); ?>">
                  <?php echo render_image_markup_by_attachment_id($listing->image); ?>

                </a>
            </div>
            <div class="single-add-body">
                <h4 class="add-heading head4">
                    <a href="<?php echo e(route('frontend.listing.details', $listing->slug)); ?>"><?php echo e($listing->title); ?></a>
                </h4>

                <div class="btn-wrapper">
                    <?php if($listing->is_featured === 1): ?>
                        <span class="pro-btn2">
                            <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white"/>
                            </svg>
                            <?php echo e(__('FEATURED')); ?>

                         </span>
                     <?php endif; ?>
                </div>
                <div class="pricing head4"><?php echo e(float_amount_with_currency_symbol($listing->price)); ?></div>

                <?php if (isset($component)) { $__componentOriginal4cdc2a70ffddb4ed6be01498b197bb3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4cdc2a70ffddb4ed6be01498b197bb3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-location','data' => ['listing' => $listing]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-location'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4cdc2a70ffddb4ed6be01498b197bb3d)): ?>
<?php $attributes = $__attributesOriginal4cdc2a70ffddb4ed6be01498b197bb3d; ?>
<?php unset($__attributesOriginal4cdc2a70ffddb4ed6be01498b197bb3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4cdc2a70ffddb4ed6be01498b197bb3d)): ?>
<?php $component = $__componentOriginal4cdc2a70ffddb4ed6be01498b197bb3d; ?>
<?php unset($__componentOriginal4cdc2a70ffddb4ed6be01498b197bb3d); ?>
<?php endif; ?>

                <div class="dates">
                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 7.83333L7 6.5V3.16667M1 6.5C1 7.28793 1.15519 8.06815 1.45672 8.7961C1.75825 9.52405 2.20021 10.1855 2.75736 10.7426C3.31451 11.2998 3.97595 11.7417 4.7039 12.0433C5.43185 12.3448 6.21207 12.5 7 12.5C7.78793 12.5 8.56815 12.3448 9.2961 12.0433C10.0241 11.7417 10.6855 11.2998 11.2426 10.7426C11.7998 10.1855 12.2417 9.52405 12.5433 8.7961C12.8448 8.06815 13 7.28793 13 6.5C13 5.71207 12.8448 4.93185 12.5433 4.2039C12.2417 3.47595 11.7998 2.81451 11.2426 2.25736C10.6855 1.70021 10.0241 1.25825 9.2961 0.956723C8.56815 0.655195 7.78793 0.5 7 0.5C6.21207 0.5 5.43185 0.655195 4.7039 0.956723C3.97595 1.25825 3.31451 1.70021 2.75736 2.25736C2.20021 2.81451 1.75825 3.47595 1.45672 4.2039C1.15519 4.93185 1 5.71207 1 6.5Z" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php if($listing->published_at !== null): ?>
                        <?php
                            $publishedAt = \Carbon\Carbon::parse($listing->published_at);
                        ?>
                        <span><?php echo e($publishedAt->diffForHumans()); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (isset($component)) { $__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.favorite-item-add-remove','data' => ['favorite' => $listing->id ?? 0]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.favorite-item-add-remove'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['favorite' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing->id ?? 0)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971)): ?>
<?php $attributes = $__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971; ?>
<?php unset($__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971)): ?>
<?php $component = $__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971; ?>
<?php unset($__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971); ?>
<?php endif; ?>
        </div>
        <div class="devider"></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>

<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/listings/relevant-ads-view.blade.php ENDPATH**/ ?>