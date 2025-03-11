<header class="header-style-01">
    <nav class="navbar navbar-area headerBg4 navbar-expand-lg plr">
        <div class="container-fluid container-1920 container-two nav-container">
            <div class="responsive-mobile-menu">
                <div class="logo-wrapper">
                    <a href="<?php echo e(route('homepage')); ?>" class="logo">
                        <?php echo render_image_markup_by_attachment_id(get_static_option('site_logo')); ?>

                    </a>
                </div>
                <?php echo $__env->make('frontend.layout.partials.navbar-variant.mobile-responsive-icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="NavWrapper">
                <!-- Main Menu -->
                <div class="collapse navbar-collapse" id="bizcoxx_main_menu">
                    <ul class="navbar-nav">
                        <?php echo render_frontend_menu($primary_menu); ?>

                    </ul>
                </div>
            </div>
            <!-- Menu Right -->
            <div class="nav-right-content">
              <?php echo $__env->make('frontend.layout.partials.navbar-variant.user-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </nav>
</header>

<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/layout/partials/navbar-variant/navbar-01.blade.php ENDPATH**/ ?>