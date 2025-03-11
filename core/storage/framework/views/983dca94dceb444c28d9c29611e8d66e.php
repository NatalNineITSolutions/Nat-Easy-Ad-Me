<?php echo $__env->make('frontend.layout.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.layout.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(!empty($page_post) && $page_post->breadcrumb_status == 'on'): ?>
    <div class="<?php if(Request::is('about') || Request::is('listings')): ?> container-1920 plr1 <?php else: ?> container-1440 <?php endif; ?>">
      <nav aria-label="breadcrumb" class="frontend-breadcrumb-wrap breadcrumb-nav-part">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Home')); ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?php echo e($page_post->title ?? ''); ?> <?php echo $__env->yieldContent('inner-title'); ?></a></li>
            </ol>
       </nav>
    </div>
<?php endif; ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('frontend.layout.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/layout/master.blade.php ENDPATH**/ ?>