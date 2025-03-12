
<?php $__env->startSection('site_title'); ?>
    <?php echo e(__('Add Listing')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <?php if (isset($component)) { $__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.css','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.css'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa)): ?>
<?php $attributes = $__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa; ?>
<?php unset($__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa)): ?>
<?php $component = $__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa; ?>
<?php unset($__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginaldfdc73ee107e48d175ea9d298bebd7fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldfdc73ee107e48d175ea9d298bebd7fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.summernote.css','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('summernote.css'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldfdc73ee107e48d175ea9d298bebd7fa)): ?>
<?php $attributes = $__attributesOriginaldfdc73ee107e48d175ea9d298bebd7fa; ?>
<?php unset($__attributesOriginaldfdc73ee107e48d175ea9d298bebd7fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldfdc73ee107e48d175ea9d298bebd7fa)): ?>
<?php $component = $__componentOriginaldfdc73ee107e48d175ea9d298bebd7fa; ?>
<?php unset($__componentOriginaldfdc73ee107e48d175ea9d298bebd7fa); ?>
<?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/bootstrap-tagsinput.css')); ?>">
    <style>
        input#pac-input {
            background-color: ghostwhite;
        }
        .select2-container .select2-selection--single {
            background-color: var(--white-bg);
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            position: relative;
            height: auto;
            padding: 10px;
        }

        span.select2.select2-container.select2-container--default.select2-container--focus {
            width: 100% !important;
        }
        .select-itms span.select2{
            width: 100% !important;
        }


        .close{ border: none;  }
        .dashboard-switch-single{
            font-size: 20px;
        }
        .swal_delete_button{
            color: #da0000 !important;
        }
        /* Default styles for the input box */
        #pac-input {
            height: 3em;
            width:75%;
            margin-left: 140px;
            border: 1px solid;
            top: 4px;
            font-size: 16px;
        }

        /* Media query for screens smaller than 768px */
        @media (max-width: 1499px) {
            #pac-input {
                width: 100%;
                margin-left: 0;
            }
        }

        /*select tags start css*/
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e3e3e3;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #e3e3e3;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            font-size: 23px;
        }
        .select2-selection__choice__display {
            font-size: 15px;
            color: #000;
            font-weight: 400;
        }
        /*select tags end css*/

        /* price and number css start   */
        label.infoTitle.position-absolute {
            top: 0;
            background-color: whitesmoke;
            left: 0;
            padding: 10px 15px;
        }
        .checkBox.position-absolute {
            right: 0;
            top: 0;
            background-color: whitesmoke;
            padding: 10px 15px;
        }

        input.effectBorder.checkBox__input {
            border: 2px solid #a3a3a3;
        }
        /* price and number css end   */

        button.btn.btn-info.media_upload_form_btn {
            background-color: rgb(239,246,255);
            border: none;
            color: rgb(59,130,246);
            outline: none;
            box-shadow: none;
            margin: auto;
        }

        .new_image_add_listing .attachment-preview {
            width: 200px;
            height: 200px;
            border-radius: 6px;
            overflow: hidden;
        }
        .new_image_add_listing .attachment-preview .thumbnail .centered img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transform: translate(-50%, -50%);
        }

        .new_image_gallery_add_listing .attachment-preview {
            width: 100px;
            height: 100px;
            border-radius: 6px;
            overflow: hidden;
        }
        .new_image_gallery_add_listing .attachment-preview .thumbnail .centered img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transform: translate(-50%, -50%);
        }

        .media-upload-btn-wrapper .img-wrap .rmv-span {
            padding: 0;
        }
    </style>
    <?php if (isset($component)) { $__componentOriginal608d594b9dce739da0c20e58e107f1dd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal608d594b9dce739da0c20e58e107f1dd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.css.phone-number-css','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('css.phone-number-css'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal608d594b9dce739da0c20e58e107f1dd)): ?>
