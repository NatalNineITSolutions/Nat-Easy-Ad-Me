<!--Google Adds-->
<?php if(get_static_option('google_adsense_status') == 'on'): ?>
<div class="google-adds" data-padding-top="<?php echo e($padding_top); ?>" data-padding-bottom="<?php echo e($padding_bottom); ?>">
    <div class="text-<?php echo e($custom_container); ?> single-banner-ads ads-banner-box" id="home_advertisement_store">
        <input type="hidden" id="add_id" value="<?php echo e($add_id); ?>">
        <?php echo $add_markup; ?>

    </div>
</div>
<?php endif; ?>
<!--Google Adds-->
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\app\Providers/../../plugins/PageBuilder/views/advertise/advertise-one.blade.php ENDPATH**/ ?>