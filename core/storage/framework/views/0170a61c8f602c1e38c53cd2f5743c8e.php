<div class="dashboard__header single_border_bottom">
    <div class="row gx-4 align-items-center justify-content-between">
       <!--left sidebar open close start -->
        <div class="col-sm-2">
            <div class="dashboard__header__left">
                <div class="dashboard__header__left__inner">
                    <span class="dashboard__sidebarIcon__mobile sidebar-icon d-lg-none"></span>
                </div>
            </div>
        </div>
        <!--end -->

        <div class="col-sm-4">
            <div class="dashboard__header__right">
                <div class="dashboard__header__right__flex">
                    <!--search global search start -->
                     <?php echo $__env->make('backend.partials.global-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!-- end -->
                    <!--Dark and light mode start -->
                    <div class="dashboard__header__right__item">
                        <span  class="dark_mode_check dashboard__header__notification__icon <?php if(get_static_option('site_admin_dark_mode') == 'on'): ?> lightMode <?php else: ?> nightMode  <?php endif; ?>" id="mode_change">
                            <i class="material-symbols-outlined"></i>
                        </span>
                        <input type="hidden" value="<?php echo e(get_static_option('site_admin_dark_mode') ?? 'lightMode'); ?>" id="darkModeValue">
                    </div>
                    <!-- end -->
                    <!--Notifications start -->
                    <?php echo $__env->make('backend.partials.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--end -->
                    <!--Admin profile start -->
                    <div class="dashboard__header__right__item">
                        <div class="dashboard__header__author">
                            <a href="javascript:void(0)" class="dashboard__header__author__flex flex-btn">
                                <div class="dashboard__header__author__thumb">
                                    <?php if(!empty(auth()->guard('admin')->user()->image)): ?>
                                        <?php echo render_image_markup_by_attachment_id(auth()->guard('admin')->user()->image,'avatar user-thumb'); ?>

                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginalc1ff17f27b163a217d6db98cc98cfb19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image.user-no-image','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('image.user-no-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19)): ?>
<?php $attributes = $__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19; ?>
<?php unset($__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1ff17f27b163a217d6db98cc98cfb19)): ?>
<?php $component = $__componentOriginalc1ff17f27b163a217d6db98cc98cfb19; ?>
<?php unset($__componentOriginalc1ff17f27b163a217d6db98cc98cfb19); ?>
<?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="dashboard__header__author__wrapper">
                                <div class="dashboard__header__author__wrapper__list">
                                    <a href="<?php echo e(route('admin.profile.update')); ?>" class="dashboard__header__author__wrapper__list__item"><?php echo e(__('Edit Profile')); ?></a>
                                    <a href="<?php echo e(route('admin.profile.password.change')); ?>" class="dashboard__header__author__wrapper__list__item"><?php echo e(__('Password Change')); ?></a>
                                    <a href="<?php echo e(route('admin.logout')); ?>" class="dashboard__header__author__wrapper__list__item"><?php echo e(__('Log Out')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end -->

                    <div class="dashboard__header__right__item">
                     <a class="cmnBtn btn_5 radius-5 <?php if(get_static_option('site_admin_dark_mode') == 'off'): ?> btn_bg_blue <?php else: ?> btn-dark  <?php endif; ?>" target="_blank" href="<?php echo e(url('/')); ?>">
                            <i class="fas fa-external-link-alt mr-1"></i>   <?php echo e(__('View Site')); ?>

                          </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/partials/top-header.blade.php ENDPATH**/ ?>