<?php $attributes = $__attributesOriginal608d594b9dce739da0c20e58e107f1dd; ?>
<?php unset($__attributesOriginal608d594b9dce739da0c20e58e107f1dd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal608d594b9dce739da0c20e58e107f1dd)): ?>
<?php $component = $__componentOriginal608d594b9dce739da0c20e58e107f1dd; ?>
<?php unset($__componentOriginal608d594b9dce739da0c20e58e107f1dd); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
        <div class="add-listing-wrapper mt-5 mb-5">
            <!--check user verification -->
            <?php if($user_listing_limit_check === true): ?>
                <div class="row w-50 align-items-center mx-auto">
                    <div class="col-lg-12 mt-1">
                        <div class="alert alert-warning d-flex justify-content-between">
                            <a href="<?php echo e(route('user.membership.all')); ?>">
                             <?php echo e(__('Your membership package listing limit has been reached. Please consider upgrading your membership to continue listing:')); ?>

                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!--Nav Bar Tabs markup start -->
            <div style="display: none" class="nav nav-pills" id="add-listing-tab"
                 role="tablist" aria-orientation="vertical">
                <a class="nav-link  stepIndicator active stepForm_btn__previous"
                   id="listing-info-tab"
                   data-bs-toggle="pill"
                   href="#listing-info"
                   role="tab"
                   aria-controls="listing-info"
                   aria-selected="true">
                    <span class="nav-link-number"><?php echo e(__('1')); ?></span>
                    <?php echo e(__('Listing Info')); ?>

                </a>

                <a class="nav-link  stepIndicator"
                   id="location-tab"
                   data-bs-toggle="pill"
                   href="#media-uploads"
                   role="tab"
                   aria-controls="media-uploads"
                   aria-selected="true">
                    <span class="nav-link-number"><?php echo e(__('2')); ?></span>
                    <?php echo e(__('Location')); ?>

                </a>
            </div>
            <form action="<?php echo e(route('guest.add.listing')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div  class="add-listing-content-wrapper">
                    <div class="tab-content add-listing-content" id="add-listing-tabContent">
                        <!-- listing Info start-->
                        <div  class="tab-pane fade step active show" id="listing-info" role="tabpanel" aria-labelledby="listing-info-tab">
                            <!--Post your add-->
                            <div class="post-your-add">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mt-3 mb-2">
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
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-lg-8">
                                            <div class="post-add-wraper">
                                                <div class="item-name box-shadow1 p-24">
                                                    <label for="item-name"><?php echo e(__('Item Name')); ?> <span class="text-danger">*</span> </label>
                                                    <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>" class="input-filed w-100" placeholder="<?php echo e(__('Item Name')); ?>">

                                                    <div class="input-form input-form2 permalink_label">
                                                        <label for="title" class="mt-4"> <?php echo e(__('Permalink')); ?>  <span class="text-danger">*</span>  </label>
                                                        <span id="slug_show" class="display-inline"></span>
                                                        <span id="slug_edit" class="display-inline">
                                                        <button class="btn btn-warning btn-sm slug_edit_button">  <i class="las la-edit"></i> </button>
                                                        <input class="listing_slug input-filed w-100"  name="slug" value="<?php echo e(old('slug')); ?>" id="slug" style="display: none" type="text">
                                                        <button class="red-btn btn-sm slug_update_button mt-2" style="display: none"><?php echo e(__('Update')); ?></button>
                                                    </span>
                                                    </div>

                                                </div>
                                                <div class="about-item box-shadow1 p-24 mt-4">
                                                    <h3 class="head4"><?php echo e(__('About Item')); ?></h3>
                                                    <div class="about-item-form">
                                                        <div class="row g-3 mt-3">
                                                            <div class="col-sm-4">
                                                                <div class="item-catagory-wraper">
                                                                    <label for="item-catagory"><?php echo e(__('Item Category')); ?> <span class="text-danger">*</span> </label>
                                                                    <select name="category_id" id="category" class="select-itms select2_activation">
                                                                        <option value=""><?php echo e(__('Select Category')); ?></option>
                                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="item-subcatagory-wraper">
                                                                    <label for="item-subcatagory"><?php echo e(__('Sub Category')); ?></label>
                                                                    <select  name="sub_category_id" id="subcategory" class="subcategory select2_activation">
                                                                        <option value=""><?php echo e(__('Select Sub Category')); ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="item-subcatagory-wraper">
                                                                    <label for="item-subcatagory"><?php echo e(__('Child Category')); ?> </label>
                                                                    <select  name="child_category_id" id="child_category" class="select2_activation">
                                                                        <option value=""><?php echo e(__('Select Child Category')); ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-sm-6">
                                                                <div class="item-condition-wraper input-filed p-24 mb-sm-0 mb-3">
                                                                    <input type="checkbox" class="custom-check-box" id="item-condition">
                                                                    <label for="item-condition"><?php echo e(__('This item has Condition')); ?></label>
                                                                    <div class="conditions condition_disable_enable mt-2">
                                                                        <label>
                                                                            <input type="radio" id="condition-1" name="condition" value="used" class="custom-radio-button radio_disable_color">
                                                                            <span><?php echo e(__('Used')); ?></span>
                                                                        </label>
                                                                        <label class="ms-3">
                                                                            <input type="radio" id="condition-2" name="condition" value="new" class="custom-radio-button radio_disable_color">
                                                                            <span><?php echo e(__('New')); ?></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="item-condition-wraper input-filed p-24">
                                                                    <input type="checkbox" class="custom-check-box" id="item-authenticity">
                                                                    <label for="item-authenticity"><?php echo e(__('This item has authenticity')); ?></label>
                                                                    <div class="conditions authenticity_disable_enable mt-2">
                                                                        <label>
                                                                            <input type="radio" id="authenticity-1" name="authenticity" value="original" class="custom-radio-button radio_disable_color">
                                                                            <span><?php echo e(__('Original')); ?></span>
                                                                        </label>
                                                                        <label class="ms-3">
                                                                            <input type="radio" id="authenticity-2" name="authenticity" value="refurbished" class="custom-radio-button radio_disable_color">
                                                                            <span><?php echo e(__('Refurbished')); ?></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <div class="brand">
                                                                    <label for="item-catagory"><?php echo e(__('Brand')); ?></label>
                                                                    <select name="brand_id" id="brand_id" class="select-itms select2_activation">
                                                                        <option value=""><?php echo e(__('Select Brand')); ?></option>
                                                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->title); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="attribute-box box-shadow1 p-24 mt-3">
                                                    <h3 class="head4 mb-3"><?php echo e(get_static_option('listing_attribute_section_title') ?? __('Attributes')); ?></h3>
                                                    <div id="attribute-container">
                                                        <!-- Initial Attribute Fields -->
                                                        <div class="attribute-item mb-3">
                                                            <label for="attributes_title" class="form-label"><?php echo e(__('Title')); ?> </label>
                                                            <input type="text" class="form-control mb-2" name="attributes_title[]" placeholder="<?php echo e(__('Enter title')); ?>">

                                                            <label for="attributes_description" class="form-label"><?php echo e(__('Description')); ?></label>
                                                            <input type="text" class="form-control" name="attributes_description[]" placeholder="<?php echo e(__('Enter description')); ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Add More Button -->
                                                    <button type="button" id="add-more-attributes" class="text-end red-btn w-10 d-block">
                                                        <i class="las la-plus-circle"></i><?php echo e(__('Add More')); ?>

                                                    </button>
                                                </div>

                                                <div class="description box-shadow1 p-24 mt-4">
                                                    <label for="description"><?php echo e(__('Description')); ?> <span class="text-danger">*</span> <span class="text-danger"><?php echo e(__('(minimum 150 characters.)')); ?></span> </label>
                                                    <textarea name="description" id="description" rows="6" class="input-filed w-100 textarea--form summernote" placeholder="<?php echo e(__('Enter a Description')); ?>"><?php echo e(old('description')); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="right-sidebar">
                                                <div class="box-shadow1 price p-24">
                                                    <div class="price-wraper">
                                                        <label for="price"><?php echo e(__('Price')); ?> <span class="text-danger">*</span> </label>
                                                        <input type="number" name="price" id="price" value="<?php echo e(old('price')); ?>" class="input-filed w-100 mb-3" placeholder="<?php echo e(__('0.00')); ?>">
                                                        <label class="negotiable">
                                                            <input type="checkbox" class="custom-check-box" name="negotiable" id="negotiable">
                                                            <span class="ms-2"><?php echo e(__('Negotiable')); ?></span>
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                    <label class="hide-number">
                                                        <input type="checkbox" class="custom-check-box" name="hide_phone_number" value="">
                                                        <span class="black-font"> <?php echo e(__('Hide My Phone Number')); ?></span>
                                                    </label>
                                                    <div class="input-group mt-3">
                                                        <input type="hidden" id="country-code" name="country_code">
                                                        <input class="input-filed w-100" type="tel" name="phone" value="<?php echo e(old('phone')); ?>" id="phone" placeholder="<?php echo e(__('Type Phone')); ?>">
                                                        <span id="phone_availability"></span>
                                                        <div class="d-none">
                                                            <span id="error-msg" class="hide"></span>
                                                            <p id="result" class="d-none"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="upload-img text-center mt-3">
                                                    <div class="media-upload-btn-wrapper">
                                                        <div class="img-wrap new_image_add_listing">
                                                            <img src="<?php echo e(asset('assets/common/img/listing_single_image.jpg')); ?>" alt="images" class="w-100">
                                                        </div>
                                                        <input type="hidden" name="image">
                                                        <button type="button" class="btn btn-info media_upload_form_btn"
                                                                data-btntitle="<?php echo e(__('Select Image')); ?>"
                                                                data-modaltitle="<?php echo e(__('Upload Image')); ?>"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#media_upload_modal">
                                                            <?php echo e(__('Click to browse & Upload Featured Image')); ?>

                                                        </button>
                                                        <small><?php echo e(__('image format: jpg,jpeg,png,gif,webp')); ?></small> <br>
                                                        <small><?php echo e(__('recommended size 810x450')); ?></small>
                                                    </div>
                                                </div>

                                                <div class="picture mt-3">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <div class="upload-img text-center mt-3">
                                                                <div class="media-upload-btn-wrapper">
                                                                    <div class="img-wrap new_image_gallery_add_listing">
                                                                        <img src="<?php echo e(asset('assets/common/img/listing_single_image.jpg')); ?>" alt="images" class="w-100">
                                                                    </div>
                                                                    <input type="hidden" name="gallery_images">
                                                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                                                            data-btntitle="<?php echo e(__('Select Image')); ?>"
                                                                            data-modaltitle="<?php echo e(__('Upload Image')); ?>"
                                                                            data-mulitple="true"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#media_upload_modal">
                                                                        <?php echo e(__('Click to Upload Gallery Images')); ?>

                                                                    </button>
                                                                    <small><?php echo e(__('image format: jpg,jpeg,png,gif,webp')); ?></small> <br>
                                                                    <small><?php echo e(__('recommended size 810x450')); ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- start previous / next buttons -->
                                                <div class="continue-btn mt-3">
                                                    <div class="btn-wrapper mb-10 d-flex justify-content-end gap-3">
                                                        <button class="red-btn w-100 d-block" style="border: none" id="nextBtn" type="button"><?php echo e(__('Continue')); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- listing Info end-->

                        <!-- location start-->
                        <div class="tab-pane fade step" id="media-uploads" role="tabpanel" aria-labelledby="location-tab">
                            <div class="post-your-add add-location section-padding2">
                                <div class="container-1920 plr1">
                                    <div class="row">
                                        <div class="col-xl-2">
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="address box-shadow1 p-24">
                                                <?php if(get_static_option('google_map_settings_on_off') == null): ?>
                                                <div class="address-wraper">
                                                    <div class="row g-3">
                                                        <div class="col-sm-4">
                                                            <div class="country">
                                                                <label for="country"><?php echo e(__('Select Your Country')); ?></label>
                                                                <select name="country_id" id="country_id" class="select2_activation">
                                                                    <option value=""><?php echo e(__('Select Country')); ?></option>
                                                                    <?php $__currentLoopData = $all_countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($country->id); ?>"><?php echo e($country->country); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select><br>
                                                                <span class="country_info"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="country">
                                                                <label for="country"><?php echo e(__('Select Your State')); ?></label>
                                                                <select name="state_id" id="state_id" class="get_country_state select2_activation">
                                                                    <option value=""><?php echo e(__('Select State')); ?></option>
                                                                    <?php $__currentLoopData = $all_states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($state->id); ?>"><?php echo e($state->state); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select> <br>
                                                                <span class="state_info"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="country">
                                                                <label for="country"><?php echo e(__('Select Your City')); ?></label>
                                                                <select name="city_id" id="city_id" class="get_state_city select2_activation">
                                                                    <option value=""><?php echo e(__('Select City')); ?></option>
                                                                    <?php $__currentLoopData = $all_cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($city->id); ?>"><?php echo e($city->city); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select><br>
                                                                <span class="city_info"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php else: ?>
                                                    <!--Google Map -->
                                                    <div class="location-map mt-3">
                                                        <label class="infoTitle"><?php echo e(__('Google Map Location')); ?>

                                                            <a href="https://drive.google.com/file/d/1BwDAjSLAeb4LaxzOkrdsgGO_Io2jM6S6/view?usp=sharing" target="_blank">
                                                                <strong class="text-warning"><?php echo e(__('Video link')); ?></strong>
                                                            </a><small class="text-info"><?php echo e(__('Search your location, pick a location')); ?> </small>
                                                        </label>
                                                        <div class="input-form input-form2">
                                                            <div class="map-warper dark-support rounded overflow-hidden">
                                                                <input id="pac-input" class="controls rounded" type="text" placeholder="<?php echo e(__('Search your location')); ?>"/>
                                                                <div id="map_canvas" style="height: 480px"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="address-text mt-3">
                                                    <input type="hidden" name="latitude" id="latitude">
                                                    <input type="hidden" name="longitude" id="longitude">
                                                    <label for="address-text"><?php echo e(__('Address')); ?></label>
                                                    <input type="text" class="w-100 input-filed" name="address" id="user_address" value="<?php echo e(old('address')); ?>" placeholder="<?php echo e(__('Address')); ?>">
                                                </div>
                                            </div>
                                            <div class="video box-shadow1 p-24 mt-3 mb-3">
                                                <label for="vedio-link"><?php echo e(__('Video Url')); ?></label>
                                                <input type="text"  class="input-filed w-100" name="video_url" id="video_url" value="<?php echo e(old('video_url')); ?>" placeholder="<?php echo e(__('youtube url')); ?>">
                                            </div>
                                        </div>

                                        <div class="col-xl-3">
                                            <div class="right-sidebar">
                                                <div class="box-shadow1 feature p-24">
                                                    <label>
                                                        <input type="checkbox" name="is_featured" id="is_featured" value="" class="custom-check-box feature_disable_color">
                                                        <span class="ms-2"><?php echo e(__('Feature This Ad')); ?></span>
                                                    </label>
                                                    <?php if($user_featured_listing_enable === false): ?>
                                                        <p><?php echo e(__('To feature this ad, you will need to subscribe to a.')); ?>

                                                            <a href="<?php echo e(url('/' . $membership_page_url ?? 'x')); ?>"><?php echo e(__('paid membership')); ?></a>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="box-shadow1 tags p-24 mt-3">
                                                    <label for="tags"><?php echo e(__('Tags')); ?></label>
                                                    <div class="select-itms">
                                                        <select name="tags[]" id="tags" class="select2_activation" multiple>
                                                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($tag->id); ?>"><?php echo e($tag->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <small><?php echo e(__('Select Your tags name or new tag name type')); ?></small>
                                                    </div>
                                                </div>



                                                <!--Guest post section -->
                                                <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                    <label><?php echo e(get_static_option('guest_add_listing_info_section_title') ?? __('User Information')); ?></label>
                                                    <div class="mt-3">
                                                        <label for="guest_first_name" class="infoTitle"><?php echo e(__('First Name')); ?> <span class="text-danger">*</span> </label>
                                                        <input type="text" class="input-filed w-100" name="guest_first_name" id="guest_first_name" value="<?php echo e(old('guest_first_name')); ?>"  placeholder="<?php echo e(__('First Name')); ?>">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="guest_first_name" class="infoTitle"><?php echo e(__('Last Name')); ?> <span class="text-danger">*</span> </label>
                                                        <input type="text" class="input-filed w-100" name="guest_last_name" id="guest_last_name" value="<?php echo e(old('guest_last_name')); ?>"  placeholder="<?php echo e(__('Last Name')); ?>">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="guest_first_name" class="infoTitle"><?php echo e(__('Email')); ?> <span class="text-danger">*</span> </label>
                                                        <input type="email" class="input-filed w-100" name="guest_email" id="guest_email" value="<?php echo e(old('guest_email')); ?>"  placeholder="<?php echo e(__('Email')); ?>">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="guest_first_name" class="infoTitle"><?php echo e(__('Phone Number')); ?> <span class="text-danger">*</span> </label>
                                                        <input type="hidden" id="guest-country-code" name="guest_country_code">
                                                        <input type="tel" class="input-filed w-100" name="guest_phone" id="guest_phone" value="<?php echo e(old('guest_phone')); ?>"  placeholder="<?php echo e(__('Phone')); ?>">
                                                    </div>

                                                    <div id="guest_error_message" class="d-flex flex-column gap-2 mt-2 mb-2"> </div>

                                                    <div class="feature">
                                                        <label>
                                                            <input type="checkbox" name="guest_register_request" id="guest_register_request" value="" class="custom-check-box">
                                                            <span class="ms-2 title-para text-primary"><?php echo e(get_static_option('guest_registration_agreement_title') ?? __('I agree that the above information is accurate and I am excited to register!')); ?></span>
                                                        </label>
                                                    </div>

                                                    <!-- Terms and Conditions -->
                                                    <div class="feature">
                                                        <label class="checkWrap2 terms-conditions">
                                                            <input class="custom-check-box check-input" type="checkbox" name="terms_conditions" id="terms_conditions" value="1">
                                                            <span class="checkmark mx-1"></span> <?php echo e(__('I agree with the')); ?>

                                                            <a href="<?php echo e(url('/'.get_static_option('select_terms_condition_page'))); ?>" target="_blank" class="text-primary"> <?php echo e(__('Terms and Conditions')); ?> </a>
                                                        </label>
                                                    </div>

                                                </div>


                                                <!-- start previous / next buttons -->
                                                <div class="continue-btn mt-3">
                                                    <div class="btn-wrapper mb-10 d-flex justify-content-end gap-3">
                                                        <button class="red-btn w-100 d-block" id="prevBtn" type="button"><?php echo e(__('Previous')); ?></button>
                                                        <button class="red-btn w-100 d-block" id="submitBtn" type="submit"><?php echo e(__('Submit Listing')); ?></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xl-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- location end-->
                    </div>
                </div>
            </form>

        </div>
    <?php if (isset($component)) { $__componentOriginal55d50acd7279eedb700542111888856a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55d50acd7279eedb700542111888856a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.guest-markup','data' => ['type' => 'web']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.guest-markup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('web')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55d50acd7279eedb700542111888856a)): ?>
<?php $attributes = $__attributesOriginal55d50acd7279eedb700542111888856a; ?>
<?php unset($__attributesOriginal55d50acd7279eedb700542111888856a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55d50acd7279eedb700542111888856a)): ?>
<?php $component = $__componentOriginal55d50acd7279eedb700542111888856a; ?>
<?php unset($__componentOriginal55d50acd7279eedb700542111888856a); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                //confirm signup
                $(document).on('click', '#submitBtn', function() {
                    // terms and condition check
                    if (!$('.terms-conditions .check-input').is(":checked")) {
                        toastr_warning_js("<?php echo e(__('Please agree with terms and conditions')); ?>")
                        return false;
                    }
                });
            });
        })(jQuery)
    </script>

    <?php if (isset($component)) { $__componentOriginal99cd76d04c95431a49189c7e14e5b186 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99cd76d04c95431a49189c7e14e5b186 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.js.listing-attribute-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.js.listing-attribute-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal99cd76d04c95431a49189c7e14e5b186)): ?>
