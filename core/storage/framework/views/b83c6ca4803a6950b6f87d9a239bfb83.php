
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Edit Child Category')); ?>

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
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/bootstrap-tagsinput.css')); ?>">
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
    <style>
        .media-upload-btn-wrapper .img-wrap {
            position: relative;
            display: inline-block;
            max-width: 30%;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row g-4 mt-0">
        <div class="col-xl-6 col-lg-6 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between mb-3">
                    <div class="left-content">
                        <h4 class="header-title"><?php echo e(__('Edit Child Category')); ?>   </h4>
                    </div>
                    <div class="right-content">
                        <a class="cmnBtn btn_5 btn_bg_info radius-5" href="<?php echo e(route('admin.child.category')); ?>"><?php echo e(__('All Child Categories')); ?></a>
                    </div>
                </div>
                <?php if (isset($component)) { $__componentOriginal4bb59b834d778ff0cb72af5a473e2885 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4bb59b834d778ff0cb72af5a473e2885 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation.error','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('validation.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4bb59b834d778ff0cb72af5a473e2885)): ?>
<?php $attributes = $__attributesOriginal4bb59b834d778ff0cb72af5a473e2885; ?>
<?php unset($__attributesOriginal4bb59b834d778ff0cb72af5a473e2885); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4bb59b834d778ff0cb72af5a473e2885)): ?>
<?php $component = $__componentOriginal4bb59b834d778ff0cb72af5a473e2885; ?>
<?php unset($__componentOriginal4bb59b834d778ff0cb72af5a473e2885); ?>
<?php endif; ?>
                <form action="<?php echo e(route('admin.child.category.edit',$child_category->id)); ?>" method="post" enctype="multipart/form-data" id="edit_category_form">
                    <?php echo csrf_field(); ?>
                    <div class="form__input__flex">

                        <div class="form__input__single">
                            <label for="icon" class="d-block form__input__single__label"><?php echo e(__('Parent Category')); ?></label>
                            <div class="select2_item mt-4">
                                <select name="category_id" id="category" class="select2_activation">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>" <?php if($cat->id==$child_category->category_id): ?> selected <?php endif; ?>><?php echo e($cat->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form__input__single">
                            <label for="name" class="form__input__single__label"><?php echo e(__('Sub Category')); ?></label>
                            <select  name="sub_category_id" id="subcategory" class="select2_activation subcategory">
                                <option <?php if(!empty($child_category->sub_category_id)): ?> value="<?php echo e($child_category->sub_category_id); ?>" <?php else: ?> value="" <?php endif; ?> >
                                    <?php echo e(optional($child_category->subcategory)->name); ?></option>
                            </select>
                        </div>

                        <div class="form__input__single">
                            <label for="name" class="form__input__single__label"><?php echo e(__('Child Category Name')); ?></label>
                            <input type="text" class="form__control radius-5" name="name" id="name" value="<?php echo e($child_category->name); ?>" placeholder="<?php echo e(__('Child Category Name')); ?>">
                        </div>

                        <div class="form__input__single permalink_label">
                            <label class="text-dark form__input__single__label"><?php echo e(__('Permalink * :')); ?>

                                <span id="slug_show" class="display-inline"></span>
                                <span id="slug_edit" class="display-inline">
                                     <button class="btn btn-warning btn-sm slug_edit_button"> <i class="fas fa-edit"></i> </button>
                                    <input type="text" name="slug" class="form-control child_category_slug mt-2" value="<?php echo e($child_category->slug); ?>" style="display: none">
                                      <button class="btn btn-info btn-sm slug_update_button mt-2" style="display: none"><?php echo e(__('Update')); ?></button>
                                </span>
                            </label>
                        </div>

                        <div class="form__input__single">
                            <label class="form__input__single__label"><?php echo e(__('Description')); ?></label>
                            <input type="hidden" name="description" value="<?php echo e($child_category->description); ?>">
                            <div class="summernote" data-content="<?php echo e($child_category->description); ?>"></div>
                        </div>

                        <div class="form__input__single">
                            <label for="image" class="form__input__single__label"><?php echo e(__('Upload Child Category Image')); ?></label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap">
                                    <?php echo render_image_markup_by_attachment_id($child_category->image,'','thumb'); ?>

                                </div>
                                <input type="hidden" name="image" value="<?php echo e($child_category->image); ?>">
                                <button type="button" class="cmnBtn btn_5 btn_bg_blue radius-5 media_upload_form_btn"
                                        data-btntitle="<?php echo e(__('Select Image')); ?>"
                                        data-modaltitle="<?php echo e(__('Upload Image')); ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#media_upload_modal">
                                    <?php echo e(__('Upload Image')); ?>

                                </button>
                            </div>
                        </div>


                        <!-- meta section start -->
                        <div class="row mt-3">
                            <div class="col-xxl-12 col-lg-12">
                                <div class="collapse_wrapper dashboard__card style_one bg__white padding-20 radius-10">
                                    <div class="collapse_wrapper__header">
                                        <h5 class="collapse_wrapper__header__title"><?php echo e(__('Meta Section')); ?></h5>
                                    </div>
                                    <div class="tab_wrapper style_seven">
                                        <!--Tab Button  -->
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab8" role="tablist">
                                                <a class="nav-link active" id="nav-21-tab"
                                                   data-bs-toggle="tab"
                                                   href="#blog_meta"
                                                   role="tab"
                                                   aria-controls="nav-21"
                                                   aria-selected="true"><?php echo e(__('Blog Meta')); ?></a>
                                                <a class="nav-link" id="nav-22-tab"
                                                   data-bs-toggle="tab"
                                                   href="#facebook_meta"
                                                   role="tab"
                                                   aria-controls="nav-22"
                                                   aria-selected="false"><?php echo e(__('Facebook Meta')); ?></a>
                                                <a class="nav-link" id="nav-23-tab"
                                                   data-bs-toggle="tab"
                                                   href="#twitter_meta"
                                                   role="tab"
                                                   aria-controls="nav-23"
                                                   aria-selected="false"><?php echo e(__('Twitter Meta')); ?></a>
                                            </div>
                                        </nav>
                                        <!--End-of Tab Button  -->
                                        <!-- Tab Contents -->
                                        <div class="tab-content" id="nav-tabContent8">
                                            <div class="tab-pane fade show active" id="blog_meta" role="tabpanel" aria-labelledby="nav-21-tab">
                                                <div class="form__input__flex mt-3">
                                                    <div class="form__input__single">
                                                        <label for="meta_title" class="form__input__single__label"><?php echo e(__('Meta Title')); ?></label>
                                                        <input type="text" class="form__control" name="meta_title" id="meta_title" value="<?php echo e($child_category->metaData->meta_title ?? ''); ?>" placeholder="<?php echo e(__('Title')); ?>">
                                                    </div>
                                                    <div class="form__input__single">
                                                        <label for="meta_tags" class="form__input__single__label"><?php echo e(__('Meta Tags')); ?></label>
                                                        <input type="text" class="form__control" name="meta_tags" id="meta_tags" value="<?php echo e($child_category->metaData->meta_tags ?? ''); ?>" data-role="tagsinput" placeholder="<?php echo e(__('Tag')); ?>">
                                                    </div>
                                                    <div class="form__input__single">
                                                        <label for="meta_description" class="form__input__single__label"><?php echo e(__('Meta Description')); ?></label>
                                                        <textarea class="form__control" name="meta_description"  cols="20" rows="4"><?php echo $child_category->metaData->meta_description ?? ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="facebook_meta" role="tabpanel" aria-labelledby="nav-22-tab">
                                                <div class="form__input__single">
                                                    <label for="title" class="form__input__single__label"><?php echo e(__('Facebook Meta Title')); ?></label>
                                                    <input type="text" class="form__control" data-role="tagsinput" name="facebook_meta_tags" value="<?php echo e($child_category->metaData->facebook_meta_tags ?? ''); ?>">
                                                </div>
                                                <div class="row">
                                                    <div class="form__input__single col-md-12">
                                                        <label for="title" class="form__input__single__label"><?php echo e(__('Facebook Meta Description')); ?></label>
                                                        <textarea name="facebook_meta_description"  class="form__control max-height-140"  cols="20"  rows="4"><?php echo $child_category->metaData->facebook_meta_description ?? ''; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form__input__single">
                                                    <label for="image" class="form__input__single__label"><?php echo e(__('Facebook Meta Image')); ?></label>
                                                    <div class="media-upload-btn-wrapper">
                                                        <div class="img-wrap">
                                                            <?php echo render_attachment_preview_for_admin($child_category->metaData->facebook_meta_image ?? ''); ?>

                                                        </div>
                                                        <input type="hidden" name="facebook_meta_image" value="<?php echo e($child_category->metaData->facebook_meta_image ?? ''); ?>">
                                                        <button type="button" class="cmnBtn btn_5 btn_bg_blue radius-5 media_upload_form_btn"
                                                                data-btntitle="<?php echo e(__('Select Image')); ?>"
                                                                data-modaltitle="<?php echo e(__('Upload Image')); ?>"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#media_upload_modal">
                                                            <?php echo e(__('Upload Image')); ?>

                                                        </button>
                                                        <span class="form-text text-muted"><?php echo e(__('allowed image format: jpg,jpeg,png,webp')); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="twitter_meta" role="tabpanel" aria-labelledby="nav-22-tab">
                                                <div class="form__input__single">
                                                    <label for="title" class="form__input__single__label"><?php echo e(__('Twitter Meta Title')); ?></label>
                                                    <input type="text" class="form__control" data-role="tagsinput"  name="twitter_meta_tags" value="<?php echo e($child_category->metaData->twitter_meta_tags ?? ''); ?>">
                                                </div>
                                                <div class="row">
                                                    <div class="form__input__single col-md-12">
                                                        <label for="title"><?php echo e(__('Twitter Meta Description')); ?></label>
                                                        <textarea name="twitter_meta_description" class="form__control max-height-140" cols="20" rows="4"><?php echo $child_category->metaData->twitter_meta_description ?? ''; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form__input__single">
                                                    <label for="image" class="form__input__single__label"><?php echo e(__('Twitter Meta Image')); ?></label>
                                                    <div class="media-upload-btn-wrapper">
                                                        <div class="img-wrap">
                                                            <?php echo render_attachment_preview_for_admin($child_category->metaData->twitter_meta_image ?? ''); ?>

                                                        </div>
                                                        <input type="hidden" name="twitter_meta_image" value="<?php echo e($child_category->metaData->twitter_meta_image ?? ''); ?>">
                                                        <button type="button"
                                                                class="cmnBtn btn_5 btn_bg_blue radius-5 media_upload_form_btn"
                                                                data-btntitle="<?php echo e(__('Select Image')); ?>"
                                                                data-modaltitle="<?php echo e(__('Upload Image')); ?>"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#media_upload_modal">
                                                            <?php echo e(__('Upload Image')); ?>

                                                        </button>
                                                        <small class="form-text text-muted"><?php echo e(__('allowed image format: jpg,jpeg,png,webp')); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn_wrapper mt-4">
                        <button type="submit" id="update" class="cmnBtn btn_5 btn_bg_blue radius-5"><?php echo e(__('Update')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.markup','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.markup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75)): ?>
