<!-- Membership Card Start-->
<section class="pricingCard plr" data-padding-top="<?php echo e($padding_top); ?>" data-padding-bottom="<?php echo e($padding_bottom); ?>">
    <div class="container-1440">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                <div class="section-tittle text-center mb-50">
                    <h2 class="head3"><?php echo e($title); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
        <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="singlePrice <?php if(!empty($user_current_membership) && $user_current_membership->membership_id === $membership->id): ?> active <?php endif; ?> mb-24 wow fadeInLeft" data-wow-delay="0.0s">
                        <h4 class="priceTittle"><?php echo e($membership->title); ?> </h4>
                        <span class="price"><?php echo e(float_amount_with_currency_symbol($membership->price)); ?>

                            <span class="subTittle"><?php echo e($membership->membership_type?->type); ?></span>
                        </span>
                        <div class="btn-wrapper">
                            <?php if($membership->price == 0): ?>
                                <!-- Free Membership Plan -->
                                <?php
                                    $buttonText = __('Get Started');
                                    $buttonUrl = url('/user-register');
                                ?>

                                  <?php if(!empty($user_current_membership) && $user_current_membership->membership_id === $membership->id): ?>
                                        <?php
                                            $buttonText = __('Current Plan');
                                            $buttonUrl = null;
                                        ?>
                                    <?php endif; ?>
                                <!--if user membership empty buy free membership -->
                                <?php if(empty($user_current_membership)): ?>
                                    <!--free membership form start -->
                                    <form action="<?php echo e(route('user.membership.buy')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="membership_id" class="membership_id" value="<?php echo e($membership->id); ?>">
                                        <input type="hidden" name="price" value="<?php echo e($membership->price); ?>">
                                        <input type="hidden" name="selected_payment_gateway" class="selected_payment_gateway" value="Trial">
                                        <button type="submit" class="cmn-btn-outline1"><?php echo e($buttonText); ?></button>
                                    </form>
                                    <!--free membership form end -->
                                <?php else: ?>
                                    <a href="<?php echo e($buttonUrl); ?>">
                                        <button class="cmn-btn-outline1"><?php echo e($buttonText); ?></button>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <!-- Paid Membership Plan -->
                                <?php

                                    if(empty($user_current_membership)){
                                       $buttonText = __('Buy Now');
                                     }else{
                                       $buttonText = __('Upgrade Now');
                                    }

                                     $modalTarget = '#loginModal';

                                       if(Auth::check() && Auth::guard('web')->user()){
                                           $modalTarget = '#paymentGatewayModal';
                                       }
                                       if(!empty($user_current_membership) && $user_current_membership->membership_id === $membership->id){
                                           $buttonText = __('Current Plan');
                                           $modalTarget = null;
                                       }
                                ?>
                                <button class="cmn-btn-outline1 choose_membership_plan"
                                        data-bs-toggle="modal"
                                        data-id="<?php echo e($membership->id); ?>"
                                        data-price="<?php echo e($membership->price); ?>"
                                        data-bs-target="<?php echo e($modalTarget); ?>">
                                    <?php echo e($buttonText); ?>

                                </button>
                            <?php endif; ?>
                        </div>

                        <ul class="listing mt-3">
                            <?php $__currentLoopData = $membership->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($feature->status == 'on'): ?>
                                    <li class="listItem check">
                                        <div class="checkicon me-2">
                                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z" fill="#22C55E"></path>
                                            </svg>
                                        </div>
                                        <?php echo e($feature->feature); ?>

                                    </li>
                                <?php else: ?>
                                    <li class="listItem">
                                        <div class="checkicon me-2">
                                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z" fill="#22C55E"></path>
                                            </svg>
                                        </div>
                                        <?php echo e($feature->feature); ?>

                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- End-of Membership -->
<?php if(Auth::check() && Auth::guard('web')->user()): ?>
    <?php echo $__env->make('membership::addon-view.gateway-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php else: ?>
    <?php echo $__env->make('membership::addon-view.login-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Membership\resources/views/addon-view/membership-plans.blade.php ENDPATH**/ ?>