<?php $attributes = $__attributesOriginal99cd76d04c95431a49189c7e14e5b186; ?>
<?php unset($__attributesOriginal99cd76d04c95431a49189c7e14e5b186); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal99cd76d04c95431a49189c7e14e5b186)): ?>
<?php $component = $__componentOriginal99cd76d04c95431a49189c7e14e5b186; ?>
<?php unset($__componentOriginal99cd76d04c95431a49189c7e14e5b186); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalaccce8206efc422e8162b524b175397d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaccce8206efc422e8162b524b175397d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.js.phone-number-check-for-listing','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.js.phone-number-check-for-listing'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaccce8206efc422e8162b524b175397d)): ?>
<?php $attributes = $__attributesOriginalaccce8206efc422e8162b524b175397d; ?>
<?php unset($__attributesOriginalaccce8206efc422e8162b524b175397d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaccce8206efc422e8162b524b175397d)): ?>
<?php $component = $__componentOriginalaccce8206efc422e8162b524b175397d; ?>
<?php unset($__componentOriginalaccce8206efc422e8162b524b175397d); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginala4bd4c93496fb5f39140c1501806c8b3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4bd4c93496fb5f39140c1501806c8b3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.js.phone-number-check-for-guest-listing','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.js.phone-number-check-for-guest-listing'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4bd4c93496fb5f39140c1501806c8b3)): ?>
<?php $attributes = $__attributesOriginala4bd4c93496fb5f39140c1501806c8b3; ?>
<?php unset($__attributesOriginala4bd4c93496fb5f39140c1501806c8b3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4bd4c93496fb5f39140c1501806c8b3)): ?>
<?php $component = $__componentOriginala4bd4c93496fb5f39140c1501806c8b3; ?>
<?php unset($__componentOriginala4bd4c93496fb5f39140c1501806c8b3); ?>
<?php endif; ?>

    <?php if(!empty(get_static_option('google_map_settings_on_off'))): ?>
    <?php if (isset($component)) { $__componentOriginalf10e56622ca73536d243eb7fd71c2d29 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf10e56622ca73536d243eb7fd71c2d29 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.map.google-map-api-key-set','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('map.google-map-api-key-set'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf10e56622ca73536d243eb7fd71c2d29)): ?>
