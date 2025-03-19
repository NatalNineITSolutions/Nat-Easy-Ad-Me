<!-- top Listings  S t a r t -->
<section class="featureListing" data-padding-top="<?php echo e($padding_top); ?>" data-padding-bottom="<?php echo e($padding_bottom); ?>" style="background-color:<?php echo e($section_bg); ?>">
    <div class="container-1440">
        <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
            <h2 class="head3"><?php echo e($section_title ?? 'Top Listing'); ?></h2>
            <form id="filter_with_listing_page_top" action="<?php echo e(url(get_static_option('listing_filter_page_url') ?? '/listings')); ?>" method="get">
                 <input type="hidden" name="listing_type_preferences" value="top_listing"/>
                  <a href="#" id="submit_form_listing_filter_top" class="see-all"><?php echo e($explore_text); ?> <i class="las la-angle-right"></i></a>
            </form>
        </div>
        <div class="slider-inner-margin">
            <!-- Single -->
            <?php if (isset($component)) { $__componentOriginalb6539d82a33f5d27d4ce1be9ef6b85ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb6539d82a33f5d27d4ce1be9ef6b85ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-single-list-view','data' => ['listings' => $listings->reject(function($listing) { return $listing->category_id == 54; })]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-single-list-view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listings->reject(function($listing) { return $listing->category_id == 54; }))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb6539d82a33f5d27d4ce1be9ef6b85ce)): ?>
<?php $attributes = $__attributesOriginalb6539d82a33f5d27d4ce1be9ef6b85ce; ?>
<?php unset($__attributesOriginalb6539d82a33f5d27d4ce1be9ef6b85ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb6539d82a33f5d27d4ce1be9ef6b85ce)): ?>
<?php $component = $__componentOriginalb6539d82a33f5d27d4ce1be9ef6b85ce; ?>
<?php unset($__componentOriginalb6539d82a33f5d27d4ce1be9ef6b85ce); ?>
<?php endif; ?>
        </div>
    </div>
</section>
<!-- End-of top -->
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\app\Providers/../../plugins/PageBuilder/views/listing/top-listing-one.blade.php ENDPATH**/ ?>