<?php if(!empty($reviews)): ?>
    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            if($reviewtype == 'received'){
                  $reviewer_info = \App\Models\User::find($review->reviewer_id);
            }else{
                 $reviewer_info = \App\Models\User::find($review->user_id);
            }

            $isLastReview = $key === count($user->reviews) - 1;
        ?>
        <?php if($reviewer_info): ?>
            <div class="single-reviews">
                <div class="single-review-top d-flex justify-content-between align-items-end">
                    <div class="reviewer d-flex align-items-center">
                        <div class="seller-img">
                            <?php echo render_image_markup_by_attachment_id($reviewer_info->image, ''); ?>

                        </div>
                        <div class="name-rating">
                            <div class="rating">
                                <?php if($review->rating >= 1): ?>
                                    <b><?php echo ratting_star(round($review->rating, 1)); ?> </b>
                                <?php endif; ?>
                            </div>
                            <div class="name"><?php echo e($reviewer_info->fullname); ?></div>
                        </div>
                    </div>
                    <div class="date">
                        <?php if($review->created_at): ?>
                            <?php echo e(\Carbon\Carbon::parse($review->created_at)->format('d, M, Y')); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="review-text">
                    <?php echo e($review->message); ?>

                </div>
            </div>
            <?php if(!$isLastReview): ?>
                <div class="devider"></div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/components/user/user-reviews.blade.php ENDPATH**/ ?>