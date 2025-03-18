
<?php $__env->startSection('site_title', __('User Login')); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<?php $__env->startSection('style'); ?>
    <style>
        .table {
            color: var(--heading-color)!important;
            border-color: #dee2e6;
        }
        tbody tr th {
            color: var(--heading-color)!important;
            font-weight: 500;
            border-color: #D0D5DD !important;
        }
        .user_login_demo_button{
            background: #0aa958!important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="loginArea section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 p-0 order-lg-1 order-1 loginLeft-img">
                    <div class="loginLeft-img">
                        <div class="login-cap">
                            <h3 class="tittle"><?php echo e(get_static_option('login_page_title') ?? __('Buy & sell anything')); ?></h3>
                            <p class="pera"><?php echo e(get_static_option('register_page_description') ?? __('Buy or Sell your any items.')); ?></p>
                        </div>
                        <div class="login-img">
                            <?php echo render_image_markup_by_attachment_id(get_static_option('register_page_image')); ?>

                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 order-lg-1 order-0 login-Wrapper">
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
                    <div class="error-message"></div>
                    <div class="row">
                        <form method="post" action="<?php echo e(route('user.login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-12">
                                <label class="infoTitle"><?php echo e(__('Email Or User Name')); ?></label>
                                <div class="input-form">
                                    <input type="text" name="username" id="username" placeholder="<?php echo e(__('Email Or User Name')); ?>">
                                    <div class="icon"><i class="las la-envelope icon"></i></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="infoTitle"> <?php echo e(__('Password')); ?> </label>
                                <div class="input-form">
                                    <input type="password" name="password" id="password" placeholder="<?php echo e(__('Type Password')); ?>">
                                    <div class="icon"><i class="las la-lock icon"></i></div>
                                    <div class="icon toggle-password">
                                         <i class="las la-eye-slash"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12">
                            <div class="passRemember mt-20">
                                <label class="checkWrap2"><?php echo e(__('Remember Me')); ?>

                                    <input class="effectBorder" name="remember"  type="checkbox" id="check15">
                                    <span class="checkmark"></span>
                                </label>
                                <!-- forgetPassword -->
                                <div class="forgetPassword mb-25">
                                    <a href="<?php echo e(route('user.forgot.password')); ?>" class="forgetPass"><?php echo e(__('Forgot Password?')); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="btn-wrapper text-center">
                                <button id="signin_form" class="cmn-btn4 w-100"><?php echo e(get_static_option('login_page_button_title') ?? __('Login')); ?></button>

                                <?php if(preg_match('/(bytesed)/',url('/'))): ?>
                                    <div class="adminlogin-info table-responsive margin-top-30">
                                        <table class="table">
                                            <th><?php echo e(__('Username')); ?></th>
                                            <th><?php echo e(__('Password')); ?></th>
                                            <th><?php echo e(__('Action')); ?></th>
                                            <tbody>
                                            <tr>
                                                <td id="user_username">test_user</td>
                                                <td id="user_password">12345678</td>
                                                <td>
                                                    <div class="btn-wrapper form-icon">
                                                         <button type="button" class="red-btn user_login_demo_button autoLogin" id="userLogin"><?php echo e(__('Login')); ?></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>

                                <?php if(moduleExists('SMSGateway') && get_static_option('otp_login_status') || !empty(get_static_option('register_page_social_login_show_hide')) && get_static_option('enable_google_login') || get_static_option('enable_facebook_login')): ?>
                                       <p class="font-weight-bold text-center mt-2 mb-2"><?php echo e(__('or')); ?></p>
                                <?php endif; ?>
                                <?php if(moduleExists('SMSGateway') && get_static_option('otp_login_status')): ?>
                                    <a href="<?php echo e(route('user.login.otp')); ?>" class="cmn-btn-outline4 w-100 mb-20"><?php echo e(__('Login In with OTP')); ?></a>
                                <?php endif; ?>
                                <!--social login -->
                                <?php if(!empty(get_static_option('register_page_social_login_show_hide'))): ?>
                                    <?php if(get_static_option('enable_google_login')): ?>
                                        <a href="<?php echo e(route('login.google.redirect')); ?>" class="cmn-btn-outline4  mb-20 w-100">
                                            <img src="<?php echo e(asset('assets/frontend/img/icon/googleIocn.svg')); ?>" alt="images" class="icon"> <?php echo e(__('Register With Google')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if(get_static_option('enable_facebook_login')): ?>
                                        <a href="<?php echo e(route('login.facebook.redirect')); ?>" class="cmn-btn-outline4 mb-20  w-100">
                                            <img src="<?php echo e(asset('assets/frontend/img/icon/fbIcon.svg')); ?>" alt="images" class="icon"><?php echo e(__('Register With Facebook')); ?>

                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <p class="sinUp"><span><?php echo e(__('Don’t have an account?')); ?></span><a href="<?php echo e(route('user.register')); ?>" class="singApp"><?php echo e(__('Sign Up')); ?></a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php $__env->startSection('scripts'); ?>

    <?php if(session('error')): ?>
    <script>
        toastr.error("<?php echo e(session('error')); ?>");
    </script>
    <?php endif; ?>

    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                $(document).on('click','#userLogin',function(){
                    let el = $(this);
                    let username = $('#user_username').text();
                    let passwrod = $('#user_password').text();
                    $('#username').val(username);
                    $('#password').val(passwrod);
                    $('#signin_form').trigger('click');
                });

                $(document).on('click','#signin_form',function (e){
                    e.preventDefault();
                    let el = $(this);
                    let erContainer = $(".error-message");
                    erContainer.html('');
                    el.text('<?php echo e(__('Please Wait..')); ?>');
                    $.ajax({
                        url: "<?php echo e(route('user.login')); ?>",
                        type: "POST",
                        data: {
                            username : $('#username').val(),
                            password : $('#password').val(),
                            remember : $('#remember').val(),
                        },
                        error:function(data){
                            var errors = data.responseJSON;
                            erContainer.html('<div class="alert alert-danger"></div>');
                            $.each(errors.errors, function(index,value){
                                erContainer.find('.alert.alert-danger').append('<p>'+value+'</p>');
                            });
                            el.text('<?php echo e(__('Login')); ?>');
                        },
                        success:function (data){
                            $('.alert.alert-danger').remove();
                            if (data.status == 'user-login'){
                                el.text('<?php echo e(__('Redirecting')); ?>..');
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                let redirectPath = "<?php echo e(route('user.dashboard')); ?>";
                                <?php if(!empty(request()->get('return'))): ?>
                                    redirectPath = "<?php echo e(url('/'.request()->get('return'))); ?>";
                                <?php endif; ?>
                                    window.location = redirectPath;
                            }else{
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                el.text('<?php echo e(__('Login')); ?>');
                            }
                        }
                    });
                });
            });
        }(jQuery));
    </script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/frontend/user/user-login.blade.php ENDPATH**/ ?>