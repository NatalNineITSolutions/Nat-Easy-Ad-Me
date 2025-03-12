<!-- State Edit Modal -->
<div class="modal fade" id="userIdentityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo e(__('Verify User Identity')); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body" id="user_identity_details">
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmnBtn btn_5 btn_bg_danger radius-5" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-verify-decline')): ?>
                    <button type="submit" class="cmnBtn btn_5 btn_bg_danger radius-5 user_identity_decline"><?php echo e(__('Decline Verify Identity')); ?></button>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-verify-status')): ?>
                    <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5 user_verify_status"><?php echo e(__('Update Verify Identity Status')); ?></button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/pages/user/users/identity-verify-details-modal.blade.php ENDPATH**/ ?>