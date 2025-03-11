<?php $__env->startSection('site-title'); ?>
    <?php echo e($listing->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php
    $page_info = request()->url();
    $str = explode("/",request()->url());
    $page_info = $str[count($str)-2];
    ?>
    <?php echo e(__(ucwords(str_replace("-", " ", $page_info)))); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('inner-title'); ?>
    <?php echo e($listing->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <?php echo render_page_meta_data_for_listing($listing); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        h5.disTittle {
            font-size: 18px;
        }
        .recentImg {
            height: 72px !important;
            width: 72px !important;
        }
        .phone_number_hide_show {
            display: flex;
            flex-direction: row-reverse;
            font-size: 18px;
            font-weight: 600;
            justify-content: flex-end;
            gap: 7px;
        }
        .select2-container {
            z-index: 900000;
        }
        img.no-image {
            /* width: auto; */
            max-width: 400px;
            margin: auto;
        }
        .btn-group-sm>.btn, .btn-sm {
            padding: .25rem 0;
            font-size: .875rem;
            border-radius: .2rem;
        }

        .slick_slider_item {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: max-content;
        }

        .slick_slider_item a {
            display: flex;
            align-items: center;
            height: 40px;
            border-radius: 20px;
            background-color: rgb(243, 243, 247);
            padding: 8px 16px 8px 12px;
            font-size: 15px;
            font-weight: initial;
            line-height: 16px;
            letter-spacing: 0.25px;
            transition: all;
        }



        .sliderArrow {
            position: relative;
        }

        .sliderArrow .prev-icon,
        .sliderArrow .next-icon {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .sliderArrow .prev-icon {
            left: 10px; /* Adjust this value as needed */
        }

        .sliderArrow .next-icon {
            right: 10px; /* Adjust this value as needed */
        }

        .sliderArrow .prev-icon i,
        .sliderArrow .next-icon i {
            font-size: 24px; /* Adjust the size of the icon */
        }

        @media (max-width: 576px) {
            .sliderArrow .prev-icon,
            .sliderArrow .next-icon {
                width: 30px;
                height: 30px;
            }
            .sliderArrow .prev-icon i,
            .sliderArrow .next-icon i {
                font-size: 18px;
            }
        }

        .zoom-img {
            width: 100%;
            display: block;
        }

        .sliderArrow .prev-icon, .sliderArrow .next-icon {
            width: 30px;
            height: 30px;
        }

    </style>
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/magnific-popup.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!--Listing Details-->
    <div class="proDetails section-padding2">
        <div class="container-1310">
            <div class="bradecrumb-wraper-div">
                <?php if (isset($component)) { $__componentOriginal1886b76dac2bd4a55dfc12d1a06ee6e4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1886b76dac2bd4a55dfc12d1a06ee6e4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb.user-profile-breadcrumb','data' => ['title' => '','innerTitle' => __('Listing Details'),'subInnerTitle' => '','chidInnerTitle' => '','routeName' => '#','subRouteName' => '#']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('breadcrumb.user-profile-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'innerTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Listing Details')),'subInnerTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'chidInnerTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'routeName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('#'),'subRouteName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('#')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1886b76dac2bd4a55dfc12d1a06ee6e4)): ?>
<?php $attributes = $__attributesOriginal1886b76dac2bd4a55dfc12d1a06ee6e4; ?>
<?php unset($__attributesOriginal1886b76dac2bd4a55dfc12d1a06ee6e4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1886b76dac2bd4a55dfc12d1a06ee6e4)): ?>
<?php $component = $__componentOriginal1886b76dac2bd4a55dfc12d1a06ee6e4; ?>
<?php unset($__componentOriginal1886b76dac2bd4a55dfc12d1a06ee6e4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc04996af13f0d779852114b39ea43e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04996af13f0d779852114b39ea43e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation.frontend-error','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('validation.frontend-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04996af13f0d779852114b39ea43e16)): ?>
<?php $attributes = $__attributesOriginalc04996af13f0d779852114b39ea43e16; ?>
<?php unset($__attributesOriginalc04996af13f0d779852114b39ea43e16); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04996af13f0d779852114b39ea43e16)): ?>
<?php $component = $__componentOriginalc04996af13f0d779852114b39ea43e16; ?>
<?php unset($__componentOriginalc04996af13f0d779852114b39ea43e16); ?>
<?php endif; ?>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-8 ">
                    <div class="short-description">
                        <div class="left-part mb-4">
                            <div class="product-name-price">
                                <div class="product-name"><?php echo e($listing->title); ?></div>
                                <div class="right-part text-right">
                                    <div class="price text-end"><span><?php echo e(float_amount_with_currency_symbol($listing->price)); ?></span>
                                        <?php if($listing->negotiable === 1): ?>
                                            <div class="token"><?php echo e(__('NEGOTIABLE')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="date-location">
                                <span><?php echo e(__('Posted on')); ?>  <span class="posted"><?php echo e(\Carbon\Carbon::parse($listing->created_at)->format('j F Y')); ?></span></span>
                                <span class="vartical-devider"></span>
                                <span><?php echo e(get_static_option('listing_location_title') ?? __('Location')); ?>

                                     <span class="posted"> <?php echo e(userListingLocation($listing)); ?> </span>
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Image Slider -->
                    <div class="product-view-wrap" id="myTabContent">
                        <div class="shop-details-gallery-slider global-slick-init slider-inner-margin sliderArrow"
                             data-asNavFor=".shop-details-gallery-nav"
                             data-infinite="true"
                             data-arrows="true"
                             data-dots="false"
                             data-slidesToShow="1"
                             data-swipeToSlide="true"
                             data-fade="true"
                             data-autoplay="false"
                             data-autoplaySpeed="3000"
                             data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                             data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                             data-responsive='[{"breakpoint": 1800,"settings": {"slidesToShow": 1}},{"breakpoint": 1600,"settings": {"slidesToShow": 1}},{"breakpoint": 1400,"settings": {"slidesToShow": 1}},{"breakpoint": 1200,"settings": {"slidesToShow": 1}},{"breakpoint": 991,"settings": {"slidesToShow": 1}},{"breakpoint": 768, "settings": {"slidesToShow": 1}},{"breakpoint": 576, "settings": {"slidesToShow": 1}}]'>

                        <?php if(!is_null($listing->gallery_images)): ?>
                                <?php
                                    $thumb_image = $listing->image;
                                    $gallery_images = $listing->gallery_images;
                                    $all_images_list = $thumb_image . '|' . $gallery_images;
                                    $images = explode("|", $all_images_list);
                                ?>
                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!empty($img)): ?>
                                        <div class="single-main-image">
                                            <a href="#"
                                               data-mfp-src="<?php echo e(get_image_url_id_wise($img)); ?>"
                                               class="long-img image-link" tabindex="-1">
                                                <?php echo render_image_markup_by_attachment_id($img); ?>

                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="single-main-image">
                                    <a href="#" class="long-img">
                                        <?php echo render_image_markup_by_attachment_id($listing->image); ?>

                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Nav -->
                        <?php if(!is_null($listing->gallery_images)): ?>
                        <div class="thumb-wrap">
                            <div class="shop-details-gallery-nav global-slick-init slider-inner-margin sliderArrow"
                                 data-asNavFor=".shop-details-gallery-slider"
                                 data-focusOnSelect="true"
                                 data-infinite="false"
                                 data-arrows="false"
                                 data-dots="false"
                                 data-slidesToShow="6"
                                 data-autoplay="false"
                                 data-swipeToSlide="true"
                                 data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                                 data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                                 data-responsive='[{"breakpoint": 1200,"settings": {"slidesToShow": 5}}, {"breakpoint": 992,"settings": {"slidesToShow": 4}}, {"breakpoint": 450,"settings": {"slidesToShow": 3}}, {"breakpoint": 350,"settings": {"slidesToShow": 2}}]'>

                                <?php if(!is_null($listing->gallery_images)): ?>
                                    <?php
                                        $thumb_image = $listing->image;
                                        $gallery_images = $listing->gallery_images;
                                        $all_images_list = $thumb_image . '|' . $gallery_images;
                                        $images = explode("|", $all_images_list);
                                    ?>
                                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!empty($img)): ?>
                                            <div class="single-thumb">
                                                <a class="thumb-link"
                                                   data-mfp-src="<?php echo e(get_image_url_id_wise($img)); ?>"
                                                   data-toggle="tab"
                                                   href="#image-<?php echo e($img); ?>">
                                                    <?php echo render_image_markup_by_attachment_id($img); ?>

                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php if(!empty($listing->gallery_images)): ?>
                                        <div class="single-thumb">
                                            <a class="thumb-link" data-toggle="tab" href="#">
                                                <?php echo render_image_markup_by_attachment_id($listing->image); ?>

                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Google Adds left-->
                    <div class="googleAdd-wraper after-product-slider">
                        <div class="add">
                            <div class="text-<?php echo e($right_custom_container); ?> single-banner-ads ads-banner-box" id="home_advertisement_store">
                                <input type="hidden" id="add_id" value="<?php echo e($right_add_id); ?>">
                                <?php echo $right_add_markup; ?>

                            </div>
                        </div>
                    </div>

                    <!-- proDescription -->
                    <div class="proDescription box-shadow1">
                        <!-- Top -->
                        <div class="descriptionTop">
                            <div class="row gy-4">
                                <?php if(!empty($listing->condition)): ?>
                                <div class="col-4">
                                    <?php echo e(__('Condition:')); ?> <span class="text-bold"> <?php echo e($listing->condition); ?> </span>
                                </div>
                                <?php endif; ?>
                                <?php if(!empty($listing->authenticity)): ?>
                                <div class="col-4">
                                    <?php echo e(__('Authenticity:')); ?> <span class="text-bold"> <?php echo e($listing->authenticity); ?> </span>
                                </div>
                                <?php endif; ?>
                                <?php if(!empty($listing->brand)): ?>
                                    <div class="col-4">
                                        <?php echo e(__('Brand:')); ?> <span class="text-bold"><?php echo e($listing->brand?->title); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- attributes -->
                        <?php if($listing->listing_attributes->isNotEmpty()): ?>
                        <div class="descriptionTop">
                            <div class="row gy-4">
                                <h5 class="disTittle"> <?php echo e(get_static_option('listing_attribute_section_title') ?? __('Attributes')); ?> </h5>
                                <?php $__currentLoopData = $listing->listing_attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-4">
                                        <?php echo e($attribute->title); ?> <span class="text-bold"> <?php echo e($attribute->description); ?> </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>


                        <div class="devider"></div>
                        <!-- Mid -->
                        <div class="descriptionMid">
                            <h4 class="disTittle"><?php echo e(get_static_option('listing_description_title') ?? __('Description')); ?></h4>
                            <p class="pera" id="description"><?php echo Str::limit(str_replace('&nbsp;', ' ', strip_tags($listing->description)), 20000); ?></p>
                            <button id="showMoreButton" class="show-more-btn"><?php echo e(__('Show More')); ?></button>
                        </div>
                        <!-- Footer -->

                        <div class="descriptionFooter">
                            <h4 class="disTittle"><?php echo e(get_static_option('listing_tag_title') ?? __('Tags')); ?></h4>
                            <?php if(isset($listing->tags) && count($listing->tags) > 0): ?>
                                <?php if(!empty($listing->tags)): ?>
                                    <div class="tags">
                                        <form id="filter_with_listing_page_tag" action="<?php echo e(url(get_static_option('listing_filter_page_url') ?? '/listings')); ?>" method="get">
                                            <input type="hidden" name="tag_id" id="tag_id" value="" />
                                            <?php $__currentLoopData = $listing->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="#" class="submit_form_listing_filter_tag" data-tag-id="<?php echo e($tag->id); ?>"><?php echo e($tag->name); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!--for mobile device user info -->
                    <div class="seller-part mt-3 d-md-none">
                        <?php if (isset($component)) { $__componentOriginal2ba418b9da4fcd4a34a66694deaceae8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ba418b9da4fcd4a34a66694deaceae8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.user-listing-phone-for-responsive','data' => ['listing' => $listing]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.user-listing-phone-for-responsive'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ba418b9da4fcd4a34a66694deaceae8)): ?>
<?php $attributes = $__attributesOriginal2ba418b9da4fcd4a34a66694deaceae8; ?>
<?php unset($__attributesOriginal2ba418b9da4fcd4a34a66694deaceae8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ba418b9da4fcd4a34a66694deaceae8)): ?>
<?php $component = $__componentOriginal2ba418b9da4fcd4a34a66694deaceae8; ?>
<?php unset($__componentOriginal2ba418b9da4fcd4a34a66694deaceae8); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalf0bb86bd9624b0e75536001cbc881705 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0bb86bd9624b0e75536001cbc881705 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-details-page-user-info','data' => ['listing' => $listing,'userTotalListings' => $user_total_listings]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-details-page-user-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing),'userTotalListings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user_total_listings)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0bb86bd9624b0e75536001cbc881705)): ?>
<?php $attributes = $__attributesOriginalf0bb86bd9624b0e75536001cbc881705; ?>
<?php unset($__attributesOriginalf0bb86bd9624b0e75536001cbc881705); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0bb86bd9624b0e75536001cbc881705)): ?>
<?php $component = $__componentOriginalf0bb86bd9624b0e75536001cbc881705; ?>
<?php unset($__componentOriginalf0bb86bd9624b0e75536001cbc881705); ?>
<?php endif; ?>
                    </div>
                    <!--Relevant Ads-->
                    <?php echo $__env->make('frontend.pages.listings.relevant-listing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="seller-part">
                        <!--user info -->
                         <div class="d-none d-md-block">
                             <?php if (isset($component)) { $__componentOriginal21bbe37eea4f1ad1b015cea13499d16a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal21bbe37eea4f1ad1b015cea13499d16a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.user-listing-phone','data' => ['listing' => $listing]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.user-listing-phone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal21bbe37eea4f1ad1b015cea13499d16a)): ?>
<?php $attributes = $__attributesOriginal21bbe37eea4f1ad1b015cea13499d16a; ?>
<?php unset($__attributesOriginal21bbe37eea4f1ad1b015cea13499d16a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal21bbe37eea4f1ad1b015cea13499d16a)): ?>
<?php $component = $__componentOriginal21bbe37eea4f1ad1b015cea13499d16a; ?>
<?php unset($__componentOriginal21bbe37eea4f1ad1b015cea13499d16a); ?>
<?php endif; ?>
                             <?php if (isset($component)) { $__componentOriginalf0bb86bd9624b0e75536001cbc881705 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0bb86bd9624b0e75536001cbc881705 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-details-page-user-info','data' => ['listing' => $listing,'userTotalListings' => $user_total_listings]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-details-page-user-info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing),'userTotalListings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user_total_listings)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0bb86bd9624b0e75536001cbc881705)): ?>
