<?php
    $custom_body_font_get = getCustomFont(1);
    $custom_heading_font_get = getCustomFont(2);
?>
<?php if(!empty($custom_body_font_get) || !empty($custom_heading_font_get)): ?>
    <style>
        /*heading font*/
        @font-face {
            font-family: <?php echo e(optional($custom_heading_font_get)->file); ?>;
            src: url('<?php echo e(optional($custom_heading_font_get)->path); ?>') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        /*body font*/
        @font-face {
            font-family: <?php echo e(optional($custom_body_font_get)->file); ?>;
            src: url('<?php echo e(optional($custom_body_font_get)->path); ?>') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --heading-font: '<?php echo e(optional($custom_heading_font_get)->file); ?>', sans-serif !important;
            --heading-font1: '<?php echo e(optional($custom_heading_font_get)->file); ?>', sans-serif !important;
            --body-font: '<?php echo e(optional($custom_body_font_get)->file); ?>', sans-serif !important;
            --body-font1: '<?php echo e(optional($custom_body_font_get)->file); ?>', sans-serif !important;
        }
        #all_search_result {
            position: absolute;
            top: 0;
            left: 0;
            background-color: white;
            padding: 10px;
            z-index: 9999;
        }
    </style>
<?php else: ?>
    <?php echo load_google_fonts(); ?>


    <style>
        /*heading font*/
        :root {
            --heading-font1: '<?php echo e(get_static_option('heading_font_family')); ?>', sans-serif !important;
            --heading-font: '<?php echo e(get_static_option('heading_font_family')); ?>', sans-serif !important;
            --body-font1: '<?php echo e(get_static_option('body_font_family')); ?>', sans-serif !important;
            --body-font: '<?php echo e(get_static_option('body_font_family')); ?>', sans-serif !important;
        }
    </style>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/layout/partials/custom-font.blade.php ENDPATH**/ ?>