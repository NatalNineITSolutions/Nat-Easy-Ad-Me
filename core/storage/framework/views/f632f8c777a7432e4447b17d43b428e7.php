
<!-- Admin Manage Role Module -->
<?php if(auth()->guard('admin')->user()->role == 1): ?>
<li  class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/manage*')): ?> active open show <?php endif; ?>">
    <a href="javascript:void(0)"> <i class="las la-user-cog"></i> <?php echo e(__('Admin Role Manage')); ?> </a>
    <ul class="submenu">
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/manage/create/new-admin')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.create')); ?>"> <?php echo e(__('Add New Admin')); ?> </a>
        </li>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/manage/all-admins')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.all')); ?>"> <?php echo e(__('All Admins')); ?> </a>
        </li>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/manage/permission/role/all')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.role.create')); ?>"> <?php echo e(__('All Roles')); ?> </a>
        </li>
    </ul>
</li>
<?php endif; ?>

<!-- Country Manage Module -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['country-list', 'country-csv-file-import', 'state-list', 'state-csv-file-import', 'city-list', 'city-csv-file-import'])): ?>
<li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/location/*')): ?> active open <?php endif; ?>">
    <a href="javascript:void(0)"><i class="las la-globe"></i>
        <span class="icon_title"><?php echo e(__('Country Manage')); ?></span>
    </a>
    <ul class="submenu" style="<?php if(request()->is('admin/location/*')): ?> display:block; <?php endif; ?>">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('country-list')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/location/country/all-country')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.country.all')); ?>"><?php echo e(__('All Countries')); ?></a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('country-csv-file-import')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/location/country/csv/import')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.country.import.csv.settings')); ?>"><?php echo e(__('Import Country')); ?></a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('state-list')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/location/state/all-state')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.state.all')); ?>"><?php echo e(__('All State')); ?></a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('state-csv-file-import')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/location/state/csv/import')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.state.import.csv.settings')); ?>"><?php echo e(__('Import States')); ?></a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city-list')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/location/city/all-city')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.city.all')); ?>"><?php echo e(__('All Cities')); ?></a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city-csv-file-import')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/location/city/csv/import')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.city.import.csv.settings')); ?>"><?php echo e(__('Import Cities')); ?></a>
        </li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>

<!-- Brand Module -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-list')): ?>
<li class="dashboard__bottom__list__item <?php if(request()->is('admin/brand/*')): ?> active <?php endif; ?>">
    <a href="<?php echo e(route('admin.brand.all')); ?>"><i class="las la-bars"></i>
        <span class="icon_title"><?php echo e(__('All Brands')); ?></span>
    </a>
</li>
<?php endif; ?>

<!-- Integration Module -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('integration-list')): ?>
<li class="dashboard__bottom__list__item <?php if(request()->is('admin/integrations-manage*')): ?> active <?php endif; ?>">
    <a href="<?php echo e(route('admin.integration')); ?>"><i class="las la-puzzle-piece"></i>
        <span class="icon_title"><?php echo e(__('Integration')); ?></span>
    </a>
</li>
<?php endif; ?>

<!-- Newsletter Module -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['newsletter-list'])): ?>
<li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/news-letter*')): ?> active open <?php endif; ?>">
    <a href="javascript:void(0)"><i class="las la-envelope-open"></i>
        <span class="icon_title"><?php echo e(__('Newsletter Manage')); ?></span>
    </a>
    <ul class="submenu" style="<?php if(request()->is('admin/news-letter*')): ?> display:block; <?php endif; ?>">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('newsletter-list')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/news-letter')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.newsletter.index')); ?>"><?php echo e(__('All Emails')); ?></a>
            </li>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('newsletter-list')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/news-letter/all')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.newsletter.mail')); ?>"><?php echo e(__('Email to All')); ?></a>
        </li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>

<!-- Blog Module -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['blog-list', 'blog-add', 'blog-settings'])): ?>
<li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/blog/*')): ?> active open <?php endif; ?>">
    <a href="javascript:void(0)"><i class="las la-rss"></i>
        <span class="icon_title"><?php echo e(__('Blog')); ?></span>
    </a>
    <ul class="submenu" style="<?php if(request()->is('admin/blog/*')): ?> display:block; <?php endif; ?>">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('blog-list')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/blog/all')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.all.blog')); ?>"><?php echo e(__('Blog Manage')); ?></a>
            </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('blog-add')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/blog/new')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.blog.new')); ?>"><?php echo e(__('Add New Blog')); ?></a>
            </li>
        <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('blog-settings')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/blog/blog-details-settings')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.blog.details.settings')); ?>"><?php echo e(__('Blog Details Settings')); ?></a>
            </li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>

<!-- Tags -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tag-list')): ?>
<li class="dashboard__bottom__list__item <?php if(request()->is('admin/tags')): ?> active <?php endif; ?>">
    <a href="<?php echo e(route('admin.blog.tags')); ?>"><i class="las la-tags"></i>
        <span class="icon_title"><?php echo e(__('Tags')); ?></span>
    </a>
</li>
<?php endif; ?>

<!-- Support Ticket Module -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['department-list', 'support-ticket-list'])): ?>
<li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/support-ticket/*')): ?> active open <?php endif; ?>">
    <a href="javascript:void(0)"><i class="las la-headset"></i>
        <span class="icon_title"><?php echo e(__('Support')); ?></span>
    </a>
    <ul class="submenu" style="<?php if(request()->is('admin/support-ticket/*')): ?> display:block; <?php endif; ?>">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department-list')): ?>
        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/support-ticket/department')): ?> selected <?php endif; ?>">
            <a href="<?php echo e(route('admin.department')); ?>"><?php echo e(__('Department')); ?></a>
        </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('support-ticket-list')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/support-ticket/tickets')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.ticket')); ?>"><?php echo e(__('Support Ticket')); ?></a>
            </li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>

<!-- Pages Module -->
<li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/plugin-manage/*')): ?> active open <?php endif; ?>">
    <a href="javascript:void(0)"><i class="las la-plug"></i>
        <span class="icon_title"><?php echo e(__('Plugins Manage')); ?></span>
    </a>
    <ul class="submenu" style="<?php if(request()->is('admin/plugin-manage/*')): ?> display:block; <?php endif; ?>">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('plugins-list')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/plugin-manage/all')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.plugin.manage.all')); ?>"><?php echo e(__('All Plugins')); ?></a>
            </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('plugins-add')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/plugin-manage/new')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.plugin.manage.new')); ?>"><?php echo e(__('Add New Plugin')); ?></a>
            </li>
        <?php endif; ?>
    </ul>
</li>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment-currency-settings')): ?>
<li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/payment-settings/*') || request()->is('admin/payment-gateway/currency-settings')): ?> active open <?php endif; ?>">
    <a href="javascript:void(0)"><i class="las la-money-check-alt"></i>
        <span class="icon_title"><?php echo e(__('Payment Gateway')); ?></span>
    </a>
    <ul class="submenu" style="<?php if(request()->is('admin/payment-settings/*') || request()->is('admin/payment-gateway/currency-settings')): ?> display:block; <?php endif; ?>">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment-currency-settings')): ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/payment-gateway/currency-settings')): ?> selected <?php endif; ?>">
                <a href="<?php echo e(route('admin.payment.gateway.currency.settings')); ?>"><?php echo e(__('Currency Settings')); ?></a>
            </li>
        <?php endif; ?>
        <?php
            $payment_gateways = \Modules\PaymentGateways\app\Models\PaymentGateway::pluck('name');
        ?>
        <?php $__currentLoopData = $payment_gateways ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="dashboard__bottom__list__item <?php if(request()->is("admin/payment-settings/payment/{$gateway}")): ?> selected <?php endif; ?>">
                <a class="text-capitalize" href="<?php echo e(route("admin.payment.settings.{$gateway}")); ?>"><?php echo e(__($gateway)); ?></a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</li>
<?php endif; ?>

<!-- Render all module route start -->
<?php
    $all_modules_route = (new \App\Helpers\ModuleMetaData())->getAllExternalMenu() ?? [];

?>
<?php $__currentLoopData = $all_modules_route; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $externalMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $flag = false;
        $activeRoutes = array_column((array) $externalMenu, 'route');
    ?>

    <?php $__currentLoopData = $externalMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $individual_menu_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $convert_to_array = (array) $individual_menu_item;
            $convert_to_array['label'] = __($convert_to_array['label']);
            if (array_key_exists('permissions', $convert_to_array) && !is_array($convert_to_array['permissions'])) {
                $convert_to_array['permissions'] = [$convert_to_array['permissions']];
            }
            $routeName = $convert_to_array['route'];
            $icon = array_key_exists('icon', $convert_to_array) ? $convert_to_array['icon'] : '';
        ?>
        <?php if(count($externalMenu) > 1): ?>
            <?php if($key === 0): ?>
                <li class="dashboard__bottom__list__item has-children <?php if(in_array(\Request::route()->getName(), $activeRoutes)): ?> active open <?php endif; ?>">
                    <?php endif; ?>

                    <?php if(empty($convert_to_array['parent']) && !$flag): ?>
                        <?php
                            $flag = true;
                        ?>
                        <a href="javascript:void(0)">
                            <i class="<?php echo e($icon); ?>"></i>
                            <span class="icon_title"><?php echo e($convert_to_array['label']); ?> <span class="badge bg-danger"><?php echo e(__('Plugin')); ?></span> </span>
                        </a>
                        <ul class="submenu" style=" <?php if(in_array(\Request::route()->getName(), $activeRoutes)): ?> display:block; <?php endif; ?>">
                            <?php endif; ?>
                            <?php if($key !== 0 && $flag): ?>
                                <li class="dashboard__bottom__list__item  <?php if(request()->routeIs($routeName) == $routeName): ?> selected <?php endif; ?>">
                                    <a href="<?php echo e(route($routeName)); ?>"><?php echo e($convert_to_array['label']); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if($key === count($externalMenu)-1): ?>
                        </ul>
                </li>
            <?php endif; ?>
        <?php else: ?>
            <li class="dashboard__bottom__list__item <?php if(request()->routeIs($routeName)): ?> active open <?php endif; ?>">
                <a href="<?php echo e(route($routeName)); ?>">  <i class="<?php echo e($icon); ?>"></i>  <?php echo e($convert_to_array['label']); ?> <span class="badge bg-danger"><?php echo e(__('Plugin')); ?></span> </a>
            </li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!-- Render all module route end -->
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/partials/module-list.blade.php ENDPATH**/ ?>