<?php $attributes = $__attributesOriginalf0bb86bd9624b0e75536001cbc881705; ?>
<?php unset($__attributesOriginalf0bb86bd9624b0e75536001cbc881705); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0bb86bd9624b0e75536001cbc881705)): ?>
<?php $component = $__componentOriginalf0bb86bd9624b0e75536001cbc881705; ?>
<?php unset($__componentOriginalf0bb86bd9624b0e75536001cbc881705); ?>
<?php endif; ?>
                         </div>
                        <!--Adds left-->
                        <?php if(get_static_option('google_adsense_status') == 'on'): ?>
                            <div class="googleAdd-wraper">
                                <div class="add">
                                    <div class="text-<?php echo e($custom_container); ?> single-banner-ads ads-banner-box" id="home_advertisement_store">
                                        <input type="hidden" id="add_id" value="<?php echo e($add_id); ?>">
                                        <?php echo $add_markup; ?>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(get_static_option('safety_tips_info') !== null): ?>
                            <div class="safety-tips">
                                <h3 class="head5"><?php echo e(get_static_option('listing_safety_tips_title') ?? __('Safety Tips')); ?></h3>
                                <div class="safety-wraper">
                                    <?php echo get_static_option('safety_tips_info'); ?>

                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="share-on-wraper">
                            <div class="d-flex gap-3 align-items-center mb-3">
                                <div class="text-center w-50 report-btn listing-details-page-favorite">
                                    <?php if (isset($component)) { $__componentOriginal3dfd35d741f1194aaa8a383da050a48b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3dfd35d741f1194aaa8a383da050a48b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.favorite-item-add-remove-for-details-page','data' => ['favorite' => $listing->id ?? 0]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.favorite-item-add-remove-for-details-page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['favorite' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing->id ?? 0)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3dfd35d741f1194aaa8a383da050a48b)): ?>
<?php $attributes = $__attributesOriginal3dfd35d741f1194aaa8a383da050a48b; ?>
<?php unset($__attributesOriginal3dfd35d741f1194aaa8a383da050a48b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3dfd35d741f1194aaa8a383da050a48b)): ?>
<?php $component = $__componentOriginal3dfd35d741f1194aaa8a383da050a48b; ?>
<?php unset($__componentOriginal3dfd35d741f1194aaa8a383da050a48b); ?>
<?php endif; ?>
                                </div>
                                <div class="report-btn w-50 text-center">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#reportModal">
                                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 10H15L10.5 5.5L15 1H1V17" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span id="addReportModal"><?php echo e(__('Report')); ?></span>
                                    </a>
                                </div>
                            </div>

                            <div class="share-on">
                                <span class="social-icons">
                                     <?php
                                         $image_url = get_attachment_image_by_id($listing->image);
                                         $img_url = $image_url['img_url'] ?? '';
                                     ?>
                                    <?php echo single_post_share(route('frontend.listing.details',$listing->slug), $listing->title, $img_url); ?>

                                </span>
                            </div>
                        </div>

                        <?php echo $__env->make('frontend.pages.listings.frontend-business-hours', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('frontend.pages.listings.frontend-enquiry-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="map-wraper box-shadow1">
                            <h3 class="head5"><?php echo e(__('Map')); ?></h3>
                            <p><?php echo e($listing->address); ?></p>
                            <div class="map">
                                <?php if(!empty(get_static_option("google_map_settings_on_off"))): ?>
                                    <div id="single-map-canvas" style="height: 230px; width: 100%; position: relative; overflow: hidden;">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if(!empty($listing->video_url)): ?>
                            <div class="map-wraper box-shadow1">
                                <h3 class="head5"><?php echo e(__('Video')); ?></h3>
                                <iframe width="700" height="370"
                                        src="<?php echo e('https://www.youtube.com/embed/' . $listing->video_url); ?>"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('frontend.pages.listings.listing-report-add-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if (isset($component)) { $__componentOriginal964501a75ad6a8827e19b34c3befa121 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal964501a75ad6a8827e19b34c3befa121 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.login','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.login'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal964501a75ad6a8827e19b34c3befa121)): ?>
<?php $attributes = $__attributesOriginal964501a75ad6a8827e19b34c3befa121; ?>
<?php unset($__attributesOriginal964501a75ad6a8827e19b34c3befa121); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal964501a75ad6a8827e19b34c3befa121)): ?>
<?php $component = $__componentOriginal964501a75ad6a8827e19b34c3befa121; ?>
<?php unset($__componentOriginal964501a75ad6a8827e19b34c3befa121); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php if(!empty(get_static_option('google_map_settings_on_off'))): ?>
    <?php if (isset($component)) { $__componentOriginal3e936750d9b778705f3e18f41b1357de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e936750d9b778705f3e18f41b1357de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.map.google-map-listing-details-page-js','data' => ['lat' => $listing->lat ?? 0,'lon' => $listing->lon ?? 0]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('map.google-map-listing-details-page-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['lat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing->lat ?? 0),'lon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing->lon ?? 0)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e936750d9b778705f3e18f41b1357de)): ?>
