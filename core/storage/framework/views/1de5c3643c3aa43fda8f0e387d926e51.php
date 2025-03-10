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
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/jquery.ihavecookies.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/all.min.css')); ?>">
    <?php if(get_user_lang_direction() == 'rtl'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/rtl.css')); ?>">
    <?php endif; ?>

    <link rel="canonical" href="<?php echo e(canonical_url()); ?>" />
    <?php echo $__env->make('frontend.layout.partials.root-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- page css -->
    <?php echo $__env->yieldContent('style'); ?>

    <?php if(request()->routeIs('homepage')): ?>
        <title><?php echo e(get_static_option('site_title')); ?> - <?php echo e(get_static_option('site_tag_line')); ?></title>
        <?php echo render_site_meta(); ?>

    <?php elseif( request()->routeIs('frontend.dynamic.page') && $page_type === 'page' ): ?>
        <?php echo render_site_title(optional($page_post)->title ); ?>

        <?php echo render_site_meta(); ?>

    <?php else: ?>
        <title><?php echo $__env->yieldContent('site_title'); ?></title>
    <?php endif; ?>
    <?php echo renderHeadEndHooks(); ?>

    <?php if(!empty(get_static_option('site_third_party_tracking_code'))): ?>
        <?php echo get_static_option('site_third_party_tracking_code'); ?>

    <?php endif; ?>
</head>
<body class="new-style">
<?php echo renderBodyStartHooks(); ?>

<?php echo $__env->make('frontend.layout.partials.notice', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/layout/partials/header.blade.php ENDPATH**/ ?>