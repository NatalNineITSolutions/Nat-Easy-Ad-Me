
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .order_id img{
            width: 50px !important;
        }
        .table_customer__thumb img {
            height: 60px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dashboard__body posPadding">
        <div class="dashboard__inner">
            <div class="dashboard__inner__item">
                <div class="dashboard__inner__item__flex">
                    <div class="dashboard__inner__item__left bodyItemPadding">
                        <div class="dashboard__inner__header">
                            <div class="dashboard__inner__header__flex">
                                <div class="dashboard__inner__header__left">
                                    <h4 class="dashboard__inner__header__title"> <strong id="greeting"></strong>, <?php echo e(Auth::guard('admin')->user()->name); ?> </h4>
                                    <p class="dashboard__inner__header__para"><?php echo e(__('Manage your dashboard here')); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard_promo">
                            <div class="row g-4 mt-2">
                                <?php $__currentLoopData = $dashboardData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xxl-2 col-xl-3 col-sm-6">
                                        <div class="dashboard_promo__single style_02 bg__white radius-10 padding-20">
                                            <span class="dashboard_promo__single__subtitle d-flex justify-content-between align-items-center">
                                                <span>
                                                <?php echo e($item['title'] ?? ''); ?>

                                                 </span>
                                                <?php if(isset($item['route'])): ?>
                                                    <a href="<?php echo e(route($item['route'])); ?>">
                                                        <i class="las la-arrow-right fs-3 font-weight-600"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </span>
                                            <h4 class="dashboard_promo__single__price mt-2"><?php echo e($item['value'] ?? 0); ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="row g-4 mt-1">
                            <div class="col-lg-6">
                                <div class="dashboard__card bg__white padding-20 radius-10">
                                    <h5 class="dashboard__card__header__title"><?php echo e(__('Recent Users')); ?></h5>
                                    <div class="dashboard__card__inner border_top_1">
                                        <div class="dashboard__inventory__table custom_table">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th><?php echo e(__('ID')); ?></th>
                                                    <th><?php echo e(__('User')); ?></th>
                                                    <th><?php echo e(__('Created On')); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $recent_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="table_row">
                                                        <td><span class="order_id"><?php echo e($user->id); ?></span></td>
                                                        <td>
                                                            <div class="table_customer">
                                                                <div class="table_customer__flex">
                                                                    <div class="table_customer__thumb">
                                                                        <?php if(!empty($user->image)): ?>
                                                                            <?php echo render_image_markup_by_attachment_id($user->image); ?>

                                                                        <?php else: ?>
                                                                            <img src="<?php echo e(asset('assets/frontend/img/static/user-no-image.webp')); ?>" alt="No Image">
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="table_customer__contents">
                                                                        <h6 class="table_customer__title"><?php echo e($user->fullname ?? ''); ?></h6>
                                                                        <p class="table_customer__para mt-1"><?php echo e($user->email ?? ''); ?></p>
                                                                        <p class="table_customer__para mt-1"><?php echo e($user->phone ?? ''); ?></p> ?? '
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><span class="table_date"><?php echo e($user->created_at->format('d M Y')); ?></span></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="dashboard__card bg__white padding-20 radius-10">
                                    <h5 class="dashboard__card__header__title"><?php echo e(__('Recent Listings')); ?></h5>
                                    <div class="dashboard__card__inner border_top_1">
                                        <div class="dashboard__inventory__table custom_table">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th><?php echo e(__('ID')); ?></th>
                                                    <th><?php echo e(__('User')); ?></th>
                                                    <th><?php echo e(__('Title')); ?></th>
                                                    <th><?php echo e(__('Image')); ?></th>
                                                    <th><?php echo e(__('Details')); ?></th>
                                                    <th><?php echo e(__('Created On')); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $recent_listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="table_row">
                                                        <td><span class="order_id"><?php echo e($listing->id); ?></span></td>
                                                        <td>
                                                            <div class="table_customer">
                                                                <div class="table_customer__flex">
                                                                    <div class="table_customer__thumb">
                                                                        <?php if(!empty(optional($listing->user)->image)): ?>
                                                                            <?php echo render_image_markup_by_attachment_id(optional($listing->user)->image); ?>

                                                                        <?php else: ?>
                                                                            <img src="<?php echo e(asset('assets/frontend/img/static/user-no-image.webp')); ?>" alt="No Image">
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="table_customer__contents">
                                                                        <h6 class="table_customer__title"><?php echo e($user->fullname ?? ''); ?></h6>
                                                                        <p class="table_customer__para mt-1"><?php echo e($user->email ?? ''); ?></p>
                                                                        <p class="table_customer__para mt-1"><?php echo e($user->phone ?? ''); ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(route('admin.listings.details', $listing->id)); ?>">
                                                            <span class="order_id"><?php echo e($listing->title); ?></span>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <span class="order_id">
                                                                <?php echo render_image_markup_by_attachment_id($listing->image); ?>

                                                            </span>
                                                            </td>
                                                        <td>
                                                            <a href="<?php echo e(route('admin.listings.details', $listing->id)); ?>" class="cmnBtn btn_5 btn_bg_info btnIcon radius-5">
                                                                <i class="las la-eye"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <span class="table_date"><?php echo e($listing->created_at->format('d M Y')); ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mt-0">
                            <div class="col-xl-6 col-lg-6">
                                <div class="dashboard__card bg__white padding-20 radius-10">
                                    <div class="dashboard__card__header">
                                        <div class="dashboard__card__header__flex">
                                            <div class="dashboard__card__header__left">
                                                <h5 class="dashboard__card__header__title"><?php echo e(__('Customers')); ?>

                                                    <p><?php echo e(__('Total Users:')); ?> <?php echo e($total_user); ?></p>
                                                </h5>
                                            </div>
                                            <div class="dashboard__card__header__right">
                                                <select id="timeIntervalSelect" class="select2_activation">
                                                    <?php $__currentLoopData = ['Weekly', 'Monthly', 'Yearly', 'Daily', 'Hourly']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>"><?php echo e($option); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart__item__inner mt-4">
                                        <canvas id="lineChartCustomer"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6">
                                <div class="dashboard__card bg__white padding-20 radius-10">
                                    <div class="dashboard__card__header">
                                        <div class="dashboard__card__header__flex">
                                            <div class="dashboard__card__header__left">
                                                <h5 class="dashboard__card__header__title"><?php echo e(__('Listings')); ?>

                                                    <p><?php echo e(__('Total Listings:')); ?> <?php echo e($total_listings); ?></p>
                                                </h5>
                                            </div>
                                            <div class="dashboard__card__header__right">
                                                <select id="listingTimeIntervalSelect" class="select2_activation">
                                                    <?php $__currentLoopData = ['Weekly', 'Monthly', 'Yearly', 'Daily', 'Hourly']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>"><?php echo e($option); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart__item__inner mt-4">
                                        <canvas id="lineChartListings"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if($visitors->count() > 0): ?>
                        <div class="row g-4 mt-1">
                            <div class="col-xxl-12 col-lg-12">
                                <div class="dashboard__card bg__white padding-20 radius-10">
                                    <div class="dashboard__card__header">
                                        <h4 class="dashboard__card__header__title"><?php echo e(__('Ads Visitors by Country')); ?></h4>
                                    </div>
                                    <div class="chart__item__inner mt-4">
                                        <div class="countryMap__wrapper">
                                            <div class="row gy-4 justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="countryMap__wrapper__map">
                                                        <div class="countryMap">
                                                            <div class="map"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="countryMap__wrapper__progress radius-10" style="max-height: 400px; overflow-y: auto;">
                                                        <?php $__currentLoopData = $visitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="progress__item">
                                                                <div class="progress__item__flex">
                                                                    <span class="progress__item__title"><?php echo e($visitor->country); ?> <b class="views"><?php echo e($visitor->total); ?></b></span>
                                                                    <span class="progress__item__bars__percent"><?php echo e(round(($visitor->total / $visitors->sum('total')) * 100)); ?>%</span>
                                                                </div>
                                                                <div class="progress__item__bars">
                                                                    <div class="progress__item__main" data-percent="<?php echo e(round(($visitor->total / $visitors->sum('total')) * 100)); ?>"></div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function () {
            let currentTime = new Date().getHours();
            let morningGreeting = "<?php echo e(__('Good Morning')); ?>";
            let afternoonGreeting = "<?php echo e(__('Good Afternoon')); ?>";
            let eveningGreeting = "<?php echo e(__('Good Evening')); ?>";
            if (currentTime >= 0 && currentTime < 12) {
                $('#greeting').text(morningGreeting);
            } else if (currentTime >= 12 && currentTime < 18) {
                $('#greeting').text(afternoonGreeting);
            } else {
                $('#greeting').text(eveningGreeting);
            }
        });
    </script>
    <?php echo $__env->make('backend.pages.dashboard.line-graph-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if($visitors->count() > 0): ?>
       <?php echo $__env->make('backend.pages.dashboard.visitors-by-country-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/pages/dashboard/dashboard.blade.php ENDPATH**/ ?>