<?php $attributes = $__attributesOriginalf10e56622ca73536d243eb7fd71c2d29; ?>
<?php unset($__attributesOriginalf10e56622ca73536d243eb7fd71c2d29); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf10e56622ca73536d243eb7fd71c2d29)): ?>
<?php $component = $__componentOriginalf10e56622ca73536d243eb7fd71c2d29; ?>
<?php unset($__componentOriginalf10e56622ca73536d243eb7fd71c2d29); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal7b7c69c1002f0c5ef5d6640701b5da90 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b7c69c1002f0c5ef5d6640701b5da90 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.map.google-map-listing-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('map.google-map-listing-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b7c69c1002f0c5ef5d6640701b5da90)): ?>
<?php $attributes = $__attributesOriginal7b7c69c1002f0c5ef5d6640701b5da90; ?>
<?php unset($__attributesOriginal7b7c69c1002f0c5ef5d6640701b5da90); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b7c69c1002f0c5ef5d6640701b5da90)): ?>
<?php $component = $__componentOriginal7b7c69c1002f0c5ef5d6640701b5da90; ?>
<?php unset($__componentOriginal7b7c69c1002f0c5ef5d6640701b5da90); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (isset($component)) { $__componentOriginaled93b3c4cbb60cc01160d92367c4e865 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled93b3c4cbb60cc01160d92367c4e865 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.guest-js','data' => ['type' => 'web']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.guest-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('web')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled93b3c4cbb60cc01160d92367c4e865)): ?>
<?php $attributes = $__attributesOriginaled93b3c4cbb60cc01160d92367c4e865; ?>
<?php unset($__attributesOriginaled93b3c4cbb60cc01160d92367c4e865); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled93b3c4cbb60cc01160d92367c4e865)): ?>
<?php $component = $__componentOriginaled93b3c4cbb60cc01160d92367c4e865; ?>
<?php unset($__componentOriginaled93b3c4cbb60cc01160d92367c4e865); ?>
<?php endif; ?>
    <?php echo $__env->make('frontend.user.listings.guest-listing-add-image-upload-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(asset('assets/backend/js/sweetalert2.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/multi-step.js')); ?>"></script>
    <?php if (isset($component)) { $__componentOriginale5b58a3009df297f039f4deb857ae091 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5b58a3009df297f039f4deb857ae091 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.summernote.js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('summernote.js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5b58a3009df297f039f4deb857ae091)): ?>
<?php $attributes = $__attributesOriginale5b58a3009df297f039f4deb857ae091; ?>
<?php unset($__attributesOriginale5b58a3009df297f039f4deb857ae091); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5b58a3009df297f039f4deb857ae091)): ?>
<?php $component = $__componentOriginale5b58a3009df297f039f4deb857ae091; ?>
<?php unset($__componentOriginale5b58a3009df297f039f4deb857ae091); ?>
<?php endif; ?>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <?php if (isset($component)) { $__componentOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.js.new-tag-add-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.js.new-tag-add-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a)): ?>
<?php $attributes = $__attributesOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a; ?>
<?php unset($__attributesOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a)): ?>
<?php $component = $__componentOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a; ?>
<?php unset($__componentOriginal0d851ffbab1e1fe1ae11dfa476c2ee2a); ?>
<?php endif; ?>

     <?php if (isset($component)) { $__componentOriginal0b7ffe6948f30bcf099588ae731cdd67 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b7ffe6948f30bcf099588ae731cdd67 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.guest-listing-ad-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.guest-listing-ad-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b7ffe6948f30bcf099588ae731cdd67)): ?>
