<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="membership_price">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="LoginModalLabel">
                        <?php echo e(__('Login to buy Membership')); ?>

                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <?php if (isset($component)) { $__componentOriginalfc4e3c8108f5f9458dc90e11adc2a670 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc4e3c8108f5f9458dc90e11adc2a670 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notice.general-notice','data' => ['description' => __('Notice: You must login as a user to buy a membership')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('notice.general-notice'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Notice: You must login as a user to buy a membership'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc4e3c8108f5f9458dc90e11adc2a670)): ?>
<?php $attributes = $__attributesOriginalfc4e3c8108f5f9458dc90e11adc2a670; ?>
<?php unset($__attributesOriginalfc4e3c8108f5f9458dc90e11adc2a670); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc4e3c8108f5f9458dc90e11adc2a670)): ?>
<?php $component = $__componentOriginalfc4e3c8108f5f9458dc90e11adc2a670; ?>
<?php unset($__componentOriginalfc4e3c8108f5f9458dc90e11adc2a670); ?>
<?php endif; ?>
                    <div class="error-message"></div>
                    <div class="input-form">
                        <label class="infoTitle"><?php echo e(__('Email Or User Name')); ?></label>
                        <input class="form-control radius-10" type="text" name="username" id="username" placeholder="<?php echo e(__('Email Or User Name')); ?>">
                    </div>

                    <div class="single-input mt-4">
                        <label class="label-title mb-2"> <?php echo e(__('Password')); ?> </label>
                        <div class="input-form position-relative">
                            <input class="form-control radius-10" type="password" name="password" id="password" placeholder="<?php echo e(__('Type Password')); ?>">
                            <div class="icon toggle-password position-absolute">
                                <i class="las la-eye icon"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer flex-column">
                    <div class="btn-wrapper text-center">
                        <button type="submit" class="cmn-btn4 w-100 mb-60 login_to_buy_a_membership"><?php echo e(__('Login')); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Membership\resources/views/addon-view/login-markup.blade.php ENDPATH**/ ?>