<table class="table">
    <thead class="table-head-light">
    <tr>
        <th><?php echo e(__('Payment Gateway')); ?></th>
        <th><?php echo e(__('Payment Status')); ?></th>
        <th><?php echo e(__('Deposit Amount')); ?></th>
        <th><?php echo e(__('Deposit Date')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $user_wallet_histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
                <?php if($history->payment_gateway == 'manual_payment'): ?>
                    <?php echo e(ucfirst(str_replace('_',' ',$history->payment_gateway))); ?>

                <?php else: ?>
                    <?php echo e($history->payment_gateway == 'authorize_dot_net' ? __('Authorize.Net') : ucfirst($history->payment_gateway)); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php if($history->payment_status == '' || $history->payment_status == 'cancel'): ?>
                    <span class="status cancel-status"><?php echo e(__('Cancel')); ?></span>
                <?php elseif($history->payment_status == 'pending'): ?>
                    <span class="status pending-status"><?php echo e(__('Pending')); ?></span>
                <?php elseif($history->payment_status == 'complete'): ?>
                    <span class="status accepted-status"><?php echo e(__('Completed')); ?></span>
                <?php endif; ?>
            </td>
            <td><?php echo e(float_amount_with_currency_symbol($history->amount)); ?></td>
            <td><?php echo e($history->created_at); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr class="text-center">
                <td colspan="4"><?php echo e(__('No wallet history found.')); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="deposit-history-pagination mb-4">
    <?php if (isset($component)) { $__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pagination.laravel-paginate','data' => ['allData' => $user_wallet_histories]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pagination.laravel-paginate'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['allData' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user_wallet_histories)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f)): ?>
<?php $attributes = $__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f; ?>
<?php unset($__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f)): ?>
<?php $component = $__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f; ?>
<?php unset($__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\Modules/Wallet\resources/views/user/wallet/search-result.blade.php ENDPATH**/ ?>