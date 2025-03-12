<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__('Admin Login')); ?> - <?php echo e(get_static_option('site_title')); ?></title>
    <?php $site_favicon = get_attachment_image_by_id(get_static_option('site_favicon'),"full", false); ?>
    <?php if(!empty($site_favicon)): ?>
        <link rel=icon href="<?php echo e($site_favicon['img_url']); ?>" sizes="16x16" type="icon/png">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/icon.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/slick.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/sweetalert.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/flatpickr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/niceCountryInput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/jsuites.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/fancybox.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dashboard.css')); ?>">
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
    <script src="<?php echo e(asset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/common/js/jquery-migrate-3.4.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/common/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/slick.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/plugin.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/niceCountryInput.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/jsuites.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/fancybox.umd.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/map/raphael.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/map/jquery.mapael.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/map/world_countries.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/main.js')); ?>"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/layouts/login-screens.blade.php ENDPATH**/ ?>