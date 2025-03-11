<?php if(moduleExists("Chat")): ?>
    <?php if(is_null($listing->admin_id) && $listing->user_id != null && $listing->user_id != 0): ?>
        <?php if(auth()->check() && Auth::guard('web')->user()->id !== $listing->user_id): ?>
            <?php if(auth()->check()): ?>
                <?php if($listing->user_id !== Auth::guard('web')->user()->id): ?>
                    <div class="btn-wrapper">
                        <form action="<?php echo e(route('user.message.send')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="member_id" id="member_id" value="<?php echo e($listing->user_id); ?>">
                            <input type="hidden" name="from_user" id="from_user"  value="<?php echo e(Auth::guard('web')->user()->id); ?>">
                            <input type="hidden" name="listing_id" id="listing_id"  value="<?php echo e($listing->id); ?>">
                            <div class="send-massage">
                                <button type="submit" class="cmn-btn2 w-100"><?php echo e(__('Send a Massage')); ?></button>
                            </div>
                        </form>
                    </div>
                <?php elseif($listing->user_id === Auth::guard('web')->user()->id): ?>
                    <div class="btn-wrapper">
                        <form action="<?php echo e(route('member.message.send')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo e($listing->user_id); ?>">
                            <input type="hidden" name="from_user" id="from_user"  value="<?php echo e(Auth::guard('web')->user()->id); ?>">
                            <input type="hidden" name="listing_id" id="listing_id"  value="<?php echo e($listing->id); ?>">
                            <div class="send-massage">
                                <button type="submit" class="cmn-btn2 w-100"><?php echo e(__('Send a Massage')); ?></button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="send-massage">
                    <a href="javascript:void(0)" class="cmn-btn2 w-100" data-bs-toggle="modal" data-bs-target="#loginModal"><?php echo e(__('Sign in for Massage')); ?></a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if(empty($listing->admin_id)): ?>
    <div class="seller-details box-shadow1">
        <div class="seller-details-wraper">
            <?php if($listing->user_id === 0): ?>
                <div class="seller-img">
                    <?php echo userProfileImageView(optional($listing->user)->image); ?>

                </div>
            <?php else: ?>
                <a href="<?php echo e(route('about.user.profile', $listing?->user?->username)); ?>">
                    <div class="seller-img">
                        <?php echo userProfileImageView(optional($listing->user)->image); ?>

                    </div>
                </a>
            <?php endif; ?>
            <div class="seller-name">
                <div class="name">
                    <?php if($listing->user_id === 0): ?>
                        <span><?php echo e($listing->guestListing?->guestfullname); ?> </span>
                    <?php else: ?>
                        <a href="<?php echo e(route('about.user.profile', $listing?->user?->username)); ?>">
                            <span><?php echo e(optional($listing->user)->fullname); ?> </span>
                        </a>
                    <?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal954a6c78b23e6b6826bb45985771d12e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal954a6c78b23e6b6826bb45985771d12e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge.user-verified-badge','data' => ['listing' => $listing]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('badge.user-verified-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal954a6c78b23e6b6826bb45985771d12e)): ?>
<?php $attributes = $__attributesOriginal954a6c78b23e6b6826bb45985771d12e; ?>
<?php unset($__attributesOriginal954a6c78b23e6b6826bb45985771d12e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal954a6c78b23e6b6826bb45985771d12e)): ?>
<?php $component = $__componentOriginal954a6c78b23e6b6826bb45985771d12e; ?>
<?php unset($__componentOriginal954a6c78b23e6b6826bb45985771d12e); ?>
<?php endif; ?>
                </div>

                <?php if($listing->user_id != null && $listing->user_id != 0): ?>
                    <div class="member-listing">
                        <span class="listing">
                            <?php if($userTotalListings > 1): ?>
                                <?php echo e($userTotalListings); ?> <?php echo e(__('listings')); ?>

                            <?php else: ?>
                                <?php echo e($userTotalListings); ?> <?php echo e(__('listing')); ?>

                            <?php endif; ?>
                        </span>
                        <span class="dot"></span>
                        <?php echo e(__('Member since')); ?>

                        <?php echo e(\Carbon\Carbon::parse(optional($listing->user)->created_at)->format('Y')); ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/listings/listing-details-page-user-info.blade.php ENDPATH**/ ?>