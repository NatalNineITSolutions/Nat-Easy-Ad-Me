<?php if(auth()->guard('web')->user()): ?>
    <button class="seller-img p-0">
        <?php if(!empty(Auth::guard('web')->user()->image)): ?>
            <?php echo render_image_markup_by_attachment_id(Auth::guard('web')->user()->image); ?>

        <?php else: ?>
            <img src="<?php echo e(asset('assets/frontend/img/static/user-no-image.webp')); ?>" alt="No Image">
        <?php endif; ?>
  </button>
<?php else: ?>
    <div class="btn-wrapper">
        <a href="<?php echo e(route('user.login')); ?>"  class="cmn-btn sign-in">
            <?php echo e(__('Sign In')); ?>

        </a>
    </div>
<?php endif; ?>


<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/frontend/user/user-profile-image.blade.php ENDPATH**/ ?>