

<div class="modal fade" id="current_membership_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo e(get_static_option('current_membership_modal_title') ?? __('Current Membership Info')); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <div class="singleMember">
                        <div class="memberDetails">
                            <?php if($user_membership): ?>
                                <div class="infoSingle">
                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                         <?php echo e(__('Title')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php echo e(optional($user_membership->membership)->title); ?>

                                        </div>
                                    </div>
                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                         <?php echo e(__('Plan')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php echo e($user_membership->membership?->membership_type?->type); ?>

                                        </div>
                                    </div>

                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                         <?php echo e(__('Price')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php echo e(float_amount_with_currency_symbol(optional($user_membership->membership)->price)); ?>

                                        </div>
                                    </div>

                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                         <?php echo e(__('Payment Gateway')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php echo e(ucfirst($user_membership->payment_gateway)); ?>

                                        </div>
                                    </div>

                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                         <?php echo e(__('Payment Status')); ?>

                                        </div>
                                        <div class="col_2">
                                            <span class="<?php if($user_membership->payment_status=='complete'): ?> activeStatus <?php else: ?> pendingStatus <?php endif; ?>">
                                            <?php echo e(ucfirst($user_membership->payment_status=='complete' ? 'complete' : 'pending')); ?>

                                            </span>
                                        </div>
                                    </div>

                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                         <?php echo e(__('Purchase Date')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php echo e(date('d-m-Y', strtotime($user_membership->created_at))); ?>

                                        </div>
                                    </div>

                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                         <?php echo e(__('Expiry Date')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php echo e(date('d-m-Y', strtotime($user_membership->expire_date))); ?>

                                        </div>
                                    </div>
                                </div>

                            <div class="divider"></div>

                            <!-- part two -->
                            <div class="infoSingleTwo d-flex gap-3 mt-4 justify-content-md-between">
                                <!--left part -->
                                <div class="left_part">
                                    <!--single items -->
                                    <div class="row_1 d-flex gap-1">
                                        <div class="col_1">
                                            <?php echo e(__('Listing Limit')); ?>

                                        </div>
                                        <div class="col_2">
                                          <small><?php echo e(__('Available')); ?></small> <?php echo e($user_membership->listing_limit); ?>

                                        </div>
                                    </div>
                                    <!--single items -->
                                    <div class="row_1 d-flex gap-1">
                                        <div class="col_1">
                                            <?php echo e(__('Gallery Images Per Listing')); ?>

                                        </div>
                                        <div class="col_2">
                                            <small><?php echo e(__('Available')); ?></small> <?php echo e($user_membership->gallery_images); ?>

                                        </div>
                                    </div>
                                    <!--single items -->
                                    <div class="row_1 d-flex gap-1">
                                        <div class="col_1">
                                            <?php echo e(__('Featured Listing Limit')); ?>

                                        </div>
                                        <div class="col_2">
                                            <small><?php echo e(__('Available')); ?></small> <?php echo e($user_membership->featured_listing); ?>

                                        </div>
                                    </div>
                                </div>

                                <!-- right part -->
                                <div class="right_part">
                                    <!-- Single Items -->
                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                            <?php echo e(__('Business Hour')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php if($user_membership->business_hour == 1): ?>
                                                <i class="las la-check-circle text-success fs-4 mx-2"></i>
                                            <?php else: ?>
                                                <i class="las la-times-circle text-danger fs-4 mx-2"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- Single Items -->
                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                            <?php echo e(__('Enquiry Form')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php if($user_membership->enquiry_form == 1): ?>
                                                <i class="las la-check-circle text-success fs-4 mx-2"></i>
                                            <?php else: ?>
                                                <i class="las la-times-circle text-danger fs-4 mx-2"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- Single Items -->
                                    <div class="row_1 d-flex gap-3">
                                        <div class="col_1">
                                            <?php echo e(__('Membership Badge')); ?>

                                        </div>
                                        <div class="col_2">
                                            <?php if($user_membership->membership_badge == 1): ?>
                                                <i class="las la-check-circle text-success fs-4 mx-2"></i>
                                            <?php else: ?>
                                                <i class="las la-times-circle text-danger fs-4 mx-2"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php else: ?>
                                <div class="chat_wrapper__details__inner__chat__contents">
                                    <h2 class="btn btn-info"> <?php echo e(__('No Membership Found')); ?></h2>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="red-global-close-btn mt-4" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/Membership\resources/views/frontend/user/membership/user-current-membership-modal.blade.php ENDPATH**/ ?>