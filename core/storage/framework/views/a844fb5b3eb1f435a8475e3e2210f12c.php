<div class="seller-phone text-center">
    <p><?php echo e(__('Phone')); ?></p>
    <span type="text" id="default_phone_number_show" class="number"><?php echo e(__('+880 XXX XXX XX')); ?></span>
    <?php if($listing->phone_hidden === 0): ?>
         <div class="number" id="phoneNumber"><?php echo e($listing->phone); ?></div>
        <a href="#" class="show-number" id="userPhoneNumberBtn"><?php echo e(get_static_option('listing_show_phone_number_title') ?? __('Show Number')); ?></a>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/listings/user-listing-phone.blade.php ENDPATH**/ ?>