<?php $attributes = $__attributesOriginal3e936750d9b778705f3e18f41b1357de; ?>
<?php unset($__attributesOriginal3e936750d9b778705f3e18f41b1357de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e936750d9b778705f3e18f41b1357de)): ?>
<?php $component = $__componentOriginal3e936750d9b778705f3e18f41b1357de; ?>
<?php unset($__componentOriginal3e936750d9b778705f3e18f41b1357de); ?>
<?php endif; ?>
<?php endif; ?>
<?php if($user_enquiry_form === true): ?>
    <?php if (isset($component)) { $__componentOriginalcce2eb7d32c2bdd3ff8383067f270fb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcce2eb7d32c2bdd3ff8383067f270fb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.enquiry-form-submit-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.enquiry-form-submit-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcce2eb7d32c2bdd3ff8383067f270fb4)): ?>
<?php $attributes = $__attributesOriginalcce2eb7d32c2bdd3ff8383067f270fb4; ?>
<?php unset($__attributesOriginalcce2eb7d32c2bdd3ff8383067f270fb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcce2eb7d32c2bdd3ff8383067f270fb4)): ?>
<?php $component = $__componentOriginalcce2eb7d32c2bdd3ff8383067f270fb4; ?>
<?php unset($__componentOriginalcce2eb7d32c2bdd3ff8383067f270fb4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginal2722c5bff683d0b160c99671b96c7145 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2722c5bff683d0b160c99671b96c7145 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-report-add-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-report-add-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2722c5bff683d0b160c99671b96c7145)): ?>
<?php $attributes = $__attributesOriginal2722c5bff683d0b160c99671b96c7145; ?>
<?php unset($__attributesOriginal2722c5bff683d0b160c99671b96c7145); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2722c5bff683d0b160c99671b96c7145)): ?>
<?php $component = $__componentOriginal2722c5bff683d0b160c99671b96c7145; ?>
<?php unset($__componentOriginal2722c5bff683d0b160c99671b96c7145); ?>
<?php endif; ?>
<script src="<?php echo e(asset('assets/frontend/js/jquery.magnific-popup.min.js')); ?>"></script>
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){

                // Initialize Magnific Popup
                $('.image-link').magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        easing: 'ease-in-out'
                    }
                });


                let page = 1;
                $(document).on('click', '#load-more-ads', function() {
                    page++;
                    let listingId = $(this).data('listing-id');
                    $.ajax({
                        url: "<?php echo e(route('frontend.listing.load-more-relevant')); ?>",
                        type: "POST",
                        data: {
                            page: page,
                            listing_id: listingId
                        },
                        success: function(response) {
                            if (response.html) {
                                $('.relevant-listing-wrapper').append(response.html);
                            }

                            // Check if total relevant items is 0
                            if (response.total_relevant_items === 0) {
                                $('#load-more-ads').prop('disabled', true); // Disable the button
                                $('#load-more-ads').hide(); // hide the button
                            } else {
                                $('#load-more-ads').prop('disabled', false); // Enable the button
                            }

                        },
                        error: function(xhr) {
                        }
                    });
                });


                // Toggle for business hour
                $(".hours-wraper").slideToggle(300);
                $(".business-hour .business-head").on('click', function(){
                    $(".hours-wraper").slideToggle(300)
                });

                $(".enquiry-wraper").show();
                $(".enquiry-hour .enquiry-head").on('click', function() {
                    $(".enquiry-wraper").slideToggle(300);
                });

                let description = document.getElementById('description');
                let showMoreButton = document.getElementById('showMoreButton');
                $('#showMoreButton').show();
                let isExpanded = false;
                let originalContent = description.textContent;
                if (description.textContent.length > 700) {
                    description.textContent = description.textContent.substring(0, 700) + '...';
                }else {
                    $('#showMoreButton').hide();
                }
                showMoreButton.addEventListener('click', function() {
                    if (!isExpanded) {
                        description.textContent = originalContent;
                        showMoreButton.textContent = 'Show Less';
                    } else {
                        description.textContent = description.textContent.substring(0, 700) + '...';
                        showMoreButton.textContent = 'Show More';
                    }
                    isExpanded = !isExpanded;
                });


                // for web
                $('#phoneNumber').hide();
                $('#default_phone_number_show').show;
                $('.show-number').show();
                $(document).on('click', '#userPhoneNumberBtn', function(event) {
                    event.preventDefault();
                    $('#default_phone_number_show').hide();
                    $('#phoneNumber').show();
                    $('.show-number').hide();
                });

                // for mobile responsive
                $('#phoneNumberForResponsive').hide();
                $('#default_phone_number_show_for_responsive').show();
                $(document).on('click', '#userPhoneNumberBtnForResponsive', function(event) {
                    event.preventDefault();
                    $('#default_phone_number_show_for_responsive').hide();
                    $('#phoneNumberForResponsive').show();
                    $('.show-number').hide();
                });

                // for mobile responsive with call to number
                $(document).on('click', '#phoneNumberForResponsive', function(event) {
                    event.preventDefault();
                    let phoneNumber = $('#phoneNumber').text().trim();
                    let tempLink = document.createElement('a');
                    tempLink.href = 'tel:' + phoneNumber;
                    document.body.appendChild(tempLink);
                    tempLink.trigger('click');
                    document.body.removeChild(tempLink);
                });

            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/pages/listings/listing-details.blade.php ENDPATH**/ ?>