
<?php $__env->startSection('site_title',__('Wallet History')); ?>
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
    <div class="profile-setting setting-page-with-table wallet-page section-padding2">
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
                                <div class="memberShipCart">
                                    <div class="singleMember mb-24">
                                        <div class="memberDetails">
                                            <p><?php echo e(__('Available Balance:')); ?></p>
                                            <h4 class="balance-wallet"><?php echo e(float_amount_with_currency_symbol($total_wallet_balance ?? 00)); ?></h4>
                                        </div>
                                        <div class="btn-wrapper mb-20">
                                            <button class="red-btn" data-bs-toggle="modal" data-bs-target="#paymentGatewayModal"><?php echo e(__('Deposit to Wallet')); ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="paymentTable">
                                    <div class="single-profile-settings" id="display_client_profile_info">
                                        <div class="single-profile-settings-header">
                                            <?php if (isset($component)) { $__componentOriginalfc4e3c8108f5f9458dc90e11adc2a670 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc4e3c8108f5f9458dc90e11adc2a670 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notice.general-notice','data' => ['description' => __('Notice: Using Deposit balance you can buy membership plan')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('notice.general-notice'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Notice: Using Deposit balance you can buy membership plan'))]); ?>
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
                                            <div class="single-profile-settings-header-flex">
                                                <h4 class="memberTittle"><?php echo e(__('Wallet History')); ?></h4>
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
                                                <?php echo $__env->make('wallet::user.wallet.search-result', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <?php if (isset($component)) { $__componentOriginal00b6a2a0f4a7fa69cf6a91f32a15b538 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal00b6a2a0f4a7fa69cf6a91f32a15b538 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.payment-gateway.gateway-markup','data' => ['title' => __('Deposit to Wallet')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.payment-gateway.gateway-markup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Deposit to Wallet'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal00b6a2a0f4a7fa69cf6a91f32a15b538)): ?>
<?php $attributes = $__attributesOriginal00b6a2a0f4a7fa69cf6a91f32a15b538; ?>
<?php unset($__attributesOriginal00b6a2a0f4a7fa69cf6a91f32a15b538); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal00b6a2a0f4a7fa69cf6a91f32a15b538)): ?>
<?php $component = $__componentOriginal00b6a2a0f4a7fa69cf6a91f32a15b538; ?>
<?php unset($__componentOriginal00b6a2a0f4a7fa69cf6a91f32a15b538); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('wallet::user.wallet.wallet-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Wallet\resources/views/user/wallet/wallet-history.blade.php ENDPATH**/ ?>