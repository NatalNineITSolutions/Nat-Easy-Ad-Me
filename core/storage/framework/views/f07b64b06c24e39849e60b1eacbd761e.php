<?php
    try {
        $notice = \App\Models\Backend\Notice::where('status', 1)->where('expire_date', '>', now())->latest()->where('notice_for', 1)->first();
 }catch (\Exception $e){
        $notice = null;
 }
?>
<?php if($notice): ?>
    <div class="notice_main_section">
        <div class="col-12">
            <div class="alert
         <?php if($notice->notice_type === 1): ?> alert-danger
         <?php elseif($notice->notice_type === 2): ?> alert-warning
         <?php elseif($notice->notice_type === 3): ?> alert-success
         <?php elseif($notice->notice_type === 4): ?> alert-info
         <?php endif; ?> d-flex  notice_for_frontend m-0 justify-content-center">
                <p><strong class="text-dark"><?php echo e($notice->title); ?></strong>
                    <strong><?php echo e($notice->description); ?> </strong>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/layout/partials/notice.blade.php ENDPATH**/ ?>