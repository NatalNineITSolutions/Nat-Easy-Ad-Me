<div class="singleUser chat_item" data-user-id="<?php echo e($memberChat?->user?->id); ?>">
    <div class="listCap">
        <div class="userProduct-group">
            <!-- product & user img -->
            <div class="userProduct-img seller-img p-0">
                <?php if($memberChat?->user?->image): ?>
                    <?php echo render_image_markup_by_attachment_id($memberChat?->user?->image, '', 'thumb'); ?>

                <?php else: ?>
                   <?php if (isset($component)) { $__componentOriginalc1ff17f27b163a217d6db98cc98cfb19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image.user-no-image','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('image.user-no-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19)): ?>
<?php $attributes = $__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19; ?>
<?php unset($__attributesOriginalc1ff17f27b163a217d6db98cc98cfb19); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1ff17f27b163a217d6db98cc98cfb19)): ?>
<?php $component = $__componentOriginalc1ff17f27b163a217d6db98cc98cfb19; ?>
<?php unset($__componentOriginalc1ff17f27b163a217d6db98cc98cfb19); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="notification-dots <?php echo e(Cache::has('user_is_online_' . $memberChat?->user?->id) ? "active" : ""); ?>"></div>
        </div>
        <div class="proCaption">
            <h5>
                <a href="#" class="messageTittle"><?php echo e($memberChat?->user?->fullname); ?></a>
            </h5>
            <div class ="unseen_message_count_<?php echo e($memberChat?->user->id); ?>">
                <?php if($memberChat->member_unseen_msg_count > 0): ?>
                    <span class="pricing"><?php echo e($memberChat->member_unseen_msg_count); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="timmer mb-20">
        <span class="time"><?php echo e($memberChat->user?->check_online_status?->diffForHumans()); ?></span>
    </div>
</div>

<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Chat\resources/views/components/member/user-list.blade.php ENDPATH**/ ?>