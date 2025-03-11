<div class="modal fade" id="paymentGatewayModal" tabindex="-1" aria-labelledby="paymentGatewayModalLabel" aria-hidden="true">
    <div class="modal-dialog ab">
        <form action="<?php echo e(route('user.wallet.deposit')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="paymentGatewayModalLabel"><?php echo e($title ?? ''); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($component)) { $__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.text','data' => ['type' => 'number','title' => __('Enter Deposit Amount'),'name' => 'amount','id' => 'amount','placeholder' => __('Max Limit: '). get_static_option('deposit_amount_limitation_for_user') ?? '3000' ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('number'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Enter Deposit Amount')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('amount'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('amount'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Max Limit: '). get_static_option('deposit_amount_limitation_for_user') ?? '3000' )]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2)): ?>
<?php $attributes = $__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2; ?>
<?php unset($__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2)): ?>
<?php $component = $__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2; ?>
<?php unset($__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2); ?>
<?php endif; ?>
                    <div class="confirm-payment payment-border">
                        <div class="single-checkbox">
                            <div class="checkbox-inlines">
                                <label class="checkbox-label" for="check2">
                                    <?php echo \App\Helpers\PaymentGatewayRenderHelper::renderPaymentGatewayForForm(); ?>

                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-wrapper d-flex align-items-center gap-3">
                        <button type="button" class="red-global-close-btn" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                        <?php if (isset($component)) { $__componentOriginal632b1038db5541c1a915a7b91a4b9d06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal632b1038db5541c1a915a7b91a4b9d06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn.submit-btn','data' => ['title' => __('Deposit'),'class' => 'red-global-btn deposit_amount_to_wallet']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('btn.submit-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Deposit')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('red-global-btn deposit_amount_to_wallet')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal632b1038db5541c1a915a7b91a4b9d06)): ?>
<?php $attributes = $__attributesOriginal632b1038db5541c1a915a7b91a4b9d06; ?>
<?php unset($__attributesOriginal632b1038db5541c1a915a7b91a4b9d06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal632b1038db5541c1a915a7b91a4b9d06)): ?>
<?php $component = $__componentOriginal632b1038db5541c1a915a7b91a4b9d06; ?>
<?php unset($__componentOriginal632b1038db5541c1a915a7b91a4b9d06); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/frontend/payment-gateway/gateway-markup.blade.php ENDPATH**/ ?>