<?php $attributes = $__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75; ?>
<?php unset($__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75)): ?>
<?php $component = $__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75; ?>
<?php unset($__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php if (isset($component)) { $__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e)): ?>
<?php $attributes = $__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e; ?>
<?php unset($__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e)): ?>
<?php $component = $__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e; ?>
<?php unset($__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e); ?>
<?php endif; ?>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/fontawesome-iconpicker.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/fontawesome-iconpicker.min.css')); ?>">
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
    <script>
        <?php if (isset($component)) { $__componentOriginal9bb7c769e10559efc2f738350a5fc6e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bb7c769e10559efc2f738350a5fc6e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon.icon-picker','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon.icon-picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bb7c769e10559efc2f738350a5fc6e1)): ?>
<?php $attributes = $__attributesOriginal9bb7c769e10559efc2f738350a5fc6e1; ?>
<?php unset($__attributesOriginal9bb7c769e10559efc2f738350a5fc6e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bb7c769e10559efc2f738350a5fc6e1)): ?>
<?php $component = $__componentOriginal9bb7c769e10559efc2f738350a5fc6e1; ?>
<?php unset($__componentOriginal9bb7c769e10559efc2f738350a5fc6e1); ?>
<?php endif; ?>
    </script>
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                //Permalink Code
                var sl =  $('.child_category_slug').val();
                var url = `<?php echo e(url('/child-category/')); ?>/` + sl;
                var data = $('#slug_show').text(url).css('color', 'blue');

                function converToSlug(slug){
                    let finalSlug = slug.replace(/[^a-zA-Z0-9]/g, ' ');
                    finalSlug = slug.replace(/  +/g, ' ');
                    finalSlug = slug.replace(/\s/g, '-').toLowerCase().replace(/[^\w-]+/g, '-');
                    return finalSlug;
                }

                //Slug Edit Code
                $(document).on('click', '.slug_edit_button', function (e) {
                    e.preventDefault();
                    $('.child_category_slug').show();
                    $(this).hide();
                    $('.slug_update_button').show();
                });

                //Slug Update Code
                $(document).on('click', '.slug_update_button', function (e) {
                    e.preventDefault();
                    $(this).hide();
                    $('.slug_edit_button').show();
                    var update_input = $('.child_category_slug').val();
                    var slug = converToSlug(update_input);
                    var url = `<?php echo e(url('/child-category/')); ?>/` + slug;
                    $('#slug_show').text(url);
                    $('.child_category_slug').val(slug)
                    $('.child_category_slug').hide();
                });

                $('#category').on('change',function(){
                    let category_id = $(this).val();
                    $.ajax({
                        method:'post',
                        url:"<?php echo e(route('admin.select.subcategory')); ?>",
                        data:{category_id:category_id},
                        success:function(res){
                            if(res.status=='success'){
                                let alloptions = '';
                                let allSubCategory = res.sub_categories;
                                $.each(allSubCategory,function(index,value){
                                    alloptions +="<option value='" + value.id + "'>" + value.name + "</option>";
                                });
                                $(".subcategory").html(alloptions);
                                $('#subcategory').niceSelect('update');
                            }
                        }
                    })
                });

                // for summernote
                $('.summernote').summernote({
                    height: 400,
                    codemirror: {
                        theme: 'monokai'
                    },
                    callbacks: {
                        onChange: function (contents, $editable) {
                            $(this).prev('input').val(contents);
                        }
                    }
                });
                if ($('.summernote').length > 0) {
                    $('.summernote').each(function (index, value) {
                        $(this).summernote('code', $(this).data('content'));
                    });
                }

            });
        })(jQuery)
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/pages/child-category/edit_child_category.blade.php ENDPATH**/ ?>