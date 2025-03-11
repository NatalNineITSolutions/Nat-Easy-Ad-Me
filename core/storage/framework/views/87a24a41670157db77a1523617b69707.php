
<?php $__env->startSection('site_title'); ?>
    <?php echo e(__('User Register')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .loginArea .login-Wrapper .input-form.input-form2 input {
            padding: 8px 0 6px 56px;
        }

        span#phone_availability {
            font-size: 13px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="loginArea section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 p-0  order-lg-1 order-1 loginLeft-img">
                    <div class="loginLeft-img">
                        <div class="login-cap">
                            <h3 class="tittle"><?php echo e(get_static_option('register_page_title') ?? __('Register')); ?></h3>
                            <p class="pera">
                                <?php echo e(get_static_option('register_page_description') ?? __('Buy or Sell any items.')); ?>

                            </p>
                        </div>
                        <div class="login-img">
                            <?php echo render_image_markup_by_attachment_id(get_static_option('register_page_image')); ?>

                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 order-lg-1 order-0 login-Wrapper">
                    <?php if(get_static_option('site_google_captcha_enable') == 'on'): ?>
                        <script src='https://www.google.com/recaptcha/api.js'></script>
                    <?php endif; ?>
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
                    <form action="<?php echo e(route('user.register')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('Partner Id')); ?></label>
                                <div class="input-group" style="height: 40px;">
                                    <input type="text" class="form-control ps-3 py-2" name="partner_id"
                                        value="<?php echo e(old('partner_id')); ?>" id="partner_id" placeholder="<?php echo e(__('Partner Id')); ?>"
                                        style="height: 40px; border-radius: 8px;">
                                    <button type="button" class="btn btn-primary" id="verify_partner_id"
                                        style="height: 40px; border-radius: 8px;">
                                        <?php echo e(__('Verify')); ?>

                                    </button>
                                </div>
                                <span id="partner_id_status" class="text-danger"></span>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('Partner Name')); ?></label>
                                <div class="input-form input-form2">
                                    <input type="text" class="ps-3 form-control" name="partner_name" id="partner_name"
                                        placeholder="<?php echo e(__('Partner Name')); ?>" readonly style="height: 40px;">
                                </div>
                            </div>
                            <p>Don't have a Partner Id?</p>
                            <div class="col-lg-12 col-md-12">
                                <label class="checkWrap2 terms-conditions mt-2"> <?php echo e(__('Click here to Register!')); ?>

                                    <input class="effectBorder check-input" type="checkbox" name="partner_data"
                                        id="partner_data" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('First Name')); ?></label>
                                <div class="input-form input-form2">
                                    <input type="text" class="ps-3" name="first_name" value="<?php echo e(old('first_name')); ?>"
                                        id="first_name" placeholder="<?php echo e(__('First Name')); ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('Last Name')); ?></label>
                                <div class="input-form input-form2">
                                    <input type="text" class="ps-3" name="last_name" value="<?php echo e(old('last_name')); ?>"
                                        id="last_name" placeholder="<?php echo e(__('Last Name')); ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('Username')); ?></label>
                                <div class="input-form input-form2">
                                    <input type="text" class="ps-3" name="username" value="<?php echo e(old('username')); ?>"
                                        id="username" placeholder="<?php echo e(__('Type Username')); ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('Email')); ?></label>
                                <div class="input-form input-form2">
                                    <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                                        placeholder="<?php echo e(__('Type Email')); ?>">
                                    <div class="icon">
                                        <i class="lar la-envelope icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('Phone Number')); ?></label>
                                <div class="input-form input-form2">
                                    <input type="hidden" id="country-code" name="country_code">
                                    <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" id="phone"
                                        placeholder="<?php echo e(__('Type Phone')); ?>">
                                    <span id="phone_availability"></span>

                                    <div class="d-none">
                                        <span id="error-msg" class="hide"></span>
                                        <p id="result" class="d-none"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle"><?php echo e(__('Password')); ?></label>
                                <div class="input-form">
                                    <input type="password" name="password" id="password"
                                        placeholder="<?php echo e(__('Type Password')); ?>">
                                    <div class="icon"> <i class="las la-lock icon"></i></div>
                                    <div class="icon toggle-password">
                                        <i class="las la-eye"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-3">
                                <label class="infoTitle"><?php echo e(__('Confirm Password')); ?></label>
                                <div class="input-form">
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        placeholder="<?php echo e(__('Confirm Password')); ?>">
                                    <div class="icon"> <i class="las la-lock icon"></i></div>
                                    <div class="icon toggle-password">
                                        <i class="las la-eye"></i>
                                    </div>
                                </div>
                            </div>

                            <span id="check_password_match" class="mb-2 mt-2"></span>

                            <!-- Terms and Conditions -->
                            <div class="col-lg-12 col-md-12">
                                <label class="checkWrap2 terms-conditions"> <?php echo e(__('I agree with the')); ?>

                                    <a href="<?php echo e(url('/' . get_static_option('select_terms_condition_page'))); ?>"
                                        target="_blank" class="text-primary"> <?php echo e(__('Terms and Conditions')); ?> </a>
                                    <input class="effectBorder check-input" type="checkbox" name="terms_conditions"
                                        id="terms_conditions" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <!-- <?php if(get_static_option('site_google_captcha_enable') == 'on'): ?>
                                                <div class="col-md-12 my-3">
                                                    <div class="g-recaptcha" data-sitekey="<?php echo e(get_static_option('recaptcha_2_site_key')); ?>">
                                                    </div>
                                                    <?php if($errors->has('g-recaptcha-response')): ?>
                                                        <span class="text-danger"><?php echo e($errors->first('g-recaptcha-response')); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?> -->

                            <div class="col-sm-12 mt-2">
                                <div class="btn-wrapper text-center">
                                    <button type="submit"
                                        class="cmn-btn4 w-100 user-register-form sign_up_now_button"><?php echo e(__('Register')); ?>

                                        <span id="user_register_load_spinner"></span>
                                    </button>
                                    <!--social login -->
                                    <?php if(!empty(get_static_option('register_page_social_login_show_hide'))): ?>
                                        <?php if(get_static_option('enable_google_login') || get_static_option('enable_facebook_login')): ?>
                                            <div class="bar-wrap">
                                                <span class="bar"></span>
                                                <p class="or"><?php echo e(__('or')); ?></p>
                                                <span class="bar"></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(get_static_option('enable_google_login')): ?>
                                            <a href="<?php echo e(route('login.google.redirect')); ?>" class="cmn-btn-outline4  mb-20 w-100">
                                                <img src="<?php echo e(asset('assets/frontend/img/icon/googleIocn.svg')); ?>" alt="images"
                                                    class="icon"> <?php echo e(__('Register With Google')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if(get_static_option('enable_facebook_login')): ?>
                                            <a href="<?php echo e(route('login.facebook.redirect')); ?>" class="cmn-btn-outline4 mb-20  w-100">
                                                <img src="<?php echo e(asset('assets/frontend/img/icon/fbIcon.svg')); ?>" alt="images"
                                                    class="icon"><?php echo e(__('Register With Facebook')); ?>

                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <p class="sinUp">
                                        <span><?php echo e(__('Already have an account?')); ?> </span>
                                        <a href="<?php echo e(route('user.login')); ?>" class="singApp"><?php echo e(__('Login')); ?></a>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of login Area -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php if (isset($component)) { $__componentOriginalf97309fc0a65c28d2860ea35fdbb7121 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf97309fc0a65c28d2860ea35fdbb7121 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.js.phone-number-check','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('frontend.js.phone-number-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf97309fc0a65c28d2860ea35fdbb7121)): ?>
<?php $attributes = $__attributesOriginalf97309fc0a65c28d2860ea35fdbb7121; ?>
<?php unset($__attributesOriginalf97309fc0a65c28d2860ea35fdbb7121); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf97309fc0a65c28d2860ea35fdbb7121)): ?>
<?php $component = $__componentOriginalf97309fc0a65c28d2860ea35fdbb7121; ?>
<?php unset($__componentOriginalf97309fc0a65c28d2860ea35fdbb7121); ?>
<?php endif; ?>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(document).on('keyup', '#username', function () {
                    let username = $(this).val();
                    let usernameRegex = /^[a-zA-Z0-9]+$/;
                    if (usernameRegex.test(username) && username != '') {
                        $.ajax({
                            url: "<?php echo e(route('user.name.availability')); ?>",
                            type: 'post',
                            data: {
                                username: username
                            },
                            success: function (res) {
                                if (res.status == 'available') {
                                    $("#user_name_availability").html(
                                        "<span style='color: green;'>" + res.msg +
                                        "</span>");
                                } else {
                                    $("#user_name_availability").html(
                                        "<span style='color: red;'>" + res.msg +
                                        "</span>");
                                }
                            }
                        });
                    } else {
                        $("#user_name_availability").html(
                            "<span style='color: red;'><?php echo e(__('Enter valid username')); ?></span>");
                    }
                });

                $(document).on('keyup', '#email', function () {
                    let email = $(this).val();
                    let emailRegex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                    if (emailRegex.test(email) && email != '') {
                        $.ajax({
                            url: "<?php echo e(route('user.email.availability')); ?>",
                            type: 'post',
                            data: {
                                email: email
                            },
                            success: function (res) {
                                if (res.status == 'available') {
                                    $("#email_availability").html(
                                        "<span style='color: green;'>" + res.msg +
                                        "</span>");
                                } else {
                                    $("#email_availability").html(
                                        "<span style='color: red;'>" + res.msg +
                                        "</span>");
                                }
                            }
                        });
                    } else {
                        $("#email_availability").html(
                            "<span style='color: red;'><?php echo e(__('Enter valid email')); ?></span>");
                    }
                });


                $(document).on('keyup', '#confirm_password', function () {
                    let password = $("#password").val();
                    let confirm_password = $("#confirm_password").val();
                    if (password.length >= 6 && confirm_password.length >= 6) {
                        if (password != confirm_password) {
                            $("#check_password_match").html("Password does not match !").css("color",
                                "red");
                        } else {
                            $("#check_password_match").html("Password match !").css("color", "green");
                        }
                    } else {
                        $("#check_password_match").html("")
                    }
                });

                $(document).on('keyup', '#password', function () {
                    let password = $("#password").val();
                    let confirm_password = $("#confirm_password").val();
                    if (password.length >= 6 && confirm_password.length >= 6) {
                        if (confirm_password != '') {
                            if (password != confirm_password) {
                                $("#check_password_match").html("Password does not match !").css("color", "red");
                            } else {
                                $("#check_password_match").html("Password match !").css("color", "green");
                            }
                        } else {
                            $("#check_password_match").html("")
                        }
                    }

                });

                // Partner Data
                $(document).ready(function () {
                    $("#partner_data").change(function () {
                        if ($(this).is(":checked")) {
                            $.ajax({
                                url: "<?php echo e(route('partner.data.availability')); ?>",
                                type: "GET",
                                success: function (response) {
                                    if (response.success) {
                                        $("#partner_id").val(response.partner_id);
                                        $("#partner_name").val(response.partner_name);
                                    }
                                },
                                error: function (xhr) {
                                    console.log("Error fetching partner details:", xhr);
                                }
                            });
                        } else {
                            $("#partner_id").val("");
                            $("#partner_name").val("");
                        }
                    });
                });

                // Partner Id
                $(document).ready(function () {
                    $('#verify_partner_id').on('click', function () {
                        var partnerId = $('#partner_id').val();

                        if (partnerId === '') {
                            $('#partner_id_status').text('Please enter a Partner ID');
                            return;
                        }

                        $('#partner_id_status').text('Verifying...');

                        $.ajax({
                            url: "<?php echo e(route('verify.partner.id')); ?>",
                            type: "POST",
                            data: {
                                partner_id: partnerId,
                                _token: "<?php echo e(csrf_token()); ?>"
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    $('#partner_name').val(response.partner_name);
                                    $('#partner_id_status').text('Partner ID verified ✅').css('color', 'green');
                                } else {
                                    $('#partner_name').val('');
                                    $('#partner_id_status').text(response.message).css('color', 'red');
                                }
                            },
                            error: function () {
                                $('#partner_id_status').text('Error verifying Partner ID').css('color', 'red');
                            }
                        });
                    });
                });

                //confirm signup
                $(document).on('click', '.sign_up_now_button', function () {

                    let first_name = $('#first_name').val();
                    let last_name = $('#last_name').val();
                    let username = $('#username').val();
                    let email = $('#email').val();
                    let phone = $('#phone').val();
                    let password = $('#password').val();
                    let confirm_password = $('#confirm_password').val();

                    let username_validation_text = $('#user_name_availability span').text();
                    let email_validation_text = $('#email_availability span').text();
                    let password_validation_text = $('#check_password_match').text();
                    let phone_validation_text = $('#phone_availability span').text();

                    if (first_name == '' || last_name == '' || username == '' || email == '' || phone == '' || password == '' || confirm_password == '') {
                        toastr_warning_js("<?php echo e(__('Please fill all fields')); ?>")
                        return false
                    } else if (username_validation_text == 'Sorry! Username name is not available' || username_validation_text == 'Enter valid username') {
                        toastr_warning_js("<?php echo e(__('Please enter a valid username')); ?>")
                        return false
                    } else if (email_validation_text == 'Sorry! Email has already taken' || email_validation_text == 'Enter valid email') {
                        toastr_warning_js("<?php echo e(__('Please enter a valid email')); ?>")
                        return false
                    } else if (phone_validation_text == 'Sorry! Phone Number has already taken' || phone_validation_text == 'Enter valid phone number') {
                        toastr_warning_js("<?php echo e(__('Please enter a valid phone number')); ?>")
                        return false
                    } else if (password.length < 6) {
                        toastr_warning_js("<?php echo e(__('Password must be 6 character at least')); ?>")
                        return false
                    } else if (confirm_password.length < 6) {
                        toastr_warning_js("<?php echo e(__('Password must be 6 character at least')); ?>")
                        return false
                    } else if (password_validation_text == 'Password does not match !') {
                        toastr_warning_js("<?php echo e(__('Password does not match')); ?>")
                        return false
                    }


                    // terms and condition check
                    if (!$('.terms-conditions .check-input').is(":checked")) {
                        toastr_warning_js("<?php echo e(__('Please agree with terms and conditions')); ?>")
                        return false;
                    }

                    $(this).attr("disabled", "disabled");
                    $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> <?php echo e(__("Registering")); ?>');
                    // Submit the form
                    $(this).closest('form').trigger('submit');

                });

            });
        }(jQuery));
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\easyadme\core\resources\views/frontend/user/user-register.blade.php ENDPATH**/ ?>