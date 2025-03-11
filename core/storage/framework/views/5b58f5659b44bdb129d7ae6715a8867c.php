<?php $__env->startSection('site_title'); ?>
    <?php echo e(__('Profile Settings')); ?>

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
    <style>
        .accountWrapper .userProfile .recentImg img {
            border-radius: 12px;
            height: 77px;
            width: 88px;
            animation-duration: auto;
        }
        .input-form{
            flex: 1;
        }
        .select2-container {
            z-index: 999;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="profile-setting profile-pages section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        <?php echo $__env->make('frontend.user.layout.partials.user-profile-background-image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="down-body-wraper justify-content-center">
                            <?php echo $__env->make('frontend.user.layout.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="main-body">
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
                                <?php if (isset($component)) { $__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.user.responsive-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.user.responsive-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3)): ?>
<?php $attributes = $__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3; ?>
<?php unset($__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3)): ?>
<?php $component = $__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3; ?>
<?php unset($__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3); ?>
<?php endif; ?>
                                <form id="update_profile_form" method="post">
                                    <?php echo csrf_field(); ?>

                                    <div class="userProfile mb-24">
                                        <div class="seller-details-wraper">
                                            <div class="media-upload-btn-wrapper d-flex align-items-center gap-3">
                                                <div class="seller-details-wraper">
                                                    <div class="img-wrap seller-img p-0">
                                                        <?php if(!empty(Auth::guard('web')->user()->image)): ?>
                                                            <?php echo render_image_markup_by_attachment_id(Auth::guard('web')->user()->image,'','thumb'); ?>

                                                        <?php else: ?>
                                                            <img src="<?php echo e(asset('assets/frontend/img/static/user-no-image.webp')); ?>" alt="No Image">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                   <input type="hidden" id="image" name="image" value="<?php echo e(Auth::guard('web')->user()->image); ?>">
                                                   <button type="button" class="btn media_upload_form_btn"
                                                           data-btntitle="<?php echo e(__('Select Image')); ?>"
                                                           data-modaltitle="<?php echo e(__('Upload Image')); ?>"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#media_upload_modal">
                                                       <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                           <path d="M17.5 12.5V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V12.5" stroke="#1E293B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                           <path d="M14.1673 6.66667L10.0007 2.5L5.83398 6.66667" stroke="#1E293B" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                           <path d="M10 2.5V12.5" stroke="#1E293B" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                                       </svg>
                                                       <?php echo e(__('Upload Photo')); ?>

                                                   </button>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-form-wraper">
                                        <div class="d-flex justify-content-between gap-3">
                                            <div class="input-form">
                                                <label for="title"><?php echo e(__('First Name')); ?> <span class="text-danger">*</span> </label>
                                                <input id="first_name" value="<?php echo e(Auth::guard('web')->user()->first_name ?? ''); ?>" class="w-100 input-field">
                                            </div>

                                            <div class="input-form">
                                                <label for="title"><?php echo e(__('Last Name')); ?> <span class="text-danger">*</span> </label>
                                                <input id="last_name" value="<?php echo e(Auth::guard('web')->user()->last_name ?? ''); ?>" class="w-100 input-field">
                                            </div>
                                        </div>

                                        <div class="input-form">
                                            <label for="title"><?php echo e(__('Your Email')); ?> <span class="text-danger">*</span> </label>
                                            <input id="email" value="<?php echo e(Auth::guard('web')->user()->email ?? ''); ?>" class="w-100 input-field">
                                        </div>

                                        <div class="input-form">
                                            <label for="title"><?php echo e(__('Your Phone')); ?> <span class="text-danger">*</span> </label>
                                            <input id="phone" type="tel" value="<?php echo e(Auth::guard('web')->user()->phone ?? ''); ?>" class="w-100 input-field">
                                        </div>

                                        <div class="input-form">
                                            <?php if (isset($component)) { $__componentOriginal516dbd59f81d12312a6824830d51c000 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal516dbd59f81d12312a6824830d51c000 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.country-dropdown','data' => ['title' => __('Select Your Country'),'id' => 'country_id','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.country-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Your Country')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('country_id'),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal516dbd59f81d12312a6824830d51c000)): ?>
<?php $attributes = $__attributesOriginal516dbd59f81d12312a6824830d51c000; ?>
<?php unset($__attributesOriginal516dbd59f81d12312a6824830d51c000); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal516dbd59f81d12312a6824830d51c000)): ?>
<?php $component = $__componentOriginal516dbd59f81d12312a6824830d51c000; ?>
<?php unset($__componentOriginal516dbd59f81d12312a6824830d51c000); ?>
<?php endif; ?>
                                        </div>

                                        <div class="d-flex justify-content-between gap-3">
                                            <div class="input-form">
                                                <?php if (isset($component)) { $__componentOriginale1575a57811d7165e65a8a34fe5df9ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale1575a57811d7165e65a8a34fe5df9ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.state-dropdown','data' => ['title' => __('Select Your State'),'id' => 'state_id','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.state-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Your State')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('state_id'),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale1575a57811d7165e65a8a34fe5df9ad)): ?>
<?php $attributes = $__attributesOriginale1575a57811d7165e65a8a34fe5df9ad; ?>
<?php unset($__attributesOriginale1575a57811d7165e65a8a34fe5df9ad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale1575a57811d7165e65a8a34fe5df9ad)): ?>
<?php $component = $__componentOriginale1575a57811d7165e65a8a34fe5df9ad; ?>
<?php unset($__componentOriginale1575a57811d7165e65a8a34fe5df9ad); ?>
<?php endif; ?>
                                            </div>
                                            <div class="input-form">
                                                <?php if (isset($component)) { $__componentOriginal00c59bb80979fa38e61598a5020700f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal00c59bb80979fa38e61598a5020700f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.city-dropdown','data' => ['title' => __('Select Your City'),'id' => 'city_id','required' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.city-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Your City')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('city_id'),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal00c59bb80979fa38e61598a5020700f9)): ?>
<?php $attributes = $__attributesOriginal00c59bb80979fa38e61598a5020700f9; ?>
<?php unset($__attributesOriginal00c59bb80979fa38e61598a5020700f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal00c59bb80979fa38e61598a5020700f9)): ?>
<?php $component = $__componentOriginal00c59bb80979fa38e61598a5020700f9; ?>
<?php unset($__componentOriginal00c59bb80979fa38e61598a5020700f9); ?>
<?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-wrapper mt-3">
                                        <button type="submit" id="user_profile_info_update" class="red-btn"> <?php echo e(__('Save changes')); ?> </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->make('frontend.user.profile.edit-profile-info-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if (isset($component)) { $__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.markup','data' => ['type' => 'web']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.markup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('web')]); ?>
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
   <?php echo $__env->make('frontend.user.profile.profile-bg-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('assets/backend/js/sweetalert2.js')); ?>"></script>
    <?php if (isset($component)) { $__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.js','data' => ['type' => 'web']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('web')]); ?>
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
    <?php echo $__env->make('frontend.user.profile.profile-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(session('success')): ?>
        <script>
            toastr.success('<?php echo e(session('success')); ?>', 'Success');
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/user/profile/profile-settings.blade.php ENDPATH**/ ?>