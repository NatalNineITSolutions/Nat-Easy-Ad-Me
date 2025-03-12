<div class="modal fade" id="renew_membership_modal" tabindex="-1" aria-labelledby="paymentGatewayModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('user.membership.renew')); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="membership_id" id="membership_id">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <?php if(Auth::guard('web')->check()): ?>
                       <h4><?php echo e(get_static_option('membership_renew_modal_title') ?? __('Renew Membership')); ?></h4>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginalfc4e3c8108f5f9458dc90e11adc2a670 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc4e3c8108f5f9458dc90e11adc2a670 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notice.general-notice','data' => ['description' => __('Notice: Please login as a user to buy a membership.')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('notice.general-notice'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Notice: Please login as a user to buy a membership.'))]); ?>
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
                    <?php endif; ?>
                </div>
                <div class="modal-body">
                    <div class="confirm-payment payment-border">
                        <div class="single-checkbox">
                            <div class="checkbox-inlines">
                                <label class="checkbox-label load_after_login" for="choose">
                                    <?php if(Auth::check() && Auth::user()->user_wallet?->balance > 0): ?>
                                        <?php if(moduleExists('Wallet')): ?>
                                             <?php echo \App\Helpers\PaymentGatewayRenderHelper::renderWalletForm(); ?>

                                        <?php endif; ?>
                                        <span class="wallet-balance mt-2 d-block"><?php echo e(__('Wallet Balance:')); ?>

                                            <strong class="main-balance"><?php echo e(float_amount_with_currency_symbol(Auth::user()->user_wallet?->balance)); ?></strong></span>
                                        <br>
                                        <span class="display_balance"></span>
                                        <br>
                                        <span class="deposit_link"></span>
                                    <?php endif; ?>
                                    <?php echo \App\Helpers\PaymentGatewayRenderHelper::renderPaymentGatewayForForm(); ?>

                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-wrapper">
                        <button type="button" class="btn-profile btn-outline-gray btn-hover-danger" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                        <?php if(Auth::guard('web')->check()): ?>
                            <button type="submit" class="btn-profile btn-bg-1 buy_membership" id="confirm_buy_membership_load_spinner">
                                <?php echo e(__('Buy Now')); ?> <span id="buy_membership_load_spinner"></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Membership\resources/views/frontend/user/membership/renew-gateway-markup.blade.php ENDPATH**/ ?>