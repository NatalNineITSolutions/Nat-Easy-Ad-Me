
<?php $__env->startSection('site_title',__('Membership')); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .search_wrapper {
            display: flex;
            justify-content: flex-end;
        }
        input#string_search {
            padding: 10px;
            border: 1px solid #DFDFDF;
            border-radius: 6px;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="profile-setting menberhsip-plan-new setting-page-with-table section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        <?php echo $__env->make('frontend.user.layout.partials.user-profile-background-image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="down-body-wraper">
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
                                <div class="your-plan d-flex justify-content-between align-items-center">
                                    <h3 class="your-plan-head"><?php echo e(__('Your Plan')); ?></h3>
                                    <div class="see-all-plan-btn">
                                        <?php
                                             $page_url = \App\Models\Backend\Page::find(get_static_option('membership_plan_page'));
                                        ?>
                                        <a href="<?php if($page_url): ?> <?php echo e(url('/' . $page_url->slug)); ?><?php endif; ?>"><?php echo e(__('See All Plans')); ?> <i class="fa-solid fa-angle-right"></i> </a>

                                    </div>
                                </div>

                                <?php echo $__env->make('membership::frontend.user.membership.user-dashboard-membership-plans', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <?php if(!empty($user_membership)): ?>
                                  <!--Membership section start -->
                                    <div class="memberShipCart mt-3">
                                        <!-- Single -->
                                        <div class="singleMember mb-24 box-shadow1">
                                            <div class="memberDetails">
                                                <div class="d-flex align-items-center gap-3 justify-content-between mb-4">
                                                    <h4 class="memberTittle"><?php echo e(__('Verified Membership')); ?>

                                                        <?php if(!empty($user_membership)): ?>
                                                            <?php
                                                                $today = now();
                                                                $expireDate = \Carbon\Carbon::parse($user_membership->expire_date);
                                                            ?>
                                                            <?php if($expireDate >= $today && $user_membership->payment_status == 'complete' && $user_membership->status === 1): ?>
                                                                <span class="activeUser"> <?php echo e(__('Active')); ?> </span>
                                                            <?php elseif($expireDate >= $today && $user_membership->payment_status == 'pending' && $user_membership->status === 0): ?>
                                                                <span class="status pending-status"> <?php echo e(__('Inactive')); ?> </span>
                                                            <?php elseif($expireDate >= $today && $user_membership->payment_status == 'complete' && $user_membership->status === 0): ?>
                                                                <span class="status pending-status"> <?php echo e(__('Inactive')); ?> </span>
                                                            <?php elseif($expireDate >= $today && empty($user_membership->payment_status) && $user_membership->status === 0): ?>
                                                                <span class="status pending-status"> <?php echo e(__('Inactive')); ?> </span>
                                                            <?php else: ?>
                                                                <span class="status cancel-status"> <?php echo e(__('Expire')); ?> </span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </h4>

                                                    <!--Current Membership modal button -->
                                                    <div class="btn-wrapper">
                                                        <a href="#" class="red-btn view-details-btn"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#current_membership_modal"
                                                           data-renew_id="<?php echo e($user_membership->membership_id); ?>">
                                                            <?php echo e(get_static_option('current_membership_button_title') ?? __('View')); ?>

                                                        </a>

                                                        <!--renew button -->
                                                        <?php if(!empty($user_membership)): ?>
                                                            <?php if($user_membership->price != 0): ?>
                                                                <?php
                                                                    $today = now();
                                                                    $expireDate = \Carbon\Carbon::parse($user_membership->expire_date);
                                                                    $daysUntilExpiration = $today->diffInDays($expireDate);
                                                                    $renew_expire_days = intval(get_static_option('renew_button_before_expire_days')) ?? 7;
                                                                ?>

                                                                 <a href="<?php if($page_url): ?> <?php echo e(url('/' . $page_url->slug)); ?><?php endif; ?>"  class="red-global-btn"> <?php echo e(__('Upgrade')); ?></a>

                                                                <!-- If not expired, payment status is complete, and within 7 days, show the renewal button -->
                                                                <?php if($user_membership->payment_status == 'complete' && $expireDate >= $today &&
                                                                    ($daysUntilExpiration <= $renew_expire_days ||
                                                                    $user_membership->listing_limit == 0 ||
                                                                    $user_membership->featured_listing == 0)): ?>
                                                                    <a href="#"
                                                                       class="red-btn renew_current_membership"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#renew_membership_modal"
                                                                       data-renew_id="<?php echo e($user_membership->membership_id); ?>"
                                                                    ><?php echo e(get_static_option('membership_renew_button_title') ?? __('Renew Current Membership')); ?></a>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="infoSingle d-flex justify-content-between">
                                                    <ul class="listing">
                                                        <li class="listItem">
                                                            <strong><?php echo e(__('Billing:')); ?></strong>
                                                            <?php echo e($user_membership->membership?->membership_type?->type); ?>

                                                        </li>
                                                        <li class="listItem">
                                                            <span class="text-danger"><?php echo e(__('Expire Date:')); ?></span>
                                                            <?php echo e(\Carbon\Carbon::parse($user_membership->expire_date)->isoFormat('DD, MMM YYYY')); ?>

                                                        </li>
                                                        <?php if($user_membership->price != 0): ?>
                                                            <li class="listItem">
                                                                <?php echo e(calculateMembershipRemainingTime($user_membership->expire_date)); ?>

                                                                <?php echo e(__('remaining to next invoice')); ?>

                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /END -->

                                    <div class="paymentTable mt-4">
                                        <div class="single-profile-settings" id="display_client_profile_info">
                                            <div class="single-profile-settings-header">
                                                <div class="single-profile-settings-header-flex">
                                                    <h4 class="memberTittle"><?php echo e(__('Membership History')); ?></h4>
                                                    <?php if (isset($component)) { $__componentOriginal1c644339b8125d460a833ce180d39d8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c644339b8125d460a833ce180d39d8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search.search-in-table','data' => ['id' => 'string_search','placeholder' => __('Enter date to search'),'class' => 'form-control radius-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search.search-in-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('string_search'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Enter date to search')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('form-control radius-10')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c644339b8125d460a833ce180d39d8a)): ?>
<?php $attributes = $__attributesOriginal1c644339b8125d460a833ce180d39d8a; ?>
<?php unset($__attributesOriginal1c644339b8125d460a833ce180d39d8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c644339b8125d460a833ce180d39d8a)): ?>
<?php $component = $__componentOriginal1c644339b8125d460a833ce180d39d8a; ?>
<?php unset($__componentOriginal1c644339b8125d460a833ce180d39d8a); ?>
<?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="single-profile-settings-inner profile-border-top">
                                                <div class="custom_table style-04 search_result">
                                                    <?php echo $__env->make('membership::frontend.user.membership.search-result', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   <!--Membership section end -->
                                <?php endif; ?>
                            </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('membership::addon-view.gateway-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('membership::frontend.user.membership.renew-gateway-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--user current membership info-->
    <?php echo $__env->make('membership::frontend.user.membership.user-current-membership-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('membership::frontend.user.membership.user-membership-payment-history-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('membership::frontend.user.membership.membership-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('membership::frontend.user.membership.user-membership-payment-history-modal-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Membership\resources/views/frontend/user/membership/membership.blade.php ENDPATH**/ ?>