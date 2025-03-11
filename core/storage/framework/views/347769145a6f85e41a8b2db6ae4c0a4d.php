<?php
    $listing = json_decode(json_encode($message->message['listing']));
?>
<?php if($message->from_user == 1): ?>
    <div class="leftMessage chat-reply">
        <!-- single-->
        <div class="singleLeft-message">
            <div class="messageText">

                <div class="messageImg">
                    <?php if($data->user?->image): ?>
                        <?php echo render_image_markup_by_attachment_id($data->user?->image, '', 'thumb'); ?>

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

                <div class="messageCaption">
                    <?php if(!empty($message->message['message'])): ?>
                        <p class="messagePera"><?php echo e($message->message['message'] ?? ''); ?></p>
                    <?php endif; ?>

                        <?php if(!empty($message->file)): ?>
                            <br />
                            <br />
                            <img src="<?php echo e(asset('assets/uploads/media-uploader/live-chat/'. $message->file)); ?>" alt="" style="max-height: 150px">
                                <?php
                                $ext = pathinfo($message->file, PATHINFO_EXTENSION);
                                ?>
                            <?php if($ext == 'pdf'): ?>
                                <a class="download-pdf-chat" href="<?php echo e(asset('assets/uploads/media-uploader/live-chat/'. $message->file)); ?>" download><?php echo e(__('Download pdf')); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(!empty($listing)): ?>
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <?php echo render_image_markup_by_attachment_id($listing->image, '', 'thumb'); ?>

                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo e($listing->title); ?></h5>
                                            <a class="red-global-btn" target="_blank"
                                               href="<?php echo e(route('frontend.listing.details', ['username' => $listing->username, 'slug' => $listing->slug])); ?>">
                                                <?php echo e(__('View details')); ?>

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <span  class="sendTime"><?php echo e($message->created_at->diffForHumans()); ?></span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if($message->from_user == 2): ?>
    <div class="rightMessage chat-reply">
        <!-- single-->
        <div class="singleRight-message">
            <div class="messageText">
                <div class="messageCaption">
                    <?php if(!empty($message->message['message'])): ?>
                        <p class="messagePera"><?php echo e($message->message['message'] ?? ''); ?></p>
                    <?php endif; ?>
                    <?php if(!empty($message->file)): ?>
                        <br />
                        <br />
                        <img src="<?php echo e(asset('assets/uploads/media-uploader/live-chat/'. $message->file)); ?>" alt="" style="max-height: 150px">
                            <?php
                            $ext = pathinfo($message->file, PATHINFO_EXTENSION);
                            ?>
                        <?php if($ext == 'pdf'): ?>
                            <a class="download-pdf-chat" href="<?php echo e(asset('assets/uploads/media-uploader/live-chat/'. $message->file)); ?>" download><?php echo e(__('Download pdf')); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if(!empty($listing)): ?>
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <?php echo render_image_markup_by_attachment_id($listing->image, '', 'thumb'); ?>

                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($listing->title); ?></h5>
                                        <a class="red-global-btn" target="_blank"
                                           href="<?php echo e(route('frontend.listing.details', ['username' => $listing->username, 'slug' => $listing->slug])); ?>">
                                            <?php echo e(__('View details')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <span class="sendTime"><?php echo e($message->created_at->diffForHumans()); ?></span>
                </div>

                <div class="messageImg">
                    <?php if($data->member?->image): ?>
                        <?php echo render_image_markup_by_attachment_id($data->member?->image, '', 'thumb'); ?>

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

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\Modules/Chat\resources/views/components/member/message.blade.php ENDPATH**/ ?>