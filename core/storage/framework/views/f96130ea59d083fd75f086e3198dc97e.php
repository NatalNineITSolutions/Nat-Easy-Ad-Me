
<?php $__env->startSection('title'); ?>
    <?php echo e(__('User OTP Verification')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Verify OTP')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .active:hover{
            color: var(--main-color-one);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="loginArea section-padding2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-12 login-Wrapper">
                    <div class="text-center mb-3">
                        <h3 class="tittle"><?php echo e(__('Verify OTP')); ?></h3>
                        <h5 class="countdown text-center my-2"></h5>
                        <div class="alert alert-info alert-bs-dismissible fade show mt-5 mb-1 mx-auto d-inline-block"
                             role="alert"> <?php echo e(__('An OTP has been sent on your phone number.')); ?>

                        </div>
                    </div>
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
                        <form action="<?php echo e(route('user.login.otp.verification')); ?>" method="post" enctype="multipart/form-data" class="account-form" id="login_form_order_page">
                            <?php echo csrf_field(); ?>
                            <div class="error-wrap"></div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="exampleInputEmail1" class="infoTitle"><?php echo e(__('OTP Code')); ?> </label>
                                    <div class="input-form input-form2">
                                      <input class="form--control" type="number" name="otp" value="<?php echo e(old('otp')); ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="btn-wrapper text-center mt-50">
                                        <button type="submit" id="login_btn"  class="cmn-btn4 w-100 mb-60 verify-account"><?php echo e(__('Verify OTP')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <p class="info mt-3 d-flex justify-content-between">
                        <a href="<?php echo e(route('user.login.otp')); ?>" class="active"> <?php echo e(__('Update number?')); ?> </a>
                        <a href="<?php echo e(route('user.login.otp.resend')); ?>" class="active"> <?php echo e(__('Resend OTP code again?')); ?> </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php
        $expire_time = 0;

        if (!empty($userOtp) && !now()->isAfter($userOtp->expire_date)){
            $expire_time = $userOtp ? now()->diffInRealSeconds($userOtp->expire_date) : 0;
        }
    ?>
    <script>
        let expire_time = `<?php echo e($expire_time); ?>`;

        let interval = setInterval(function() {
            if (expire_time > 0)
            {
                expire_time--;
            }

            let countdown = $('.countdown');
            if (parseInt(expire_time) === 0)
            {
                countdown.removeClass('text-dark').addClass('text-danger').text(`<?php echo e(__('The OTP is expired')); ?>`)
                return clearInterval(interval);
            }

            countdown.addClass('text-dark').text(expire_time + ` <?php echo e(__('Seconds')); ?>`)
        }, 1000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\easyadme\core\Modules/SMSGateway\resources/views/user/otp-verify.blade.php ENDPATH**/ ?>