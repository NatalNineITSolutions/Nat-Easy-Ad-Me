<?php if($listings->count() >0): ?>
    <?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="singleFeatureCard">
            <div class="featureImg">
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
                <a href="<?php echo e(route('frontend.listing.details', $listing->slug)); ?>" class="main-card-image">
                    <?php echo render_image_markup_by_attachment_id($listing->image, '','','thumb'); ?>

                </a>
            </div>
            <div class="featurebody">
                <h4> <a href="<?php echo e(route('frontend.listing.details', $listing->slug)); ?>" class="featureTittle head4 twoLine"><?php echo e($listing->title); ?></a> </h4>

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

                <div class="btn-wrapper">
                    <?php if($listing->is_featured === 1): ?>
                        <span class="pro-btn2">
                            <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white"/>
                            </svg>  <?php echo e(__('FEATURED')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <span class="featurePricing d-flex justify-content-between align-items-center">
                <span class="money"><?php echo e(amount_with_currency_symbol($listing->price)); ?></span>
                <span class="date">
                    <?php if(!empty($listing->published_at)): ?>
                        <?php echo e(\Carbon\Carbon::parse($listing->published_at)->diffForHumans()); ?>

                    <?php endif; ?>
                </span>
            </span>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <p><?php echo e(__('No listings found.')); ?></p>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/listings/listing-single-list-view.blade.php ENDPATH**/ ?>