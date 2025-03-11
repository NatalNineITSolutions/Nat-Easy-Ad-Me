<?php if(moduleExists('Membership')): ?>
    <?php if(membershipModuleExistsAndEnable('Membership')): ?>
        <?php
            $user = auth('web')->user();
        ?>
        <?php if(empty($user->membershipUser)): ?>
            <div class="col-lg-12 mt-1">
                <div class="alert alert-warning d-flex justify-content-between">
                    <strong style="font-size: 16px"><?php echo e(__('you must have to membership any of our package to start listing ads.')); ?></strong>
                    <a href="<?php echo e(getSlugFromReadingSetting('membership_plan_page') ? url('/'.getSlugFromReadingSetting('membership_plan_page')) : url('/membership')); ?>" target="_self" class="btn btn-secondary radius-5"><?php echo e(__('View Membership Packages')); ?></a>
                </div>
            </div>
        <?php else: ?>
            <?php if(!empty($user->membershipUser)): ?>
                <?php if(Carbon\Carbon::parse($user->membershipUser->expire_date) <= \Carbon\Carbon::today()): ?>
                    <div class="alert alert-warning d-flex justify-content-between">
                        <strong><?php echo e(__('Your package has been expired.')); ?></strong>
                        <a href="<?php echo e(getSlugFromReadingSetting('membership_plan_page') ? url('/'.getSlugFromReadingSetting('membership_plan_page')) : url('/membership')); ?>" target="_self" class="btn btn-secondary radius-5"><?php echo e(__('View Membership Packages')); ?></a>
                    </div>
                <?php else: ?>
                    <div class="col-lg-12 mt-1">
                        <div class="alert alert-info d-flex justify-content-between">
                            <p><?php echo e(__('Your Membership Package:')); ?>

                                <strong class="text-success"> <?php echo e($user->membershipUser->membership->title); ?></strong> <?php echo e(__('Expire Date:')); ?>

                                <strong class="text-danger">
                                    <?php echo e(optional(auth('web')->user()->membershipUser)->expire_date ? \Carbon\Carbon::parse(auth('web')->user()->membershipUser->expire_date)->format('d M Y') : ''); ?>

                                </strong>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\Modules/Membership\resources/views/frontend/user/membership/user-dashboard-membership-message.blade.php ENDPATH**/ ?>