<div class="relevant-ads box-shadow1">
    <h4 class="disTittle"><?php echo e(get_static_option('listing_relevant_title') ?? __('Relevant Ads')); ?></h4>
    <div class="add-wraper relevant-listing-wrapper">
       <?php echo $__env->make('frontend.pages.listings.relevant-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="text-center mt-3">
        <?php if($related_listings->isEmpty()): ?>
            <div class="btn-wrapper">
                <button class="cmn-btn2 transparent-btn" disabled><?php echo e(__('No More Relevant Items')); ?></button>
            </div>
        <?php else: ?>
            <button id="load-more-ads" class="cmn-btn2 red-btn" data-listing-id="<?php echo e($listing->id); ?>"><?php echo e(__('Load More')); ?></button>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/pages/listings/relevant-listing.blade.php ENDPATH**/ ?>