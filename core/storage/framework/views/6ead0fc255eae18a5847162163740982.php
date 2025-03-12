<!DOCTYPE html>
<html class="no-js" lang="<?php echo e(get_default_language()); ?>" dir="<?php echo e(get_default_language_direction()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>
        <?php echo e(get_static_option('site_title')); ?>

        <?php if(request()->path() == 'admin'): ?>
            <?php echo e(get_static_option('site_tag_line')); ?>

        <?php else: ?>
            <?php echo $__env->yieldContent('site-title'); ?>
        <?php endif; ?>
    </title>
    <!-- favicon -->
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
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/fontawesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/fontawesome-iconpicker.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/icon.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/slick.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/sweetalert.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/flatpickr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/toastr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/telInput-plugin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/custom-style.css')); ?>">
    <?php echo $__env->yieldContent('style'); ?>
    <?php if(get_static_option('site_admin_dark_mode') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dashboard_dark.css')); ?>">
    <?php endif; ?>
    <?php if(get_user_lang_direction() == 'rtl'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/rtl.css')); ?>">
    <?php endif; ?>
</head>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/partials/header.blade.php ENDPATH**/ ?>