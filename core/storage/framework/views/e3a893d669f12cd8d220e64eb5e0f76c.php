<body>
<!-- preloader area start -->
<?php if(!empty(get_static_option('admin_loader_animation'))): ?>
    <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <div class="loader_bars">
                <span></span>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- preloader area end -->
<?php echo $__env->make('backend/partials/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('backend/partials/sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="dashboard__right">
    <?php echo $__env->make('backend/partials/top-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="dashboard__body posPadding">
        <div class="dashboard__inner">
            <div class="dashboard__inner__item">
                <div class="dashboard__inner__item__flex">
                    <div class="dashboard__inner__item__left bodyItemPadding">
                        <div class="body-overlay"></div>
                        <div class="dashboard__area">
                            <div class="container-fluid p-0">
                                <div class="dashboard__contents__wrapper">
                                     <?php echo $__env->yieldContent('content'); ?>
                                </div>
                            </div>



                            <footer style="margin-top: 70px">
                                <div class="dashboard__card bg__white padding-20 radius-10">
                                    <div class="footer-area footer-wrap">
                                        <?php echo render_footer_copyright_text(); ?>

                                        <p class="version">V-<?php echo e(get_static_option('site_script_version')); ?></p>
                                    </div>
                                </div>
                            </footer>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('backend/partials/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>

<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/admin-master.blade.php ENDPATH**/ ?>