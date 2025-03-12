
<?php $__env->startSection('site_title'); ?>
    <?php echo e(__('Listing Favorite')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
   <style>
       .recentImg {
           width: 150px;
       }

       .favorite_add_icon {
           color: var(--main-color-one);
           font-size: 24px;
           margin-right: 6px;
           position: relative;
           top: 2px;
       }

       .favorite_remove_icon {
           font-size: 24px;
           margin-right: 6px;
           position: relative;
           top: 2px;
       }

   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="profile-setting favourite-ads section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        <?php echo $__env->make('frontend.user.layout.partials.user-profile-background-image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="down-body-wraper">
                            <?php echo $__env->make('frontend.user.layout.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="main-body">
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
                                <div class="relevant-ads all-listings box-shadow1">
                                    <h4 class="dis-title"><?php echo e(__('All Favorite Listing')); ?></h4>
                                    <div class="add-wraper">
                                        <?php if($user_all_favorite->count() > 0): ?>
                                            <?php $__currentLoopData = $user_all_favorite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favorite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="single-add-card">
                                                    <div class="single-add-image">
                                                        <?php echo render_image_markup_by_attachment_id(optional($favorite->listing)->image,'','thumb'); ?>

                                                    </div>
                                                    <div class="single-add-body">
                                                        <h4 class="add-heading head4">
                                                            <a href="<?php echo e(route('frontend.listing.details',optional($favorite->listing)->slug ?? 'x')); ?>" target="_blank">
                                                              <?php echo e(optional($favorite->listing)->title); ?>

                                                            </a>
                                                        </h4>
                                                        <div class="pricing head4"><?php echo e(amount_with_currency_symbol(optional($favorite->listing)->price)); ?></div>
                                                        <div class="btn-wrapper">
                                                            <?php if($favorite->listing->is_featured === 1): ?>
                                                                <span class="pro-btn2">
                                                                    <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white"/>
                                                                    </svg>
                                                                   <?php echo e(__('FEATURED')); ?>

                                                                 </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if(!empty($favorite->listing?->address)): ?>
                                                            <div class="locations">
                                                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                                <span><?php echo e($favorite->listing?->address); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="dates">
                                                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9 7.83333L7 6.5V3.16667M1 6.5C1 7.28793 1.15519 8.06815 1.45672 8.7961C1.75825 9.52405 2.20021 10.1855 2.75736 10.7426C3.31451 11.2998 3.97595 11.7417 4.7039 12.0433C5.43185 12.3448 6.21207 12.5 7 12.5C7.78793 12.5 8.56815 12.3448 9.2961 12.0433C10.0241 11.7417 10.6855 11.2998 11.2426 10.7426C11.7998 10.1855 12.2417 9.52405 12.5433 8.7961C12.8448 8.06815 13 7.28793 13 6.5C13 5.71207 12.8448 4.93185 12.5433 4.2039C12.2417 3.47595 11.7998 2.81451 11.2426 2.25736C10.6855 1.70021 10.0241 1.25825 9.2961 0.956723C8.56815 0.655195 7.78793 0.5 7 0.5C6.21207 0.5 5.43185 0.655195 4.7039 0.956723C3.97595 1.25825 3.31451 1.70021 2.75736 2.25736C2.20021 2.81451 1.75825 3.47595 1.45672 4.2039C1.15519 4.93185 1 5.71207 1 6.5Z" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                            <span><?php echo e($favorite->created_at?->diffForHumans()); ?></span>
                                                        </div>
                                                        <?php if (isset($component)) { $__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listings.favorite-item-add-remove','data' => ['favorite' => $favorite->listing_id ?? 0]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listings.favorite-item-add-remove'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['favorite' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($favorite->listing_id ?? 0)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971)): ?>
<?php $attributes = $__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971; ?>
<?php unset($__attributesOriginalc2fc75d0bc36b6ea33254b67b8ea1971); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971)): ?>
<?php $component = $__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971; ?>
<?php unset($__componentOriginalc2fc75d0bc36b6ea33254b67b8ea1971); ?>
<?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <div class="blog-pagination">
                                                <div class="custom-pagination mt-4 mt-lg-5">
                                                    <?php echo $user_all_favorite->links(); ?>

                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <?php if (isset($component)) { $__componentOriginal3f9c527cb64b91d88649358c43ef5eb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pagination.empty-data-placeholder','data' => ['title' => __('No Favorite Listing Yet')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pagination.empty-data-placeholder'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('No Favorite Listing Yet'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0)): ?>
<?php $attributes = $__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0; ?>
<?php unset($__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f9c527cb64b91d88649358c43ef5eb0)): ?>
<?php $component = $__componentOriginal3f9c527cb64b91d88649358c43ef5eb0; ?>
<?php unset($__componentOriginal3f9c527cb64b91d88649358c43ef5eb0); ?>
<?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/backend/js/sweetalert2.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/user/listings-favorite/all-favorite.blade.php ENDPATH**/ ?>