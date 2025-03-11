
<div class="row mb-24">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb" class="frontend-breadcrumb-wrap">
            <h4 class="breadcrumb-contents-title"> <?php echo e($title); ?> </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('homepage')); ?>"><?php echo e(__('Home')); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo e($routeName); ?>"><?php echo e($innerTitle); ?> </a></li>
                <?php if(isset($subInnerTitle) && $subInnerTitle): ?>
                  <li class="breadcrumb-item"><a href="<?php echo e($subRouteName); ?>"><?php echo e($subInnerTitle ?? ''); ?> </a></li>
                <?php endif; ?>
                <?php if(isset($chidInnerTitle) && !empty($chidInnerTitle)): ?>
                  <li class="breadcrumb-item"><a href="#"><?php echo e($chidInnerTitle ?? ''); ?> </a></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>
<?php /**PATH C:\laragon\www\easyadme\core\resources\views/components/breadcrumb/user-profile-breadcrumb.blade.php ENDPATH**/ ?>