
<!DOCTYPE html>
<html lang="<?php echo e(get_user_lang()); ?>" dir="<?php echo e(get_user_lang_direction()); ?>">

<head>
    <?php echo renderHeadStartHooks(); ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo render_favicon_by_id(get_static_option('site_favicon')); ?>

    <?php echo $__env->make('frontend.layout.partials.custom-font', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/bootstrap.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/plugin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/main-style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/new-css-add.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/dynamic-style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/helpers.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/toastr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/all.min.css')); ?>">
    <?php if( get_user_lang_direction() === 'rtl'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/rtl.css')); ?>">
    <?php endif; ?>
    <link rel="canonical" href="<?php echo e(canonical_url()); ?>" />
    <?php echo $__env->make('frontend.layout.partials.root-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="new-style">
<?php if(!request()->is('admin/*')): ?>
    <?php echo $__env->make('frontend.layout.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
    <!--404 page-->
    <div class="page-wraper d-flex justify-content-center align-items-center section-padding2">
        <div class="content-404">
            <div class="image">
                <?php echo render_image_markup_by_attachment_id(get_static_option('error_image')); ?>

            </div>
            <div class="text text-center">
                <div class="main-title"><?php echo e(get_static_option('error_404_page_title')); ?></div>
                <span class="mt-3 mb-3"><?php echo e(get_static_option('error_404_page_subtitle')); ?></span>
                <p><?php echo e(get_static_option('error_404_page_paragraph')); ?></p>
                <a href="<?php echo e(route('homepage')); ?>" class="go-back red-btn"><?php echo e(get_static_option('error_404_page_button_text')); ?></a>
            </div>
        </div>
    </div>
<?php if(!request()->is('admin/*')): ?>
    <?php
        $footer_variant = !is_null(get_footer_style()) ? get_footer_style() : '02';
    ?>
    <?php echo $__env->make('frontend.layout.partials.footer-variant.footer-'.$footer_variant, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.layout.partials.js.basic-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
    <script src="<?php echo e(asset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/plugin.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/main.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/dynamic-script.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/common/js/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/select2.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/pages/404.blade.php ENDPATH**/ ?>