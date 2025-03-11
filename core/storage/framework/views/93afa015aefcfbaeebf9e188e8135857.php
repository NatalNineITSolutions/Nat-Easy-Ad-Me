<div class="chat-wrapper-details-header profile-border-bottom flex-between" id="livechat-message-header"
    data-user-id="<?php echo e($data->user->id); ?>">
    <div class="chat-wrapper-details-header-left d-flex gap-2 align-items-center">
        <div class="chat-wrapper-details-header-left-author d-flex gap-2 align-items-center">
            <?php if($data->user?->image): ?>
                <div class="chat-wrapper-contact-list-thumb seller-img p-0 mb-3">
                    <?php echo render_image_markup_by_attachment_id($data->user?->image, '', 'thumb'); ?>

                </div>
            <?php else: ?>
                <div class="seller-img p-0">
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
                </div>
            <?php endif; ?>
            <div class="chat-wrapper-contact-list-thumb-contents">
                <h5 class="chat-wrapper-details-header-title"><?php echo e($data->user?->fullname); ?></h5>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\Modules/Chat\resources/views/member/message-header.blade.php ENDPATH**/ ?>