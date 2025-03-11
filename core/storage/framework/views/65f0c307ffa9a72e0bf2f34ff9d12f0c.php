
<?php $__env->startSection('title'); ?>
    <?php echo e(__('User OTP Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('User OTP Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        #telephone.error {
            border-color: var(--main-color-one);
        }

        #telephone.success {
            border-color: var(--main-color-three);
        }

        .single-input .iti {
            width: 100%;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="loginArea section-padding2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-12 login-Wrapper">
                    <div class="text-center mb-3">
                        <h3 class="tittle"><?php echo e(__('OTP Sign In')); ?></h3>
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
                    <form action="<?php echo e(route('user.login.otp')); ?>" method="post" enctype="multipart/form-data"  class="account-form" id="login_form_order_page">
                        <?php echo csrf_field(); ?>
                        <div class="error-wrap"></div>
                        <div class="row">
                            <div class="col-12">
                                <label class="infoTitle"><?php echo e(__('Phone Number')); ?></label>
                                <div class="input-form input-form2">
                                    <input type="hidden" id="country-code" name="country_code">
                                    <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" id="phone" placeholder="<?php echo e(__('Type Phone')); ?>">
                                    <span id="phone_availability"></span>

                                    <div class="d-none">
                                        <span id="error-msg" class="hide"></span>
                                        <p id="result" class="d-none"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="btn-wrapper text-center mt-30">
                                    <button type="submit" id="login_btn"  class="cmn-btn4 w-100 mb-60 verify-account"><?php echo e(__('Send OTP')); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="info mt-3"><?php echo e(__("Do not have an account")); ?>

                        <a href="<?php echo e(route('user.login')); ?>"   class="active"> <strong><?php echo e(__('Sign In')); ?></strong> </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <?php echo $__env->make('smsgateway::user.phone-number-check', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/SMSGateway\resources/views/user/login-otp.blade.php ENDPATH**/ ?>