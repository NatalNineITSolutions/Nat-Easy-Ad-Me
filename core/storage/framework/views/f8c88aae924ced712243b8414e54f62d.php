<?php
    $notice = \App\Models\Backend\Notice::where('status', 1)->where('expire_date', '>', now())->latest()->where('notice_for', 2)->first();
 ?>
<?php if($notice): ?>
    <div class="notice_main_section d-flex m-0 justify-content-center text-center align-items-center">
        <div class="col-xxl-8 col-lg-12 col-md-12 col-sm-12">
            <div class="alert <?php if($notice->notice_type === 1): ?> alert-danger
                 <?php elseif($notice->notice_type === 2): ?> alert-warning
                 <?php elseif($notice->notice_type === 3): ?> alert-success
                 <?php elseif($notice->notice_type === 4): ?> alert-info
                 <?php endif; ?>">
                <p> <strong class="text-dark"><?php echo e($notice->title); ?></strong>
                    <strong><?php echo e($notice->description); ?> </strong>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/layout/partials/dashboard-notice.blade.php ENDPATH**/ ?>