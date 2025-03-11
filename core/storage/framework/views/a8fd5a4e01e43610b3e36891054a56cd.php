<?php if($user_enquiry_form === true): ?>
    <div class="business-hour enquiry-hour box-shadow1 mt-4">
        <h3 class="head5 enquiry-head d-flex"><?php echo e(__('Enquiry Form')); ?> </h3>
        <div class="enquiry-wraper">
            <div class="enquiry_form_submit">
                <form action="<?php echo e(route('visitor.enquiry.form.submit')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="listing_id" id="listing_id" value="<?php echo e($listing->id); ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo e($listing->user_id); ?>">

                    <div class="input-wraper mt-3">
                        <label for="name"><?php echo e(__('Name')); ?></label>
                        <input class="form-control"  type="text" name="name" id="name" placeholder="<?php echo e(__('Name')); ?>">
                    </div>
                    <div class="input-wraper mt-3">
                        <label for="email"><?php echo e(__('Email')); ?></label>
                        <input  class="form-control" type="email" name="email" id="email" placeholder="<?php echo e(__('Email')); ?>">
                    </div>
                    <div class="input-wraper mt-3">
                        <label for="Phone"><?php echo e(__('Phone')); ?></label>
                        <input  class="form-control" type="number" name="phone" id="phone" placeholder="<?php echo e(__('Phone')); ?>">
                    </div>
                    <div class="input-wraper mt-3">
                        <label for="#message"><?php echo e(__('Message')); ?></label>
                        <textarea  class="form-control" type="text" name="message" id="message" placeholder="<?php echo e(__('Message')); ?>"></textarea>
                    </div>
                    <div class="save-change-btn mt-3 text-start btn-sm">
                        <button type="submit" class="red-btn"><?php echo e(__('Submit Enquiry')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/pages/listings/frontend-enquiry-form.blade.php ENDPATH**/ ?>