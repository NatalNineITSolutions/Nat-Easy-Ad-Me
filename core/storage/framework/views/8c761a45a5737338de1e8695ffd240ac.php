<div class="seller-phone text-center">
    <p><?php echo e(__('Phone')); ?></p>
    <span type="text" id="default_phone_number_show_for_responsive" class="number"><?php echo e(__('+880 XXX XXX XX')); ?></span>
    <?php if($listing->phone_hidden === 0): ?>
        <div class="number" id="phoneNumberForResponsive"><?php echo e($listing->phone); ?></div>
        <a href="#" class="show-number callPhoneNumberBtn" id="userPhoneNumberBtnForResponsive"><?php echo e(__('Show Number')); ?></a>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/listings/user-listing-phone-for-responsive.blade.php ENDPATH**/ ?>