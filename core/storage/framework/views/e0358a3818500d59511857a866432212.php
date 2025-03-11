
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Account Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <?php if (isset($component)) { $__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.css','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.css'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa)): ?>
<?php $attributes = $__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa; ?>
<?php unset($__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa)): ?>
<?php $component = $__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa; ?>
<?php unset($__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa); ?>
<?php endif; ?>
    <style>
        .img-wrap {
            width: 111px;
        }

        .input-form {
            position: relative;
        }

        .id-upload-btn {
            cursor: pointer;
            border: 1px solid #ccc;
            padding: 8px 12px;
            display: inline-block;
        }

        .id-upload-btn i {
            margin-right: 5px;
        }

        .file-name {
            display: inline-block;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Style for hiding the file input */
        input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        label.d-block.file-name {
            max-width: fit-content !important;
        }

        .single-input {
            display: grid;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
        }

    /* check box css stat    */
        .checkbox-group {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        /* Style the label */
        .checkbox-group label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            cursor: pointer;
        }

        /* Style the custom checkbox */
        .checkbox-group input[type="checkbox"] {
            display: none;
        }

        .checkbox-group input[type="checkbox"] + span {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ccc;
            border-radius: 4px;
            margin-right: 8px;
            cursor: pointer;
            position: relative; /* Add relative positioning */
        }

        /* Style the custom checkbox when checked */
        .checkbox-group input[type="checkbox"]:checked + span {
            background-color: var(--color-6)!important;;
            border-color: var(--color-6)!important;;
        }

        /* Style the checkmark inside the custom checkbox */
        .checkbox-group input[type="checkbox"] + span::after {
            content: "\2713";
            font-size: 14px;
            color: #fff;
            display: none;
            position: absolute; /* Position the checkmark */
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Center the checkmark */
        }

        /* Show the checkmark inside the custom checkbox when checked */
        .checkbox-group input[type="checkbox"]:checked + span::after {
            display: inline-block;
        }
    /*    end */

        .select2-container {
            z-index: 9999999;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="profile-setting setting-page verify-identity section-padding2">
      <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        <?php echo $__env->make('frontend.user.layout.partials.user-profile-background-image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="down-body-wraper">
                            <?php echo $__env->make('frontend.user.layout.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="main-body">
                                <?php if (isset($component)) { $__componentOriginalc04996af13f0d779852114b39ea43e16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04996af13f0d779852114b39ea43e16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation.frontend-error','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('validation.frontend-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04996af13f0d779852114b39ea43e16)): ?>
<?php $attributes = $__attributesOriginalc04996af13f0d779852114b39ea43e16; ?>
<?php unset($__attributesOriginalc04996af13f0d779852114b39ea43e16); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04996af13f0d779852114b39ea43e16)): ?>
<?php $component = $__componentOriginalc04996af13f0d779852114b39ea43e16; ?>
<?php unset($__componentOriginalc04996af13f0d779852114b39ea43e16); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.user.responsive-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.user.responsive-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3)): ?>
<?php $attributes = $__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3; ?>
<?php unset($__attributesOriginal80b5715dad8fcb1da777d3c60bd1a9d3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3)): ?>
<?php $component = $__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3; ?>
<?php unset($__componentOriginal80b5715dad8fcb1da777d3c60bd1a9d3); ?>
<?php endif; ?>
                                <div class="setting-btn-part">
                                    <div class="setting-tab nav nav-tabs" id="setting-tabbuttons">
                                        <a href="javascript:void(0)" class="nav-link active" data-bs-toggle="tab" data-bs-target="#identity-verification"><?php echo e(__('Identity Verification')); ?></a>
                                        <a href="javascript:void(0)" class="nav-link" data-bs-toggle="tab" data-bs-target="#change-password"><?php echo e(__('Change Password')); ?></a>
                                        <?php if(moduleExists('Membership')): ?>
                                            <?php if(membershipModuleExistsAndEnable('Membership')): ?>
                                                <?php
                                                    $user_membership = \Modules\Membership\app\Models\UserMembership::where('user_id', \Illuminate\Support\Facades\Auth::guard('web')->user()->id)->first();
                                                ?>
                                                <?php if($user_membership->business_hour === 1): ?>
                                                      <a href="javascript:void(0)" class="nav-link" data-bs-toggle="tab" data-bs-target="#business-hours"><?php echo e(__('Business Hours')); ?></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <a href="javascript:void(0)" class="nav-link" data-bs-toggle="tab" data-bs-target="#deactivate-delete-account"><?php echo e(__('Deactivate/Delete Account')); ?></a>
                                    </div>
                                    <div class="setting-tab-content tab-content">
                                        <div class="tab-pane fade" id="change-password">
                                            <div class="tab-content-wraper box-shadow1 change-password-part">
                                                <h3 class="head4"><?php echo e(__('Change Password')); ?></h3>
                                                <p class="dashboard_accountSettings__para mb-24"><?php echo e(__('Last changed')); ?>

                                                    <?php if(Auth::guard('web')->user()->password_changed_at): ?>
                                                        <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Auth::guard('web')->user()->password_changed_at)->diffForHumans()); ?>

                                                    <?php endif; ?>
                                                </p>
                                                <form action="<?php echo e(route('user.account.settings')); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="input-wraper">
                                                        <label for="#current-password"><?php echo e(__('Current Password')); ?></label>
                                                        <input type="password" name="current_password" id="current_password" placeholder="<?php echo e(__('Current Password')); ?>">
                                                    </div>
                                                    <div class="input-wraper mt-3">
                                                        <label for="#new-password"><?php echo e(__('New Password')); ?></label>
                                                        <input type="password" name="new_password" id="new_password" placeholder="<?php echo e(__('New Password')); ?>">
                                                    </div>
                                                    <div class="input-wraper mt-3">
                                                        <label for="#re-new-password"><?php echo e(__('Re-Enter New Password')); ?></label>
                                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="<?php echo e(__('Re-Enter New Password')); ?>">
                                                    </div>
                                                    <div class="save-change-btn mt-3">
                                                        <button type="submit" class="red-btn"><?php echo e(__('Save Changes')); ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade show active" id="identity-verification">
                                            <!--verify step 01 -->
                                            <?php if(!is_null($user_verify_info) && $user_verify_info->status === 1): ?>
                                                <!--Verify your identity done -->
                                                <div class="tab-content-wraper identity-varified identity-verification mt-4 box-shadow1">
                                                    <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="28" cy="28" r="28" fill="#22C55E"/>
                                                        <path d="M24.5903 36.2106C24.1101 36.2106 23.6538 36.0185 23.3177 35.6823L16.5223 28.8869C15.8259 28.1906 15.8259 27.038 16.5223 26.3417C17.2186 25.6453 18.3712 25.6453 19.0675 26.3417L24.5903 31.8644L36.9325 19.5223C37.6288 18.8259 38.7814 18.8259 39.4777 19.5223C40.1741 20.2186 40.1741 21.3712 39.4777 22.0675L25.8629 35.6823C25.5268 36.0185 25.0705 36.2106 24.5903 36.2106Z" fill="white"/>
                                                    </svg>
                                                    <div class="text-part">
                                                        <h3 class="head4"><?php echo e(__('Your identity is verified')); ?></h3>
                                                        <p><?php echo e(__('Your identity has been verified by our team.')); ?></p>
                                                    </div>
                                                </div>
                                            <?php elseif(!is_null($user_verify_info) && $user_verify_info->status === 0): ?>
                                                <!-- Pending verification -->
                                                <div class="tab-content-wraper identity-verification mt-4 box-shadow1">
                                                    <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="28" cy="28" r="28" fill="#FFCC00"/>
                                                        <path d="M28 14V32" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                                        <path d="M28 40H28.01" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                                    </svg>
                                                    <div class="text-part">
                                                        <h3 class="head4"><?php echo e(__('Your identity verification is pending')); ?></h3>
                                                        <p><?php echo e(__('Your identity verification is under review. We will notify you once the review is complete.')); ?></p>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <!--Verify first step -->
                                                <?php if($user_verify_info && $user_verify_info->status === 2): ?>
                                                    <div class="tab-content-wraper box-shadow1 identity-verification mb-3">
                                                        <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="28" cy="28" r="28" fill="red"/>
                                                            <path d="M28 14V32" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                                            <path d="M28 40H28.01" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                                        </svg>
                                                            <span class="text-danger mt-2 mb-2"><?php echo e(__('Your account identity verification has been declined. Please resubmit your information.')); ?></span>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="tab-content-wraper box-shadow1 identity-verification">
                                                    <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 6.33335H17.8333M15.5 11H17.8333M6.16667 15.6667H17.8333M1.5 5.16669C1.5 4.23843 1.86875 3.34819 2.52513 2.69181C3.1815 2.03544 4.07174 1.66669 5 1.66669H19C19.9283 1.66669 20.8185 2.03544 21.4749 2.69181C22.1313 3.34819 22.5 4.23843 22.5 5.16669V16.8334C22.5 17.7616 22.1313 18.6519 21.4749 19.3082C20.8185 19.9646 19.9283 20.3334 19 20.3334H5C4.07174 20.3334 3.1815 19.9646 2.52513 19.3082C1.86875 18.6519 1.5 17.7616 1.5 16.8334V5.16669ZM6.16667 8.66669C6.16667 9.28553 6.4125 9.87902 6.85008 10.3166C7.28767 10.7542 7.88116 11 8.5 11C9.11884 11 9.71233 10.7542 10.1499 10.3166C10.5875 9.87902 10.8333 9.28553 10.8333 8.66669C10.8333 8.04785 10.5875 7.45436 10.1499 7.01677C9.71233 6.57919 9.11884 6.33335 8.5 6.33335C7.88116 6.33335 7.28767 6.57919 6.85008 7.01677C6.4125 7.45436 6.16667 8.04785 6.16667 8.66669Z" stroke="#F76631" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <div class="text-part">
                                                        <h3 class="head4"><?php echo e(__('Verify your identity')); ?></h3>
                                                        <p><?php echo e(__('We require you to verify your identity to keep the platform safe')); ?></p>
                                                        <a href="javascript:void(0)" class="red-btn"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#identifyVerifyModal"><?php echo e(__('Verify Identity')); ?>

                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!--business hours  -->
                                        <?php echo $__env->make('frontend.user.profile.business-hours', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        <div class="tab-pane fade" id="deactivate-delete-account">
                                            <div class="tab-content-wraper box-shadow1 business-hours">
                                                <div class="account-info">
                                                    <h4 class="title"> <?php echo e(__('Deactivate/Delete account')); ?> </h4>
                                                    <p class="text-danger mt-2">
                                                        <?php if(!empty($user_account_info)): ?>
                                                            <?php if($user_account_info->status === 0): ?>
                                                                <?php echo e(__('Currently your account is deactivated. You can activate from here.')); ?>

                                                            <?php elseif($user_account_info->status === 1): ?>
                                                                <?php echo e(__('Your account has been deleted')); ?>

                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php echo e(__('You can deactivate your account temporarily or Delete permanently')); ?>

                                                        <?php endif; ?>
                                                    </p>
                                                </div>

                                                <div class="d-flex gap-3">
                                                    <div class="save-change-btn mt-3">
                                                        <?php if(empty($user_account_info)): ?>
                                                            <a href="javascript:void(0)" class="red-btn"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#deactivateAccount"><?php echo e(__('Deactivate')); ?>

                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="save-change-btn mt-3">
                                                        <a href="javascript:void(0)" class="btn btn-danger"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#deleteAccount">
                                                            <?php echo e(__('Delete')); ?>

                                                        </a>
                                                    </div>

                                                    <div class="save-change-btn mt-3">
                                                        <?php if(!empty($user_account_info)): ?>
                                                            <?php if($user_account_info->status === 0): ?>
                                                                <a href="<?php echo e(route('user.account.deactive.cancel',$user_account_info->user_id)); ?>" class="success-btn">
                                                                    <?php echo e(__('Activate Your Account')); ?></a>
                                                            <?php elseif($user_account_info->status === 1): ?>
                                                                <a href="javascript:void(0)" class="danger-btn"><?php echo e(__('Already Delete Account')); ?></a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
      </div>
</div>

    <!-- Identity Verify Modal -->
    <div class="modal fade" id="identifyVerifyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Verify identity')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="custom-form">
                        <form action="<?php echo e(route('user.profile.verify')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-form">
                                        <label><?php echo e(__('Select Identification Type')); ?> <span class="text-danger">*</span></label>
                                        <div class="checkbox-group">
                                            <input type="hidden" name="identification_type" value="<?php echo e($user_verify_info?->identification_type); ?>">
                                            <label>
                                                <input type="checkbox" value="national">
                                                <span></span>
                                                <?php echo e(__('National ID')); ?>

                                            </label>
                                            <label>
                                                <input type="checkbox" value="passport">
                                                <span></span>
                                                <?php echo e(__('Passport')); ?>

                                            </label>
                                            <label>
                                                <input type="checkbox" value="driving">
                                                <span></span>
                                                <?php echo e(__('Driving License')); ?>

                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="single-flex-input">

                                        <div class="single-input">
                                            <label class="label-title"><?php echo e(__('Select Your Country')); ?>  <span class="text-danger">*</span></label>
                                            <select name="country_id" id="country_id" class="select2_activation">
                                                <option value=""><?php echo e(__('Select Country')); ?></option>
                                                <?php $__currentLoopData = $all_countries = \Modules\CountryManage\app\Models\Country::all_countries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($country->id); ?>" <?php if(!empty($user_verify_info) && $country->id == $user_verify_info->country_id): ?> selected <?php endif; ?>><?php echo e($country->country); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <span class="country_info"></span>
                                        </div>

                                        <div class="single-input">
                                            <label class="label-title"><?php echo e(__('Select Your State')); ?>  <span class="text-danger">*</span></label>
                                            <select name="state_id" id="state_id" class="select2_activation">
                                                <option value=""><?php echo e(__('Select State')); ?></option>
                                                <?php $__currentLoopData = $all_states = \Modules\CountryManage\app\Models\State::all_states(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($state->id); ?>" <?php if(!empty($user_verify_info) && $state->id == $user_verify_info->state_id): ?> selected <?php endif; ?>><?php echo e($state->state); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <span class="country_info"></span>
                                        </div>
                                        <div class="single-input">
                                            <label class="label-title"><?php echo e(__('Select Your City')); ?>  <span class="text-danger">*</span></label>
                                            <select name="city_id" id="city_id" class="select2_activation">
                                                <option value=""><?php echo e(__('Select City')); ?></option>
                                                <?php $__currentLoopData = $all_cities = \Modules\CountryManage\app\Models\City::all_cities(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($city->id); ?>" <?php if(!empty($user_verify_info) && $city->id == $user_verify_info->city_id): ?> selected <?php endif; ?>><?php echo e($city->city); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <span class="country_info"></span>
                                        </div>
                                    </div>
                               </div>
                                <div class="col-12 mt-3">
                                    <div class="input-form">
                                        <label class="d-block" for="national-id-number"><?php echo e(__('Zip Code')); ?> <span class="text-danger">*</span> </label>
                                        <input class="form-control w-100" type="number" name="zip_code" id="zip_code" value="<?php echo e($user_verify_info?->zip_code); ?>">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="input-form">
                                        <label class="d-block" for="address"><?php echo e(__('Address')); ?> <span class="text-danger">*</span> </label>
                                        <input class="form-control w-100" type="text" name="address" id="address" value="<?php echo e($user_verify_info?->address); ?>">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="input-form">
                                        <label class="d-block" for="identification_number"><?php echo e(__('National NID/Passport/Driving License Number')); ?> <span class="text-danger">*</span> </label>
                                        <input class="form-control w-100" type="number" name="identification_number" id="identification_number" value="<?php echo e($user_verify_info?->identification_number); ?>">
                                    </div>
                                </div>
                                <div class="col-6 mb-3 mt-3">
                                    <div class="input-form">
                                        <div class="id-front">
                                            <label class="d-block file-name" for="id-front"><?php echo e(__('Upload Front Part')); ?> <span class="text-danger">*</span> </label>
                                            <label for="id-front" class="id-upload-btn">
                                                <i class="las la-arrow-alt-circle-up fs-5"></i><?php echo e(__('Upload Front Part')); ?>

                                            </label>
                                            <input class="w-100" name="front_document" id="id-front" type="file" value="<?php echo e($user_verify_info->front_document ?? ''); ?>">
                                        </div>
                                        <div class="file-preview mt-2">
                                            <img id="front-preview" src="#" alt="Front Part Preview" style="display:none; max-width:100%; max-height:200px;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 mb-3 mt-3">
                                    <div class="input-form">
                                        <div class="id-back">
                                            <label class="d-block file-name" for="id-back"><?php echo e(__('Upload Back Part')); ?> <span class="text-danger">*</span> </label>
                                            <label for="id-back" class="id-upload-btn">
                                                <i class="las la-arrow-alt-circle-up fs-5"></i><?php echo e(__('Upload Back Part')); ?>

                                            </label>
                                            <input class="w-100 file-name" name="back_document" id="id-back" type="file" value="<?php echo e($user_verify_info->back_document ?? ''); ?>">
                                        </div>
                                        <div class="file-preview mt-2">
                                            <img id="back-preview" src="#" alt="Back Part Preview" style="display:none; max-width:100%; max-height:200px;" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal"><?php echo e(__('Submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <!-- Deactivate Account Modal -->
    <div class="modal fade" id="deactivateAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Deactivate Account')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="custom-form">
                        <form action="<?php echo e(route('user.account.deactive')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-form">
                                        <label for="CurrentPassword" class="label_title__postition"><?php echo e(__('Deactivation reason')); ?> <span class="text-danger">*</span> </label>
                                        <div class="input-form-select radius-10">
                                            <select class="select2_activation" name="reason" id="reason2">
                                                <option value="For Vacation"><?php echo e(__('For Vacation')); ?></option>
                                                <option value="Personal Reasons"><?php echo e(__('Personal Reasons')); ?></option>
                                                <option value="Others"><?php echo e(__('Others')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="input-form">
                                        <label for="newPassword" class="label_title__postition"><?php echo e(__('Describe')); ?> <span class="text-danger">*</span> </label>
                                        <textarea class="form-control radius-10"  name="description" id="description" cols="30" rows="4" placeholder="<?php echo e(__('e.g. explain why you are deactivating')); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal"><?php echo e(__('Deactivate Now')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Delete account')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="custom-form">
                        <form action="<?php echo e(route('user.account.delete')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="dashboard_accountDelete">
                                        <p class="dashboard_accountDelete__reason"><?php echo e(__('Account deletion is permanent')); ?></p>
                                        <p class="dashboard_accountDelete__reason"><?php echo e(__('We remove all your data')); ?></p>
                                        <p class="dashboard_accountDelete__reason"><?php echo e(__('You can’t log in to this account anymore')); ?></p>
                                        <p class="dashboard_accountDelete__reason"><?php echo e(__('Any services that are currently on progress will be suspended')); ?></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-form">
                                        <label for="CurrentPassword" class="label_title__postition"><?php echo e(__('Delete reason')); ?> <span class="text-danger">*</span> </label>
                                        <div class="input-form-select radius-10">
                                            <select class="select2_activation" name="reason" id="reason">
                                                <option value="For Vacation"><?php echo e(__('For Vacation')); ?></option>
                                                <option value="Personal Reasons"><?php echo e(__('Personal Reasons')); ?></option>
                                                <option value="Others"><?php echo e(__('Others')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-form">
                                        <label for="newPassword" class="label_title__postition"><?php echo e(__('Describe')); ?> <span class="text-danger">*</span> </label>
                                        <textarea class="form-control radius-10"  name="description" id="description" cols="30" rows="4"  placeholder="<?php echo e(__('e.g. explain why you are deactivating')); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal"><?php echo e(__('Delete Now')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php if (isset($component)) { $__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.markup','data' => ['type' => 'web']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.markup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('web')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75)): ?>
<?php $attributes = $__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75; ?>
<?php unset($__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75)): ?>
<?php $component = $__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75; ?>
<?php unset($__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('frontend.user.profile.account-settings-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php if (isset($component)) { $__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.js','data' => ['type' => 'web']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('web')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e)): ?>
<?php $attributes = $__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e; ?>
<?php unset($__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e)): ?>
<?php $component = $__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e; ?>
<?php unset($__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e); ?>
<?php endif; ?>
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){

                // Set default checkbox
                $('[value="<?php echo e($user_verify_info?->identification_type); ?>"]').prop('checked', true);
                $(document).on('change', '.checkbox-group input[type="checkbox"]', function () {
                    if ($('[value="national_id"]').is(':checked')) {
                        $('.checkbox-group input[type="checkbox"]').not('[value="national_id"]').prop('checked', false);
                    }
                    let checkedCheckboxes = $('.checkbox-group input[type="checkbox"]:checked');
                    if (checkedCheckboxes.length > 1) {
                        checkedCheckboxes.not(this).prop('checked', false);
                    }
                    $('input[name="identification_type"]').val('');
                    let value = $(this).val();
                    $('input[name="identification_type"]').val(value);
                });

                     <?php
                      $front_document  = $user_verify_info?->front_document;
                      $back_document =  $user_verify_info?->back_document;
                     ?>

              $(document).on('change', 'input[type="file"]', function () {
                    let fileName = $(this).val().split('\\').pop();
                    let input = this;
                    if (input.files && input.files[0]) {
                        let fileSize = input.files[0].size;
                        let maxSize = 10 * 1024 * 1024;
                        if (fileSize <= maxSize) {
                            let fileType = input.files[0].type;
                            if (fileType === 'application/pdf' || /^(image\/(jpg|jpeg|png|webp))$/.test(fileType)) {
                                $(input).siblings('.file-name').text(fileName);
                                if (/^image\/(jpg|jpeg|png|webp)$/.test(fileType)) {
                                    let reader = new FileReader();
                                    reader.onload = function(e) {
                                        // Update the preview for both front and back parts
                                        $(input).closest('.input-form').find('.file-preview img').attr('src', e.target.result).show();
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                } else if (fileType === 'application/pdf') {
                                    // Clear any existing image preview
                                    $(input).closest('.input-form').find('.file-preview img').attr('src', '').hide();
                                }
                            } else {
                                let error_message_for_file = '<?php echo e(__('Unsupported file type. Please select a PDF, JPG, PNG, JPEG, or WEBP file.')); ?>'
                                alert(error_message_for_file);
                                $(input).val('');
                                $(input).siblings('.file-name').text('');
                                // Clear the image preview
                                $(input).closest('.input-form').find('.file-preview img').attr('src', '').hide();
                            }
                        } else {
                            // File size exceeds the maximum limit
                            let error_message_for_file = '<?php echo e(__('File size exceeds the maximum limit of 10 MB.')); ?>'
                            alert(error_message_for_file);
                            $(input).val('');
                            $(input).siblings('.file-name').text('');
                            // Clear the image preview
                            $(input).closest('.input-form').find('.file-preview img').attr('src', '').hide();
                        }
                    }
                });


                // Check if old values exist and set them automatically
                <?php if(!empty($front_document)): ?>
                // Set the file name for the front document
                $('input[name="front_document"]').siblings('.file-name').text('<?php echo e(basename($front_document)); ?>');

                // Display the image preview for the front document
                let frontImageSrc = '<?php echo e(asset('assets/uploads/verification/' . $front_document)); ?>';
                $('input[name="front_document"]').closest('.input-form').find('.file-preview img').attr('src', frontImageSrc).show();
                <?php endif; ?>

                <?php if(!empty($back_document)): ?>
                // Set the file name for the back document
                $('input[name="back_document"]').siblings('.file-name').text('<?php echo e(basename($back_document)); ?>');

                // Display the image preview for the back document
                let backImageSrc = '<?php echo e(asset('assets/uploads/verification/' . $back_document)); ?>';
                $('input[name="back_document"]').closest('.input-form').find('.file-preview img').attr('src', backImageSrc).show();
                <?php endif; ?>

                // modal close
                $('.close').on('click', function (){
                    $('#media_upload_modal').modal('hide');
                });

                $('#reason').select2({
                    dropdownParent: $('#deleteAccount')
                });
                $('#reason2').select2({
                    dropdownParent: $('#deactivateAccount')
                });

                $('.hours_modal_hide').on('click', function (){
                    $('#customize-business-hour').modal('hide');
                });

            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/user/profile/account-settings.blade.php ENDPATH**/ ?>