<?php $attributes = $__attributesOriginal0b7ffe6948f30bcf099588ae731cdd67; ?>
<?php unset($__attributesOriginal0b7ffe6948f30bcf099588ae731cdd67); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b7ffe6948f30bcf099588ae731cdd67)): ?>
<?php $component = $__componentOriginal0b7ffe6948f30bcf099588ae731cdd67; ?>
<?php unset($__componentOriginal0b7ffe6948f30bcf099588ae731cdd67); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal13b8f1c2e575bff7cbfa435f614db3a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13b8f1c2e575bff7cbfa435f614db3a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.feature-ad-js','data' => ['featuredenable' => $user_featured_listing_enable]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.feature-ad-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['featuredenable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user_featured_listing_enable)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13b8f1c2e575bff7cbfa435f614db3a4)): ?>
<?php $attributes = $__attributesOriginal13b8f1c2e575bff7cbfa435f614db3a4; ?>
<?php unset($__attributesOriginal13b8f1c2e575bff7cbfa435f614db3a4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13b8f1c2e575bff7cbfa435f614db3a4)): ?>
<?php $component = $__componentOriginal13b8f1c2e575bff7cbfa435f614db3a4; ?>
<?php unset($__componentOriginal13b8f1c2e575bff7cbfa435f614db3a4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal3d5064cab9e4cc01834cd7137a2a96a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d5064cab9e4cc01834cd7137a2a96a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.condition-authenticity','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.condition-authenticity'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d5064cab9e4cc01834cd7137a2a96a0)): ?>
<?php $attributes = $__attributesOriginal3d5064cab9e4cc01834cd7137a2a96a0; ?>
<?php unset($__attributesOriginal3d5064cab9e4cc01834cd7137a2a96a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d5064cab9e4cc01834cd7137a2a96a0)): ?>
<?php $component = $__componentOriginal3d5064cab9e4cc01834cd7137a2a96a0; ?>
<?php unset($__componentOriginal3d5064cab9e4cc01834cd7137a2a96a0); ?>
<?php endif; ?>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                // phone hidden
                $(document).on('change','#negotiable',function(e) {
                    if ($(this).is(':checked')) {
                        let negotiable = 1;
                        $('#negotiable').val(negotiable);
                    }else{
                        let negotiable = 0;
                        $('#negotiable').val(negotiable);
                    }
                });

                // phone hidden
                $(document).on('change','#phone_hidden',function(e) {
                    e.preventDefault();
                    if ($(this).is(':checked')) {
                        let phone_hidden = 1;
                        $('#phone_hidden').val(phone_hidden);
                    }else{
                        let phone_hidden = 0;
                        $('#phone_hidden').val(phone_hidden);
                    }
                });

                $(document).on('click', '#prevBtn', function() {
                    $("#nextBtn").show();
                    $("#submitBtn, #prevBtn").hide();
                });

                //Permalink Code
                $('.permalink_label').hide();
                $(document).on('keyup', '#title', function (e) {
                    let slug = converToSlug($(this).val());
                    let url = "<?php echo e(url('/listing/')); ?>/" + slug;
                    $('.permalink_label').show();
                    let data = $('#slug_show').text(url).css('color', '#3c3cf7');
                    $('.listing_slug').val(slug);

                });

                function converToSlug(slug){
                    let finalSlug = slug.replace(/[^a-zA-Z0-9]/g, ' ');
                    finalSlug = slug.replace(/  +/g, ' ');
                    finalSlug = slug.replace(/\s/g, '-').toLowerCase().replace(/[^\w-]+/g, '-');
                    return finalSlug;
                }

                //Slug Edit Code
                $(document).on('click', '.slug_edit_button', function (e) {
                    e.preventDefault();
                    $('.listing_slug').show();
                    $(this).hide();
                    $('.slug_update_button').show();
                });

                //Slug Update Code
                $(document).on('click', '.slug_update_button', function (e) {
                    e.preventDefault();
                    $(this).hide();
                    $('.slug_edit_button').show();
                    var update_input = $('.listing_slug').val();
                    var slug = converToSlug(update_input);
                    var url = `<?php echo e(url('/listing/')); ?>/` + slug;
                    $('#slug_show').text(url);
                    $('.listing_slug').hide();
                });

                $('#category').on('change',function(){
                    let category_id = $(this).val();
                    $.ajax({
                        method:'post',
                        url:"<?php echo e(route('get.subcategory')); ?>",
                        data:{category_id:category_id},
                        success:function(res){
                            if(res.status=='success'){
                                let alloptions = "<option value=''><?php echo e(__('Select Sub Category')); ?></option>";
                                let allSubCategory = res.sub_categories;
                                $.each(allSubCategory,function(index,value){
                                    alloptions +="<option value='" + value.id + "'>" + value.name + "</option>";
                                });
                                $(".subcategory").html(alloptions);
                                $('#subcategory').niceSelect('update');
                            }
                        }
                    });
                });

                // listing sub category and child category
                $(document).on('change','#subcategory', function() {
                    var sub_cat_id = $(this).val();
                    $.ajax({
                        method: 'post',
                        url: "<?php echo e(route('get.subcategory.with.child.category')); ?>",
                        data: {
                            sub_cat_id: sub_cat_id
                        },
                        success: function(res) {

                            if (res.status == 'success') {
                                var alloptions = "<option value=''><?php echo e(__('Select Child Category')); ?></option>";
                                var allList = "<li data-value='' class='option'><?php echo e(__('Select Child Category')); ?></li>";
                                var allChildCategory = res.child_category;

                                $.each(allChildCategory, function(index, value) {
                                    alloptions += "<option value='" + value.id +
                                        "'>" + value.name + "</option>";
                                    allList += "<li class='option' data-value='" + value.id +
                                        "'>" + value.name + "</li>";
                                });

                                $("#child_category").html(alloptions);
                                $(".child_category_wrapper ul.list").html(allList);
                                $(".child_category_wrapper").find(".current").html("Select Child Category");
                            }
                        }
                    });
                });

                // change country and get state
                $(document).on('change','#country_id', function() {
                    let country = $(this).val();
                    $.ajax({
                        method: 'post',
                        url: "<?php echo e(route('au.state.all')); ?>",
                        data: {
                            country: country
                        },
                        success: function(res) {
                            if (res.status == 'success') {
                                let all_options = "<option value=''><?php echo e(__('Select State')); ?></option>";
                                let all_state = res.states;
                                $.each(all_state, function(index, value) {
                                    all_options += "<option value='" + value.id +
                                        "'>" + value.state + "</option>";
                                });
                                $(".get_country_state").html(all_options);
                                $(".state_info").html('');
                                if(all_state.length <= 0){
                                    $(".state_info").html('<span class="text-danger"> <?php echo e(__('No state found for selected country!')); ?> <span>');
                                }
                            }
                        }
                    })
                })

                // change state and get city
                $('#state_id').on('change', function() {
                    let state = $(this).val();
                    $.ajax({
                        method: 'post',
                        url: "<?php echo e(route('au.city.all')); ?>",
                        data: {
                            state: state
                        },
                        success: function(res) {
                            if (res.status == 'success') {
                                let all_options = "<option value=''><?php echo e(__('Select City')); ?></option>";
                                let all_city = res.cities;
                                $.each(all_city, function(index, value) {
                                    all_options += "<option value='" + value.id +
                                        "'>" + value.city + "</option>";
                                });
                                $(".get_state_city").html(all_options);

                                $(".city_info").html('');
                                if(all_city.length <= 0){
                                    $(".city_info").html('<span class="text-danger"> <?php echo e(__('No city found for selected state!')); ?> <span>');
                                }
                            }
                        }
                    });
                });

            });
        })(jQuery)
    </script>

    <?php if(session('success')): ?>
        <script>
            toastr.success('<?php echo e(session('success')); ?>', 'Success');
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/user/listings/guest-add-listing.blade.php ENDPATH**/ ?>