<div class="dashboard__left dashboard-left-content">
    <div class="dashboard__left__main">
        <div class="dashboard__left__close close-bars"><i class="fa-solid fa-times"></i></div>
        <div class="dashboard__top">
            <div class="dashboard__top__logo">
                <a href="<?php echo e(route('admin.dashboard')); ?>">
                <?php echo render_image_markup_by_attachment_id(get_static_option('site_logo')); ?>

                </a>
            </div>
        </div>

        <div class="dashboard__bottom mt-5">
            <div class="dashboard__bottom__search mb-3">
                <input class="form--control  w-100" type="text" placeholder="<?php echo e(__('Search here')); ?>" id="search_sidebarList">
            </div>
            <ul class="dashboard__bottom__list dashboard-list">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-dashboard')): ?>
                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/dashboard')): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="lab la-accessible-icon"></i>
                            <span class="icon_title"><?php echo e(__('Dashboard')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <!--Admin listing manage -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-listing-list', 'guest-listing-list', 'admin-listing-list', 'report-reason-list', 'listing-report-list'])): ?>
                    <li  class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/listings/*')): ?> active open show <?php endif; ?>">
                        <a href="javascript:void(0)"> <i class="las la-th-list"></i> <?php echo e(__('Listing Manage')); ?> </a>
                        <ul class="submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-listing-list')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/listings/user-all-listings')): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.user.all.listings')); ?>"> <?php echo e(__('All User Listings')); ?> </a>
                            </li>
                            <?php endif; ?>

                            <?php if(!empty(get_static_option('guest_listing_allowed_disallowed'))): ?>
                               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('guest-listing-list')): ?>
                                <li class="dashboard__bottom__list__item <?php if(request()->is('admin/listings/guest/all-listings')): ?> selected <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.guest.all.listings')); ?>"> <?php echo e(__('All Guest Listings')); ?> </a>
                                </li>
                               <?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-listing-list')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/listings/all') || request()->is('admin/listings/add') || request()->is('admin/listings/admin-edit-listing/*')): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.all.listings')); ?>"> <?php echo e(__('Admin All Listings')); ?> </a>
                            </li>
                           <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-reason-list')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/listings/report/reason/all')): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.report.reason.all')); ?>"> <?php echo e(__('Report Reason')); ?> </a>
                            </li>
                            <?php endif; ?>
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listing-report-list')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/listings/report/all')): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.listing.report.all')); ?>"> <?php echo e(__('Listing Reports')); ?> </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                
                

                
                <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/matrimony/*')): ?> active open show <?php endif; ?>">
                    <a href="javascript:void(0)"> <i class="las la-th-list"></i> <?php echo e(__('Matrimony Manage')); ?> </a>
                    <ul class="submenu">
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/matrimony/profile-listing')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.matrimony.profile.listing')); ?>"> <?php echo e(__('Matrimony Listing')); ?> </a>
                        </li>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/matrimony/profiles')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.matrimony.profiles')); ?>"> <?php echo e(__('Matrimony Profiles')); ?> </a>
                        </li>
                    </ul>
                </li>

                <!--Admin advertisement manage -->
                <?php if(get_static_option('google_adsense_status') == 'on'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['advertisement-list', 'advertisement-add'])): ?>
                        <li  class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/advertisement/*')): ?> active open show <?php endif; ?>">
                            <a href="javascript:void(0)"> <i class="las la-ad"></i> <?php echo e(__('Advertisements Manage')); ?> </a>
                            <ul class="submenu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement-list')): ?>
                                <li class="dashboard__bottom__list__item <?php if(request()->is('admin/advertisement/index')): ?> selected <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.advertisement')); ?>"> <?php echo e(__('All Advertisements')); ?> </a>
                                </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement-add')): ?>
                                <li class="dashboard__bottom__list__item <?php if(request()->is('admin/advertisement/new')): ?> selected <?php endif; ?>">
                                    <a href="<?php echo e(route('admin.advertisement.new')); ?>"> <?php echo e(__('Add New Advertisement')); ?> </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                     <?php endif; ?>
                <?php endif; ?>


               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-list', 'user-deactivated-list', 'user-verify-status', 'user-add'])): ?>
                <li  class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/user*')): ?> active open show <?php endif; ?>">
                    <a href="javascript:void(0)"> <i class="las la-user-circle"></i> <?php echo e(__('User Manage')); ?> </a>
                    <ul class="submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->routeIs(['admin.user.all'])): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.user.all')); ?>"> <?php echo e(__('All Users')); ?> </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-deactivated-list')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->routeIs(['admin.user.deactivated.all'])): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.user.deactivated.all')); ?>"> <?php echo e(__('Deactivated Users')); ?> </a>
                            </li>
                           <li class="dashboard__bottom__list__item <?php if(request()->routeIs(['admin.user.restore'])): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.user.restore')); ?>"> <?php echo e(__('Trash List')); ?> </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-verify-status')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->routeIs(['admin.user.verification.request'])): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.user.verification.request')); ?>">
                                    <?php echo e(__('Identity Verify Requests')); ?> </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-add')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->routeIs(['admin.user.add'])): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.user.add')); ?>">
                                <?php echo e(__('Add New User')); ?> </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
               <?php endif; ?>

               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['category-list', 'category-add'])): ?>
                <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/category/*')): ?> active open <?php endif; ?>">
                    <a href="javascript:void(0)"><i class="las la-th-list"></i>
                        <span class="icon_title"><?php echo e(__('Categories')); ?></span>
                    </a>
                    <ul class="submenu" style="<?php if(request()->is('admin/category/*')): ?> display:block; <?php endif; ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-list')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/category/index')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.category')); ?>"><?php echo e(__('All Category')); ?></a>
                        </li>
                        <?php endif; ?>
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-add')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/category/add-new-category')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.category.new')); ?>"><?php echo e(__('Add New Category')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
               <?php endif; ?>

              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['subcategory-list', 'subcategory-add'])): ?>
                <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/subcategory/*')): ?> active open <?php endif; ?>">
                    <a href="javascript:void(0)"><i class="las la-th-list"></i>
                        <span class="icon_title"><?php echo e(__('Subcategories')); ?></span>
                    </a>
                    <ul class="submenu" style="<?php if(request()->is('admin/subcategory/*')): ?> display:block; <?php endif; ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subcategory-list')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/subcategory/index')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.subcategory')); ?>"><?php echo e(__('All Subcategories')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subcategory-add')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/subcategory/add-new-subcategory')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.subcategory.new')); ?>"><?php echo e(__('Add New Subcategory')); ?></a>
                        </li>
                       <?php endif; ?>
                    </ul>
                  </li>
                <?php endif; ?>

                    <!-- Child Categories Manage -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['child-category-list', 'child-category-add'])): ?>
                        <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/child-category/*')): ?> active open <?php endif; ?>">
                            <a href="javascript:void(0)">
                                <i class="las la-th-list"></i>
                                <span class="icon_title"><?php echo e(__('Child Categories')); ?></span>
                            </a>
                            <ul class="submenu" style="<?php if(request()->is('admin/child-category/*')): ?> display:block; <?php endif; ?>">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('child-category-list')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/child-category/index')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.child.category')); ?>"><?php echo e(__('All Child Categories')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('child-category-add')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/child-category/add-new-child-category')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.child.category.new')); ?>"><?php echo e(__('Add New Child Category')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- Pages Manage -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['dynamic-page-list', 'dynamic-page-add'])): ?>
                        <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/dynamic-page*')): ?> active open <?php endif; ?>">
                            <a href="javascript:void(0)">
                                <i class="las la-paste"></i>
                                <span class="icon_title"><?php echo e(__('Pages')); ?></span>
                            </a>
                            <ul class="submenu" style="<?php if(request()->is('admin/dynamic-page/*')): ?> display:block; <?php endif; ?>">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dynamic-page-list')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/dynamic-page/all')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.page')); ?>"><?php echo e(__('All Pages')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dynamic-page-add')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/dynamic-page/new')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.page.new')); ?>"><?php echo e(__('Add New Page')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>


                    <?php echo $__env->make('backend.partials.module-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('notifications-list')): ?>
                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/notification/*')): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('admin.notification.all')); ?>"><i class="las la-bell"></i><?php echo e(__('All Notification')); ?></a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('notice-list')): ?>
                <li class="dashboard__bottom__list__item <?php if(request()->is('admin/notice/*')): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin.all.notice')); ?>"><i class="las la-bell"></i><?php echo e(__('Notice Settings')); ?></a>
                </li>
                <?php endif; ?>

              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('google-map-settings')): ?>
                <li class="dashboard__bottom__list__item <?php if(request()->is('admin/map-settings/*')): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin.map.settings.page')); ?>"><i class="las la-map"></i><?php echo e(__('Google Map Settings')); ?></a>
                </li>
               <?php endif; ?>

                    <!-- Appearance Settings -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any([
                        'navbar-global-variant', 'footer-global-variant', 'color-settings', 'typography-settings',
                        'typography-single-settings', 'font-add-settings', 'custom-font-delete', 'custom-font-status-change',
                        'widgets-list', 'widgets-add', 'widgets-delete', 'menu-list', 'menu-add', 'menu-edit', 'menu-delete',
                        'form-builder-list', 'form-builder-edit', 'form-builder-delete', 'form-builder-bulk.delete',
                        'media-upload', 'media-upload-delete', '404-page-settings', 'maintains-page-settings'
                    ])): ?>
                        <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/appearance-settings/*')): ?> active open <?php endif; ?>">
                            <a href="javascript:void(0)">
                                <i class="las la-cogs"></i>
                                <span class="icon_title"><?php echo e(__('Appearance Settings')); ?></span>
                            </a>
                            <ul class="submenu" style="<?php if(request()->is('admin/appearance-settings/*')): ?> display:block; <?php endif; ?>">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('form-builder-list')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/form/*')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.form')); ?>"> <?php echo e(__('Form Builder')); ?> </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('widgets-list')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/widgets')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.widgets')); ?>"><?php echo e(__('Widget Builder')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('menu-list')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/menu')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.menu')); ?>"><?php echo e(__('Menu Manage')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('navbar-global-variant')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/global-variant-navbar')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.general.global.variant.navbar')); ?>"><?php echo e(__('Navbar Global Variant')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('footer-global-variant')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/global-variant-footer')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.general.global.variant.footer')); ?>"><?php echo e(__('Footer Global Variant')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('color-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/color-settings')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.general.color.settings')); ?>"><?php echo e(__('Color Settings')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('typography-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/typography-settings')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.general.typography.settings')); ?>"><?php echo e(__('Typography Settings')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('media-upload')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/media-upload/page')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.upload.media.images.page')); ?>"><?php echo e(__('Media Images Manage')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('404-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/404-page-manage')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.404.page.settings')); ?>"><?php echo e(__('404 Page Manage')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('maintains-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/appearance-settings/maintains-page')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.maintains.page.settings')); ?>"><?php echo e(__('Maintain Page Manage')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any([
                            'login-register-page-settings', 'listing-create-page-settings', 'listing-details-page-settings',
                            'listing-guest-page-settings', 'user-public-profile-page-settings'
                        ])): ?>
                        <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/page-settings/*')): ?> active open <?php endif; ?>">
                            <a href="javascript:void(0)">
                                <i class="las la-envelope"></i>
                                <span class="icon_title"><?php echo e(__('Page Settings')); ?></span>
                            </a>
                            <ul class="submenu" style="<?php if(request()->is('admin/page-settings/*')): ?> display:block; <?php endif; ?>">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('login-register-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/page-settings/register-page')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.login.register.page.settings')); ?>"><?php echo e(__('Login & Register Page')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listing-create-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/page-settings/listing-create-page/settings')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.listing.create.settings')); ?>"><?php echo e(__('Listing Create Page Settings')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listing-details-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/page-settings/listing-details-page/settings')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.listing.details.settings')); ?>"><?php echo e(__('Listing Details Page Settings')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listing-guest-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/page-settings/guest-listing/settings')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.listing.guest.settings')); ?>"><?php echo e(__('Guest Listing Settings')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-public-profile-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/page-settings/user-public-profile/settings')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.user.public.profile.settings')); ?>"><?php echo e(__('User Public Profile Settings')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-public-profile-page-settings')): ?>
                                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/page-settings/admin-login-page/settings')): ?> selected <?php endif; ?>">
                                        <a href="<?php echo e(route('admin.login.page.settings')); ?>"><?php echo e(__('Admin Login Page Settings')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['smtp-settings'])): ?>
                    <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/email-settings/*')): ?> active open <?php endif; ?>">
                    <a href="javascript:void(0)"><i class="las la-envelope"></i>
                        <span class="icon_title"><?php echo e(__('Email Settings')); ?></span>
                    </a>
                        <ul class="submenu" style="<?php if(request()->is('admin/email-settings/*')): ?> display:block; <?php endif; ?>">
                            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/email-settings/smtp')): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.email.smtp.settings')); ?>"><?php echo e(__('SMTP Settings')); ?></a>
                            </li>
                            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/email-settings/all-email-templates')): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.email.template.all')); ?>"><?php echo e(__('All Email Templates')); ?></a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>

                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['reading-settings', 'site-identity-settings', 'basic-settings', 'seo-settings', 'scripts-settings', 'custom-css-settings',
                          'custom-js-settings', 'sitemap-settings', 'gdpr-settings', 'license-setting', 'software-update-setting', 'cache-settings', 'database-upgrade-setting'
                          ])): ?>
                <li class="dashboard__bottom__list__item has-children <?php if(request()->is('admin/general-settings/*')): ?> active open <?php endif; ?>">
                    <a href="javascript:void(0)"><i class="las la-cog"></i>
                        <span class="icon_title"><?php echo e(__('General Settings')); ?></span>
                    </a>
                    <ul class="submenu" style="<?php if(request()->is('admin/general-settings/*')): ?> display:block; <?php endif; ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reading-settings')): ?>
                            <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/reading')): ?> selected <?php endif; ?>">
                                <a href="<?php echo e(route('admin.general.reading')); ?>"><?php echo e(__('Reading')); ?></a>
                            </li>
                        <?php endif; ?>
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('site-identity-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/site-identity')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.site.identity')); ?>"><?php echo e(__('Site Identity')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('basic-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/basic-settings')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.basic.settings')); ?>"><?php echo e(__('Basic Settings')); ?></a>
                        </li>
                       <?php endif; ?>
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seo-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/seo-settings')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.seo.settings')); ?>"><?php echo e(__('SEO Settings')); ?></a>
                        </li>
                       <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('scripts-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/scripts')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.scripts.settings')); ?>"><?php echo e(__('Third Party Scripts')); ?></a>
                        </li>
                      <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('custom-css-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/custom-css')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.custom.css')); ?>"><?php echo e(__('Custom CSS')); ?></a>
                        </li>
                      <?php endif; ?>
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('custom-js-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/custom-js')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.custom.js')); ?>"><?php echo e(__('Custom JS')); ?></a>
                        </li>
                      <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sitemap-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/sitemap-settings')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.sitemap.settings')); ?>"><?php echo e(__('Sitemap Settings')); ?></a>
                        </li>
                      <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gdpr-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/gdpr-settings')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.gdpr.settings')); ?>"><?php echo e(__('Gdpr Settings')); ?></a>
                        </li>
                     <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('license-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/license-setting')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.license.settings')); ?>"><?php echo e(__('Licence Settings')); ?></a>
                        </li>
                       <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('software-update-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/software-update-setting')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.software.update.settings')); ?>"><?php echo e(__('Check Update')); ?></a>
                        </li>
                     <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cache-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/cache-settings')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.cache.settings')); ?>"><?php echo e(__('Cache Settings')); ?></a>
                        </li>
                     <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('database-upgrade-settings')): ?>
                        <li class="dashboard__bottom__list__item <?php if(request()->is('admin/general-settings/database-upgrade')): ?> selected <?php endif; ?>">
                            <a href="<?php echo e(route('admin.general.database.upgrade')); ?>"><?php echo e(__('Database Upgrade')); ?></a>
                        </li>
                     <?php endif; ?>
                    </ul>
                </li>
               <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('languages-list')): ?>
                    <li class="dashboard__bottom__list__item <?php if(request()->is('admin/languages/*') || request()->is('admin/languages')): ?> active <?php endif; ?>">
                        <a href="<?php echo e(route('admin.languages')); ?>"><i class="las la-language"></i> <span class="icon_title"><?php echo e(__('Languages')); ?></span></a>
                    </li>
                <?php endif; ?>

                <li class="dashboard__bottom__list__item">
                    <a href="<?php echo e(route('admin.logout')); ?>"> <i class="las la-sign-out-alt"></i> <span class="icon_title"><?php echo e(__('Log Out')); ?></span></a>
                </li>
            </ul>
        </div>
    </div>
</div>







<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/partials/sidebar.blade.php ENDPATH**/ ?>