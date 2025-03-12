

<?php $__env->startSection('title', 'Matrimony Home'); ?>

<?php $__env->startSection('style'); ?>
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .content {
        text-align: center;
        padding: 20px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2>Welcome to the Matrimony Homepage</h2>
    <p>Find your perfect match!</p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.pushState(null, null, location.href);
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('matrimony.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/matrimony/index.blade.php ENDPATH**/ ?>