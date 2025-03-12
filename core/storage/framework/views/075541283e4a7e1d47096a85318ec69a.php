<table class="table">
    <thead class="table-head-light">
    <tr>
        <th><?php echo e(__('Plan')); ?></th>
        <th><?php echo e(__('Amount')); ?></th>
        <th><?php echo e(__('Date')); ?></th>
        <th><?php echo e(__('Payment Method')); ?></th>
        <th><?php echo e(__('Payment Status')); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $all_memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($membership->membership?->membership_type?->type); ?></td>
            <td><?php echo e(float_amount_with_currency_symbol($membership->price)); ?></td>
            <td><?php echo e($membership->created_at->format('Y-m-d') ?? ''); ?></td>
            <td>
                <?php if($membership->payment_gateway == 'manual_payment'): ?>
                    <?php echo e(ucfirst(str_replace('_',' ',$membership->payment_gateway))); ?>

                <?php else: ?>
                    <?php echo e($membership->payment_gateway == 'authorize_dot_net' ? __('Authorize.Net') : ucfirst($membership->payment_gateway)); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php if($membership->payment_status == '' || $membership->payment_status == 'cancel'): ?>
                    <span class="status cancel-status"><?php echo e(__('Cancel')); ?></span>
                <?php elseif($membership->payment_status == 'pending'): ?>
                    <span class="status pending-status"><?php echo e(__('Pending')); ?></span>
                <?php else: ?>
                    <span class="status accepted-status"><?php echo e(ucfirst($membership->payment_status)); ?></span>
                <?php endif; ?>

               <!-- membership payment history modal button -->
                <a class="cmnBtn btn_5 btn_bg_warning radius-5 show_membership_payment_history_modal"
                   data-bs-toggle="modal"
                   data-bs-target="#user_membership_payment_history_modal"
                   data-membership_history_id="<?php echo e($membership->id); ?>"
                   data-membership_type="<?php echo e($membership->membership?->membership_type?->type); ?>"
                   data-membership_purchase_date_history="<?php echo e($membership->created_at->format('Y-m-d') ?? ''); ?>"
                   data-membership_expire_date_history="<?php echo e(Carbon\Carbon::parse($membership->expire_date)->format('Y-m-d')); ?>"

                   data-listing_limit="<?php echo e($membership->listing_limit); ?>"
                   data-gallery_images="<?php echo e($membership->gallery_images); ?>"
                   data-featured_listing="<?php echo e($membership->featured_listing); ?>"
                   data-business_hour="<?php echo e($membership->business_hour); ?>"
                   data-enquiry_form="<?php echo e($membership->enquiry_form); ?>"
                   data-membership_badge="<?php echo e($membership->membership_badge); ?>"
                >
                    <i class="fa-solid fa-angle-right ms-3"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<div class="deposit-history-pagination mt-4">
    <?php if (isset($component)) { $__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pagination.laravel-paginate','data' => ['allData' => $all_memberships]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pagination.laravel-paginate'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['allData' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($all_memberships)]); ?>
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
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Membership\resources/views/frontend/user/membership/search-result.blade.php ENDPATH**/ ?>