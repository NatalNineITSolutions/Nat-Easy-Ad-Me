<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">
    <style>
        /*loader css start */
        .all_location_new_btn.btn-primary {
            background-color: var(--main-color-one);
            border-color: var(--main-color-one);
        }
        .loader-container {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        #map-container {
            display: none; /* Initially hide the map container */
        }
        /*loader css end */

        /* new ======================*/
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
        .slider-kilometer .slider-range {
            height: 8px;
            background: #ddd;
        }
        .noUi-handle:after,
        .noUi-handle:before {
            display: none;
        }
        .noUi-touch-area {
            height: 100%;
            width: 100%;
            background: var(--main-color-one);
            border-radius: 50%;
        }
        .noUi-pips-horizontal {
            padding: 10px 0;
            height: 80px;
            top: 100%;
            left: 0;
            width: 100%;
            visibility: hidden;
            opacity: 0;
        }
        .noUi-connect {
            background: gray;
        }
        .noUi-horizontal .noUi-handle {
            width: 20px;
            height: 20px;
            right: -10px;
            top: -6px;
            border-radius: 50%;
        }
        .range-input{
            position: relative;
        }
        .range-input input{
            position: absolute;
            width: 100%;
            height: 5px;
            top: -5px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        input[type="range"]::-webkit-slider-thumb{
            height: 17px;
            width: 17px;
            border-radius: 50%;
            background: #17A2B8;
            pointer-events: auto;
            -webkit-appearance: none;
            box-shadow: 0 0 6px rgba(0,0,0,0.05);
        }
        input[type="range"]::-moz-range-thumb{
            height: 17px;
            width: 17px;
            border: none;
            border-radius: 50%;
            background: #17A2B8;
            pointer-events: auto;
            -moz-appearance: none;
            box-shadow: 0 0 6px rgba(0,0,0,0.05);
        }

        .singleFeatureCard.inside_google_map_card {
            max-width: 200px !important;
            height: 181px !important;
        }

        .singleFeatureCard.inside_google_map_card .main-card-image {
            height: 111px!important;
        }

        .new-style .singleFeatureCard.inside_google_map_card .featurebody {
            height: auto!important;
        }

    </style>
<?php $__env->stopSection(); ?>
<div class="all-listing" data-padding-top="<?php echo e($padding_top); ?>" data-padding-bottom="<?php echo e($padding_bottom); ?>">
    <div class="container-1920 plr1">
        <!--Sidebar Icon-->
        <div class="sidebar-btn d-none">
            <a href="javascript:void(0)"><i class="las la-bars"></i></a>
        </div>

        <form method="get" action="<?php echo e($current_page_url); ?>" id="search_listings_form">
            <input type="hidden" name="listing_grid_and_list_view" id="listing_grid_and_list_view">
            <input type="hidden" name="date_posted_listing" id="date_posted_listing">
            <input type="hidden" name="listing_condition" id="listing_condition">
            <input type="hidden" name="listing_type_preferences" id="listing_type_preferences">

            <div class="catabody-wraper">
                <!-- Left Content -->
                <div class="cateLeftContent">
                    <div class="cateSidebar1">

                        <!--Search any title filter start -->
                        <?php if(!empty($listing_search_by_text_on_off)): ?>
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories w-100">
                                    <div class="single-category-service">
                                        <div class="single-select">
                                            <input type="text" class="search-input form-control" id="search_by_query"
                                                   placeholder="<?php echo e($search_placeholder); ?>" name="q" value="<?php echo e($text_search_value); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--Search any title filter end -->

                        <!--Distance google map filter -->
                        <?php if(!empty($location_on_off)): ?>
                            <?php if(!empty(get_static_option("google_map_settings_on_off"))): ?>
                                <div class="catagoriesWraper mb-4">
                                    <div class="catagories w-100">
                                            <!-- autocomplete address -->
                                            <div class="suburb_section_start">
                                                <input type="hidden" name="autocomplete_address" id="autocomplete_address">
                                                <input type="hidden" name="location_city_name" id="location_city_name">
                                                <input type="hidden" name="latitude" id="latitude">
                                                <input type="hidden" name="longitude" id="longitude">
                                                <label class="cateTitle mb-2"><?php echo e(__('Location')); ?></label>
                                                <input class="search-input form-control w-100 border-1 bg-white autocomplete_disable" name="autocomplete" id="autocomplete" placeholder="<?php echo e(__('Enter a Location')); ?>" type="text">
                                            </div>

                                            <!-- Distance range-->
                                            <div id="distance-slider"></div>
                                            <div class="slider-container slider-kilometer">
                                                <input type="hidden" name="distance_kilometers_value" id="distance_kilometers_value">
                                                <div class="cateTitle mb-2"><?php echo e(__('Distance')); ?></div>
                                                <div id="slider" class="slider-range mt-2"></div>
                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    <div id="slider-value" class="slider-range-value"></div>
                                                    <span class="km_title_text"><?php echo e(__('km')); ?></span>
                                                </div>
                                            </div>

                                            <!-- cancel and apply button start -->
                                            <div class="cancel_apply_section_start text-end mb-2">
                                                <button type="button" class="filter-btn w-100" id="distance_wise_filter_apply"><?php echo e(__('Filter')); ?></button>
                                            </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!--google map Distance filter end -->

                        <!-- All Categories -->
                        <div class="catagoriesWraper mb-4">
                            <?php if(!empty($category_on_off)): ?>
                                <div class="catagories w-100">
                                    <select id="search_by_category" name="cat" class="categorySelect">
                                        <option value=""><?php echo e($category_text); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if(!empty(request()->get("cat")) && request()->get("cat") == $cat->id): ?> selected <?php endif; ?> value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                           <?php if(!empty($subcategory_on_off)): ?>
                                <div class="catagories w-100">
                                    <select id="search_by_subcategory" name="subcat" class="categorySelect">
                                        <option value=""><?php echo e($subcategory_text); ?></option>
                                        <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if(!empty(request()->get("subcat")) && request()->get("subcat") == $sub_cat->id): ?> selected <?php endif; ?> value="<?php echo e($sub_cat->id); ?>"><?php echo e($sub_cat->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                             <?php endif; ?>
                           <?php if(!empty($child_category_on_off)): ?>
                                <div class="catagories">
                                    <select id="search_by_child_category" name="child_cat" class="categorySelect">
                                        <option value=""><?php echo e($child_category_text); ?></option>
                                        <?php $__currentLoopData = $child_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if(!empty(request()->get("child_cat")) &&  request()->get("child_cat") == $child_cat->id): ?> selected <?php endif; ?> value="<?php echo e($child_cat->id); ?>"><?php echo e($child_cat->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                             <?php endif; ?>
                        </div>

                        <!-- Location -->
                        <?php if(empty(get_static_option("google_map_settings_on_off"))): ?>
                            <div class="locaton catagoriesWraper mb-4">
                                    <?php if(!empty($country_on_off)): ?>
                                    <div class="catagories">
                                        <select id="search_by_country" name="country" class="categorySelect">
                                            <option value=""><?php echo e($country_text); ?></option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cont): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if(!empty(request()->get("country")) && request()->get("country") == $cont->id ): ?> selected <?php endif; ?>  value="<?php echo e($cont->id); ?>"><?php echo e($cont->country); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(empty(get_static_option("google_map_settings_on_off"))): ?>
                                    <?php if(!empty($state_on_off)): ?>
                                            <?php  $fetch_cities = '';  ?>
                                            <?php if($country_on_off !== "on"): ?>
                                                <?php
                                                    $get_listing_state_id = $all_listings->pluck('city_id');
                                                     $all_sates = \Modules\CountryManage\app\Models\City::whereIn("id", $get_listing_state_id)->where("status", 1)->get();
                                                     foreach ($all_sates as $states) {
                                                         $fetch_cities .=  "<option selected value=" .  $states->id .   ">" . $states->city .  "</option>";
                                                     }
                                                ?>
                                            <?php endif; ?>
                                        <div class="catagories">
                                            <select id="search_by_state" name="state">
                                                <option value=""> <?php echo e($state_text); ?></option>
                                                <?php $__currentLoopData = $listings_state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing_state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> {
                                                    <option <?php if(!empty(request()->get("state")) && request()->get("state") == $listing_state->id): ?> selected <?php endif; ?>
                                                    value="<?php echo e($listing_state->id); ?>"><?php echo e($listing_state->state); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($fetch_cities); ?>

                                            </select>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(empty(get_static_option("google_map_settings_on_off"))): ?>
                                    <?php if(!empty($city_on_off)): ?>
                                        <div class="catagories">
                                            <select id="search_by_city" name="city">
                                                <option value=""> <?php echo e($city_text); ?></option>
                                                <?php $__currentLoopData = $listings_city; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing_city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> {
                                                    <option <?php if(!empty(request()->get("city")) && request()->get("city") == $listing_city->id): ?> selected <?php endif; ?>
                                                    value="<?php echo e($listing_city->id); ?>"><?php echo e($listing_city->city); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($fetch_cities ?? 0); ?>

                                            </select>
                                        </div>
                               <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!--price range filter -->
                        <?php if(!empty($price_range_on_off)): ?>
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories priceRange">
                                    <h5 class="cateTitle mb-2 postdateTitle"><?php echo e(__('Price Range')); ?></h5>
                                    <input type="hidden" name="price_range_value" id="price_range_value">
                                    <div class="price-input">
                                        <div class="field">
                                            <div class="min_price_range priceRangeWraper">
                                                <span class="site_currency_symbol"><?php echo e(site_currency_symbol()); ?></span>
                                                <input type="number" class="input-min">
                                            </div>
                                        </div>
                                        <div class="separator">-</div>
                                        <div class="field">
                                            <div class="max_price_range priceRangeWraper">
                                                <span class="site_currency_symbol"><?php echo e(site_currency_symbol()); ?></span>
                                                <input type="number" class="input-max">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price_range_setup">
                                        <div class="progress"></div>
                                    </div>
                                    <!-- cancel and apply button start -->
                                    <div class="cancel_apply_section_start mt-3">
                                        <button type="button" class="filter-btn w-100" id="price_wise_filter_apply"><?php echo e(__('Filter')); ?></button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--price range filter end -->

                        <?php if(!empty($listing_type_preferences)): ?>
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle"><?php echo e($listing_type_preferences_title); ?></h5>
                                    <ul class="postdate">
                                        <li <?php if($listing_type_preferences_value == 'featured'): ?> class="active" <?php endif; ?>><a href="javascript:void(0)" id="featured"><?php echo e(__('Featured')); ?></a></li>
                                        <li <?php if($listing_type_preferences_value == 'top_listing'): ?> class="active" <?php endif; ?>><a href="javascript:void(0)" id="top_listing"><?php echo e(__('Top Listing')); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($listing_condition)): ?>
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle"><?php echo e($listing_condition_title); ?></h5>
                                    <ul class="postdate">
                                        <li <?php if($listing_condition_value == 'new'): ?> class="active" <?php endif; ?>><a href="javascript:void(0)" id="new"><?php echo e(__('New')); ?></a></li>
                                        <li <?php if($listing_condition_value == 'used'): ?> class="active" <?php endif; ?>><a href="javascript:void(0)" id="used"><?php echo e(__('Used')); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($date_posted)): ?>
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle"><?php echo e($date_posted_title); ?></h5>
                                    <ul class="postdate">
                                        <li <?php if($date_posted_value == 'today'): ?> class="active" <?php endif; ?>><a href="javascript:void(0)" id="today"><?php echo e(__('Today')); ?></a></li>
                                        <li <?php if($date_posted_value == 'yesterday'): ?> class="active" <?php endif; ?>><a href="javascript:void(0)" id="yesterday"><?php echo e(__('Yesterday')); ?></a></li>
                                        <li <?php if($date_posted_value == 'last_week'): ?> class="active" <?php endif; ?>><a href="javascript:void(0)" id="last_week"><?php echo e(__('Last Week')); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Sort-by filter start -->
                        <?php if(!empty($sort_by_on_off)): ?>
                            <div class="catagoriesWraper px-0">
                                <div class="catagories mx-3">
                                    <select id="search_by_sorting" name="sortby">
                                        <option value=""><?php echo e(__("Sort By")); ?></option>
                                        <?php $__currentLoopData = $sortby_search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if(!empty(request()->get("sortby")) && request()->get("sortby") == $value): ?> selected <?php endif; ?> value="<?php echo e($value); ?>"><?php echo e($text); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- Right Content -->
                <div class="cateRightContent <?php if(!empty(get_static_option('google_map_settings_on_off'))): ?> active-map <?php endif; ?> ">

                    <!-- loader -->
                    <div id="loader" class="loader"> </div>

                    <div class="cateRightContentWraper">
                        <div class="content-part">
                            <div class="viewItems">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="SearchWrapper d-flex justify-content-between align-items-start">
                                            <!-- Custom Tab -->
                                            <div class="views align-items-center">
                                                <div class="sidebar-btn d-lg-none d-block">
                                                    <a href="javascript:void(0)"><i class="fa-solid fa-bars"></i></a>
                                                </div>
                                                <div class="reset-btn cmn-filter-btn">
                                                    <a href="<?php echo e(url()->current()); ?>">
                                                        <button type="button">
                                                            <i class="las la-undo-alt"></i> <?php echo e(__('Reset Filter')); ?>

                                                        </button>
                                                    </a>
                                                </div>
                                                <div class="listing-btn">
                                                    <button class="customTab <?php if($listing_grid_and_list_view == 'grid'): ?> active <?php endif; ?>" data-toggle-target=".customTab-content-1" id="card_grid">
                                                        <i class="las la-th-large fs-4"></i>
                                                    </button>
                                                    <button class="customTab <?php if($listing_grid_and_list_view == 'list'): ?> active <?php endif; ?>" data-toggle-target=".customTab-content-2" id="card_list">
                                                        <i class="las la-th-list fs-4"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Grid View -->
                            <?php if($listing_grid_and_list_view == 'grid'): ?>
                                <div class="gridView customTab-content customTab-content-1 <?php if($listing_grid_and_list_view == 'grid'): ?> active <?php endif; ?>">
                                    <div class="gridViews">
                                        <div class="singleFeatureCardWraper d-flex">
                                            <?php if (isset($component)) { $__componentOriginal5d6be7b7c18d78de17591c73d7917c83 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d6be7b7c18d78de17591c73d7917c83 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-single','data' => ['listings' => $all_listings]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-single'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($all_listings)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d6be7b7c18d78de17591c73d7917c83)): ?>
<?php $attributes = $__attributesOriginal5d6be7b7c18d78de17591c73d7917c83; ?>
<?php unset($__attributesOriginal5d6be7b7c18d78de17591c73d7917c83); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d6be7b7c18d78de17591c73d7917c83)): ?>
<?php $component = $__componentOriginal5d6be7b7c18d78de17591c73d7917c83; ?>
<?php unset($__componentOriginal5d6be7b7c18d78de17591c73d7917c83); ?>
<?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- List View -->
                            <?php if($listing_grid_and_list_view == 'list'): ?>
                               <div class="listingView customTab-content customTab-content-2 <?php if($listing_grid_and_list_view == 'list'): ?> active <?php endif; ?>">
                                <div class="singleFeatureCardWraper d-flex">
                                    <?php if (isset($component)) { $__componentOriginalb6539d82a33f5d27d4ce1be9ef6b85ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb6539d82a33f5d27d4ce1be9ef6b85ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.listing-single-list-view','data' => ['listings' => $all_listings]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.listing-single-list-view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($all_listings)]); ?>
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
                             <?php endif; ?>

                        </div>

                        <!--Google Map-->
                        <?php if($listing_grid_and_list_view == 'grid' || $listing_grid_and_list_view == 'list'): ?>
                                <?php if(!empty(get_static_option("google_map_settings_on_off"))): ?>
                                <?php if($all_listings->count() > 0): ?>
                                    <div class="googleWraper mt-70">
                                        <!-- loader -->
                                        <div class="loader-container">
                                            <div class="loader"></div>
                                        </div>
                                        <!--google map section start -->
                                        <div class="service-locationMap" id="map-container">
                                            <div class="fullwidth-sidebar-container">
                                                <div class="sidebar top-sidebar">
                                                    <div id="map-canvas" class="map-canvas"  style="height: 700px; width: 450px; position: relative; overflow: hidden;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="pagination mt-60">
                                <?php if($all_listings->count() > 0): ?>
                                    <div class="blog-pagination">
                                        <div class="custom-pagination mt-4 mt-lg-5">
                                            <?php echo $all_listings->links(); ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->startSection('scripts'); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>
    <?php if(!empty(get_static_option("google_map_settings_on_off"))): ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($google_api_key); ?>&libraries=places">
        <script defer src="//cdn.jsdelivr.net/npm/markerclustererplus/dist/markerclusterer.min.js"> </script>
        <script>
            // Wait for the page to fully load
            window.addEventListener('load', function() {
                var loaderContainer = document.querySelector('.loader-container');
                var mapContainer = document.getElementById('map-container');
                loaderContainer.style.display = 'none';
                mapContainer.style.display = 'block';
            });

            // Google map html markup show section
            function generateContent(place){
                  var content = `<div class="singleFeatureCard inside_google_map_card w-100">
                                    <div class="featureImg">
                                           <a href=\"<?php echo e($listing_details_route); ?>/`+place.slug+`\" class="main-card-image">
                                             `+place.image_url+`
                                           </a>
                                    </div>
                                    <div class="featurebody">
                                         <div class="btn-wrapper">
                                                 `+place.is_featured_item+`
                                         </div>
                                          <h4>
                                              <a href=\"<?php echo e($listing_details_route); ?>/`+place.slug+`\" title=\"View: `+place.title+`\" class="featureTittle head4 twoLine">
                                                   `+place.title+`
                                              </a>
                                           </h4>
                                           <span class="featurePricing d-flex justify-content-between align-items-center">
                                           <span class="money">`+place.listing_main_price+`</span>
                                           <span class="date">`+place.listing_published_at+`</span>
                                          </span>
                                    </div>
                                </div>`;
                return content;
            }

            var map;
            var markers = [];
            var infowindow = new google.maps.InfoWindow();
            var places = <?php echo json_encode($all_listings_list_json, 15, 512) ?>;

            // first check lat, long if lat long not empty map initialize play
            var latitude;
            var longitude;

            <?php if(!empty($latitude) && !empty($longitude)): ?>
                latitude = '<?php echo e($latitude); ?>'
                longitude = '<?php echo e($latitude); ?>'
                // local storage
                if(latitude !== null && longitude !== null) {
                    localStorage.setItem('latitude', latitude);
                    localStorage.setItem('longitude', longitude);
                }
            <?php else: ?>
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    // local storage
                    localStorage.setItem('latitude', latitude);
                    localStorage.setItem('longitude', longitude);
                }, function (error) {
                    console.error('Error getting location:', error);
                    // Set default values in case of an error
                    latitude = 0;
                    longitude = 0;
                });
            }
                latitude = localStorage.getItem('latitude');
                longitude = localStorage.getItem('longitude');
                // $('#latitude').val(latitude)
                // $('#longitude').val(longitude)

            <?php endif; ?>
            var centerLatLng = new google.maps.LatLng(latitude, longitude);
            function initialize() {
                var mapOptions = {
                    zoom: 6,
                    minZoom: 2,
                    maxZoom: 14,
                    zoomControl: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.DEFAULT
                    },
                    center: centerLatLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: true,
                    panControl: true,
                    mapTypeControl: true,
                    scaleControl: true,
                    overviewMapControl: true,
                    rotateControl: true,
                };
                map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                // all markers show this map
                addMarkers();
                initializeRangeSlider();
            }

            google.maps.event.addDomListener(window, 'load', initialize);
            function addMarkers() {
                var min = 0.999999;
                var max = 1.000001;

                for (var place in places) {
                    place = places[place];
                    if (place.lat !== null) {
                        var google_maker_icon = "<?php echo e(isset($google_map_maker_icon) ? $google_map_maker_icon : 'https://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_red.png'); ?>";
                        var image = new google.maps.MarkerImage(google_maker_icon, null, null, null, new google.maps.Size(40, 52));

                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(
                                place.lat * (Math.random() * (max - min) + min),
                                place.lon * (Math.random() * (max - min) + min)
                            ),
                            map: map,
                            title: place.title,
                            icon: image,
                        });

                        markers.push(marker);
                        google.maps.event.addListener(marker, 'click', (function (marker, place) {
                            return function () {
                                toggleMarkerAnimation(marker);
                                infowindow.setContent(generateContent(place));
                                infowindow.open(map, marker);
                                smoothZoomIn(map, marker, 12, 1000);
                            };

                        })(marker, place));
                    }
                }
            }

            // Smooth zoom-in animation centered on a marker
            function smoothZoomIn(map, marker, zoomLevel, duration) {
                var currentZoom = map.getZoom();
                var targetZoom = Math.min(zoomLevel, map.maxZoom);
                var step = 1;
                var delay = Math.round(duration / (targetZoom - currentZoom));

                // Recursively increase the zoom level
                function zoom() {
                    if (currentZoom < targetZoom) {
                        currentZoom += step;
                        map.setZoom(currentZoom);
                        setTimeout(zoom, delay);
                    } else {
                        map.panTo(marker.getPosition());
                    }
                }
                zoom();
            }

            // Function to toggle marker animation
            function toggleMarkerAnimation(marker) {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(function() {
                        marker.setAnimation(null);
                    }, 3000); // Stop animation after 3 seconds
                }
            }


            <?php if(!empty($location_on_off)): ?>
            function initializeRangeSlider() {
                var slider = document.getElementById('slider');
                var sliderValue = document.getElementById('slider-value');

                noUiSlider.create(slider, {
                    start: <?php echo e(!empty($radius) ? $radius : 50); ?>,
                    range: {
                        'min': 1,
                        'max': 150
                    }
                });

                slider.noUiSlider.on('update', function (values) {
                    var newValue = Math.round(values[0]);
                    sliderValue.innerHTML = newValue;
                });
            }
        <?php else: ?>
              function initializeRangeSlider(){ return '' };
        <?php endif; ?>
          </script>

        <script>
            (function($){
                "use strict";
                $(document).ready(function(){

                    <?php if($all_listings->count() === 0): ?>
                      initializeRangeSlider();
                    <?php endif; ?>

                    //========google map autocomplete address start
                    // Initialize Google Places autocomplete
                    var input = document.getElementById('autocomplete');
                    var countryCodesStr = "<?php echo e($countryCodesStr); ?>";
                    var allCountryCodes = countryCodesStr.split(',');
                    var autocompleteOptions = {
                        types: ['(regions)'],
                        componentRestrictions: {
                            country: allCountryCodes
                        }
                    };

                    // Initialize the autocomplete with the options
                    var autocomplete = new google.maps.places.Autocomplete(
                        document.getElementById('autocomplete'),
                        autocompleteOptions
                    );

                    // Get current location name and lat/long
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;

                        // Reverse geocode to get location name
                        var geocoder = new google.maps.Geocoder();
                        var latlng = new google.maps.LatLng(lat, lng);

                        geocoder.geocode({ 'location': latlng }, function(results, status) {
                            if (status === google.maps.GeocoderStatus.OK) {
                                if (results[0]) {
                                    // Extract city and division
                                    var addressComponents = results[0].address_components;
                                    var city = '';
                                    var division = '';

                                    for (var i = 0; i < addressComponents.length; i++) {
                                        var component = addressComponents[i];
                                        if (component.types.includes('locality')) {
                                            city = component.long_name;
                                        } else if (component.types.includes('administrative_area_level_1')) {
                                            division = component.long_name;
                                        }
                                    }

                                    // Format as "City, Division"
                                    var formattedLocation = city + ', ' + division;

                                    <?php if(!empty($location_city_name)): ?>
                                        var city_name_formatted_location = `<?php echo e($location_city_name); ?>`;
                                    <?php else: ?>
                                      var city_name_formatted_location = city;
                                    <?php endif; ?>

                                    // set address in input box current location
                                    <?php if(!empty($autocomplete_address)): ?>
                                        input.value = `<?php echo e($autocomplete_address); ?>`;
                                    <?php else: ?>
                                        input.value = formattedLocation;
                                    <?php endif; ?>

                                    if(formattedLocation){
                                        $('#location_city_name').val(city);

                                        $('#latitude').val(lat);
                                        $('#longitude').val(lng);
                                        // Set the filter title by combining the distance and formatted location
                                        var distance_set_default = `<?php echo e($distance_radius_km_get ?? 50); ?>`;
                                        $('.distance_wise_filter_title').text(`${distance_set_default}km ${city_name_formatted_location}`);
                                    }


                                } else {
                                    console.error('No results found');
                                }
                            } else {
                                console.error('Geocoder failed due to: ' + status);
                            }
                        });
                    });

                    // Autocomplete address get
                    autocomplete.addListener('place_changed', function() {
                        var place = autocomplete.getPlace();
                        if (!place.geometry) {
                            return;
                        }
                        var suburb = place.name;
                        var lat = place.geometry.location.lat();
                        var lng = place.geometry.location.lng();


                        var city_name = '';
                        for (var i = 0; i < place.address_components.length; i++) {
                            var component = place.address_components[i];
                            if (component.types.includes('locality')) {
                                city_name = component.long_name;
                                break;
                            }
                        }

                        // set lat long value
                        if(suburb){
                            $('#location_city_name').val(city_name);
                            $('#latitude').val(lat);
                            $('#longitude').val(lng);
                        }
                    });
                    //========== google map autocomplete address end

                    // set address in input box current location
                    <?php if(!empty($autocomplete_address)): ?>
                        var google_map_place_address = `<?php echo e($autocomplete_address); ?>`;
                        $('#autocomplete').val(google_map_place_address);
                    <?php endif; ?>


                    // google map distance, current location, autocomplete address wise filter jobs
                    $(document).on('click', '#distance_wise_filter_apply', function() {
                        let get_lan_value = $('#latitude').val();
                        let get_long_value = $('#longitude').val();
                        let distance_km_value = $('#slider-value').text();

                        $('#distance_kilometers_value').val(distance_km_value);
                        // get autocomplete address old value get
                        let get_autocomplete_value = $('#autocomplete').val();

                        $('#autocomplete_address').val(get_autocomplete_value);

                        // get price and set value
                        let left_value = $('.input-min').val();
                        let right_value = $('.input-max').val();
                        $('#price_range_value').val(left_value + ',' + right_value);

                        $('#search_listings_form').trigger('submit');
                    });

                });
            })(jQuery);
        </script>
      <?php endif; ?>

        <script>
            (function($){
                "use strict";
                $(document).ready(function(){
                    $(document).on('click', '#price_wise_filter_apply', function (){
                        let left_value = $('.input-min').val();
                        let right_value = $('.input-max').val();
                        $('#price_range_value').val(left_value + ',' + right_value);

                        // google map km set
                        let distance_km_value = $('#slider-value').text();
                        $('#distance_kilometers_value').val(distance_km_value);
                        let get_autocomplete_value = $('#autocomplete').val();
                        $('#autocomplete_address').val(get_autocomplete_value);

                        $('#search_listings_form').trigger('submit');
                    });
                });
            })(jQuery);
        </script>

    <?php if(!empty($price_range_on_off)): ?>
        <script>
            const rangeInput = document.querySelectorAll(".range-input input"),
                priceInput = document.querySelectorAll(".price-input input"),
                range = document.querySelector(".price_range_setup .progress");
            let priceGap = 10;

            var slider_price_div = document.querySelector('.price_range_setup .progress');
            var maxPriceValue = <?php echo e($max_price_start_value ?? 10000); ?>;
            noUiSlider.create(slider_price_div, {
                start: [<?php if(!empty($min_price)): ?> <?php echo e($min_price); ?> <?php else: ?> 1 <?php endif; ?>, <?php if(!empty($max_price)): ?> <?php echo e($max_price); ?> <?php else: ?> 10000 <?php endif; ?>],
                connect: true,
                range: {
                    'min': 1,
                    'max': maxPriceValue
                },
                pips: {
                    mode: 'steps',
                    stepped: true,
                    density: 4
                }
            });

            slider_price_div.noUiSlider.on('update', function (values) {
                $(".input-min").val(Math.round(values[0]));
                $(".input-max").val(Math.round(values[1]));
            });

            // INPUT
            priceInput.forEach(input => {
                input.addEventListener("input", e => {
                    let minPrice = parseInt(priceInput[0].value),
                        maxPrice = parseInt(priceInput[1].value);

                    if ((maxPrice - minPrice) >= priceGap && maxPrice <= slider_price_div.noUiSlider.options.range.max) {
                        if (e.target.className === "input-min") {
                            slider_price_div.noUiSlider.set([minPrice, null]);
                        } else {
                            slider_price_div.noUiSlider.set([null, maxPrice]);
                        }
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\laragon\www\easyadme\core\app\Providers/../../plugins/PageBuilder/views/listing/listing-one.blade.php ENDPATH**/ ?>