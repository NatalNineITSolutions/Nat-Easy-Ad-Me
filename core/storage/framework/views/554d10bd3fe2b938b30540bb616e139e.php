<div class="dashboard__header__right__item">
    <div class="dashboard__header__notification">
        <a href="javascript:void(0)" class="dashboard__header__notification__icon"> <i class="material-symbols-outlined"><?php echo e(__('Notifications')); ?></i> </a>
        <span class="dashboard__header__notification__number"><?php echo e(\App\Models\Backend\AdminNotification::unread_notification()->count()); ?></span>

        <div class="dashboard__header__notification__wrap">
            <h6 class="dashboard__header__notification__wrap__title"> <?php echo e(__('Notifications')); ?> </h6>
            <ul class="dashboard__header__notification__wrap__list">
                <!-- Display notification details -->
                <?php $__currentLoopData = \App\Models\Backend\AdminNotification::unread_notification(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal490458c95aeb080b7e15e01e1efd6725 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal490458c95aeb080b7e15e01e1efd6725 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.backend.admin-notification-in-top','data' => ['notification' => $notification]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('backend.admin-notification-in-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notification' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal490458c95aeb080b7e15e01e1efd6725)): ?>
<?php $attributes = $__attributesOriginal490458c95aeb080b7e15e01e1efd6725; ?>
<?php unset($__attributesOriginal490458c95aeb080b7e15e01e1efd6725); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal490458c95aeb080b7e15e01e1efd6725)): ?>
<?php $component = $__componentOriginal490458c95aeb080b7e15e01e1efd6725; ?>
<?php unset($__componentOriginal490458c95aeb080b7e15e01e1efd6725); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <a href="<?php echo e(route('admin.notification.all')); ?>" class="dashboard__header__notification__wrap__btn"> <?php echo e(__('See All Notification')); ?> </a>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/backend/partials/notifications.blade.php ENDPATH**/ ?>