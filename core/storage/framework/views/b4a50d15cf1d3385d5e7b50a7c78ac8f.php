<!--Banner part Start-->
<div class="home-banner" data-padding-top="<?php echo e($padding_top); ?>" data-padding-bottom="<?php echo e($padding_bottom); ?>" <?php echo $background_image; ?>>
    <div class="container-1920 position-relative plr">
        <div class="letf-part-img">
            <div class="img-wraper">
                <?php if(isset($banner_left_images_01['banner_left_images_'])): ?>
                    <?php $__currentLoopData = $banner_left_images_01['banner_left_images_']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner_left_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($banner_left_image)): ?>
                            <?php $image_key = $key+1  ?>
                            <div class="img<?php echo e($image_key); ?> imges">
                                <?php echo render_image_markup_by_attachment_id($banner_left_images_01['banner_left_images_'][$key]); ?>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="right-part-img">
            <div class="img-wraper">
                <?php if(isset($banner_right_images_02['banner_right_images_'])): ?>
                    <?php $__currentLoopData = $banner_right_images_02['banner_right_images_']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner_right_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($banner_right_image)): ?>
                            <?php $image_right_key = $key+1  ?>
                            <div class="img<?php echo e($image_right_key); ?> imges">
                                <?php echo render_image_markup_by_attachment_id($banner_right_images_02['banner_right_images_'][$key]); ?>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="banner-wraper">
            <div class="banner-text">
                <div class="top-text text-center">
                    <?php echo $top_image; ?>

                    <?php echo e($top_title); ?>

                </div>
                <h1 class="banner-main-head text-center"> <?php echo e($title); ?> </h1>
                <p class="text text-center"><?php echo e($subtitle); ?></p>
            </div>
            <div class="banner-form">
                <form  action="<?php echo e(get_static_option('listing_filter_page_url') ?? '/listings'); ?>" class="d-flex align-items-center banner-search-location" method="get">
                    <div class="banner-form-wraper align-items-center">
                        <?php if(!empty(get_static_option('google_map_settings_on_off'))): ?>
                            <div class="new_banner__search__input">
                                <div class="new_banner__search__location_left" id="myLocationGetAddress">
                                    <i class="fa-solid fa-location-crosshairs fs-4"></i>
                                </div>
                                <input class="form--control" name="change_address_new" id="change_address_new" type="hidden" value="">
                                <input class="banner-input-field w-100" name="autocomplete" id="autocomplete" type="text" placeholder="<?php echo e(__('Search location here')); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="search-with-any-texts">
                            <input class="banner-input-field w-100" type="text" name="home_search" id="home_search" placeholder="<?php echo e(__('What are you looking for?')); ?>">
                            <span id="all_search_result" class="search_with_text_section"></span>
                        </div>
                    </div>
                    <div class="banner-btn">
                        <button type="submit" class="new-cmn-btn rounded-red-btn setLocation_btn border-0"><?php echo e(get_static_option('search_button_title') ?? __('Search')); ?> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Banner part End-->
<?php /**PATH C:\laragon\www\easyadme\core\app\Providers/../../plugins/PageBuilder/views/headers/style-one.blade.php ENDPATH**/ ?>