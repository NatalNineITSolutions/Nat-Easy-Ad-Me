<?php if(moduleExists('Membership')): ?>
    <?php if(membershipModuleExistsAndEnable('Membership')): ?>
        <?php if($user_membership->business_hour === 1): ?>
            <div class="tab-pane fade" id="business-hours">
                <div class="tab-content-wraper box-shadow1 business-hours">
                    <div class="hours-wraper">
                        <?php $__currentLoopData = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="days">
                                <div class="name">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 8.33333L7 7V3.66667M1 7C1 7.78793 1.15519 8.56815 1.45672 9.2961C1.75825 10.0241 2.20021 10.6855 2.75736 11.2426C3.31451 11.7998 3.97595 12.2417 4.7039 12.5433C5.43185 12.8448 6.21207 13 7 13C7.78793 13 8.56815 12.8448 9.2961 12.5433C10.0241 12.2417 10.6855 11.7998 11.2426 11.2426C11.7998 10.6855 12.2417 10.0241 12.5433 9.2961C12.8448 8.56815 13 7.78793 13 7C13 6.21207 12.8448 5.43185 12.5433 4.7039C12.2417 3.97595 11.7998 3.31451 11.2426 2.75736C10.6855 2.20021 10.0241 1.75825 9.2961 1.45672C8.56815 1.15519 7.78793 1 7 1C6.21207 1 5.43185 1.15519 4.7039 1.45672C3.97595 1.75825 3.31451 2.20021 2.75736 2.75736C2.20021 3.31451 1.75825 3.97595 1.45672 4.7039C1.15519 5.43185 1 6.21207 1 7Z" stroke="#1E293B" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> <?php echo e(__($day)); ?>

                                </div>
                                <div class="time">
                                    <?php if($business_hours_data && isset($business_hours_data['opening_times'][strtolower($day)]) && isset($business_hours_data['closing_times'][strtolower($day)])): ?>
                                        <?php echo e($business_hours_data['opening_times'][strtolower($day)]); ?> - <?php echo e($business_hours_data['closing_times'][strtolower($day)]); ?>

                                    <?php else: ?>
                                        <?php echo e(__('Closed')); ?>

                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="customize-btn mt-3">
                        <a href="javascript:void(0)" class="red-btn" data-bs-toggle="modal" data-bs-target="#customize-business-hour"><?php echo e(__('Customize')); ?></a>
                    </div>
                    <!--Business Hour Customize Modal-->
                    <div class="modal fade customize-business-hour" id="customize-business-hour">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-wraper">
                                    <h3 class="head4 mb-4"><?php echo e(__('Business Hours')); ?></h3>
                                    <form action="<?php echo e(route('user.business.hours.add')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php $__currentLoopData = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="dates d-flex justify-content-between align-items-center">
                                                <div class="left-part">
                                                    <input type="checkbox" name="days[]" value="<?php echo e($day); ?>" id="<?php echo e(strtolower($day)); ?>" <?php if($business_hours_data && in_array($day, $business_hours_data['days'])): ?> checked <?php endif; ?>>
                                                    <label for="<?php echo e(strtolower($day)); ?>"><?php echo e(__($day)); ?></label>
                                                </div>
                                                <div class="right-part">
                                                    <input type="text" name="opening_times[<?php echo e(strtolower($day)); ?>]" placeholder="<?php echo e(__('opening time')); ?>" value="<?php echo e($business_hours_data && isset($business_hours_data['opening_times'][strtolower($day)]) ? $business_hours_data['opening_times'][strtolower($day)] : ''); ?>">
                                                    -
                                                    <input type="text" name="closing_times[<?php echo e(strtolower($day)); ?>]" placeholder="<?php echo e(__('closing time')); ?>" value="<?php echo e($business_hours_data && isset($business_hours_data['closing_times'][strtolower($day)]) ? $business_hours_data['closing_times'][strtolower($day)] : ''); ?>">
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <div class="buttons">
                                            <button class="red-btn cancle-btn hours_modal_hide" type="button"><?php echo e(__('Cancel')); ?></button>
                                            <button class="red-btn" type="submit"><?php echo e(__('Save')); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/user/profile/business-hours.blade.php ENDPATH**/ ?>