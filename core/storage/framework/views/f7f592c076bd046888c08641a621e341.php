<?php
    $isAuthenticated = auth()->guard('web')->check();
    $isFavorite = $isAuthenticated ? \App\Models\Frontend\ListingFavorite::where('user_id', auth()->guard('web')->user()->id)
                   ->where('listing_id', $favorite)->exists() : false;
    $iconClass = $isFavorite ? 'favorite_remove_icon' : 'favorite_add_icon';

    $user_add_item = '';
    if ($isFavorite){
        $user_add_item = $isFavorite ? 'favourite' : '';
    }

?>
<div class="favourite-icon <?php echo e($user_add_item); ?>">
    <a href="javascript:void(0)" class="click_to_favorite_add_remove"
       data-listing_id="<?php echo e($favorite); ?>">
        <i class="lar la-heart icon <?php echo e($iconClass); ?>"></i> <span><?php echo e(__('Favourite')); ?></span>
    </a>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/listings/favorite-item-add-remove-for-details-page.blade.php ENDPATH**/ ?>