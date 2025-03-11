<?php $__env->startSection('content'); ?>
    <section class="loginForm">
        <div class="loginForm__flex">
            <div class="loginForm__left">
                <div class="loginForm__left__inner desktop-center">
                    <div class="loginForm__right__logo">
                        <div class="loginForm__logo">
                            <a href="<?php echo e(route('homepage')); ?>" class="logo">
                                <?php echo render_image_markup_by_attachment_id(get_static_option('site_logo')); ?>

                            </a>
                        </div>
                    </div>
                    <div class="loginForm__header">
                        <h2 class="loginForm__header__title text-start"><?php echo e(get_static_option('admin_login_page_title') ?? __('Welcome Back')); ?></h2>
                        <p class="loginForm__header__para mt-3 text-start"><?php echo e(get_static_option('admin_login_page_subtitle') ?? __('Login with your data that you entered during registration.')); ?> </p>
                    </div>
                    <div class="error-message text-start mt-2">
                        <?php if (isset($component)) { $__componentOriginalc9692a4e4f266b622edf3104a05a2ca4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc9692a4e4f266b622edf3104a05a2ca4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.msg.response-message','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('msg.response-message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc9692a4e4f266b622edf3104a05a2ca4)): ?>
<?php $attributes = $__attributesOriginalc9692a4e4f266b622edf3104a05a2ca4; ?>
<?php unset($__attributesOriginalc9692a4e4f266b622edf3104a05a2ca4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc9692a4e4f266b622edf3104a05a2ca4)): ?>
<?php $component = $__componentOriginalc9692a4e4f266b622edf3104a05a2ca4; ?>
<?php unset($__componentOriginalc9692a4e4f266b622edf3104a05a2ca4); ?>
<?php endif; ?>
                    </div>
                    <div class="loginForm__wrapper mt-4">
                        <form action="<?php echo e(route('admin.login')); ?>" class="custom_form" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="single_input">
                                <label class="label_title"><?php echo e(__('Username or Email')); ?></label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="text" id="username" name="username" placeholder="<?php echo e(__('Username or Email')); ?>">
                                    <div class="icon"><span class="material-symbols-outlined"><?php echo e(__('person')); ?></span></div>
                                </div>
                            </div>

                            <div class="single_input">
                                <label class="label_title"><?php echo e(__('Password')); ?></label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="password" id="password" placeholder="<?php echo e(__('password')); ?>">
                                    <div class="icon"><span class="material-symbols-outlined"><?php echo e(__('lock')); ?></span></div>
                                </div>
                            </div>

                            <div class="loginForm__wrapper__remember single_input">
                                <div class="dashboard_checkBox">
                                    <input class="dashboard_checkBox__input" id="remember" type="checkbox">
                                    <label class="dashboard_checkBox__label" for="remember"><?php echo e(__('Remember Me')); ?></label>
                                </div>
                                <!-- forgetPassword -->
                                <div class="forgotPassword">
                                    <a href="<?php echo e(route('admin.forget.password')); ?>" class="forgotPass"><?php echo e(__('Forgot passwords?')); ?></a>
                                </div>
                            </div>
                            <div class="btn_wrapper single_input">
                                <button type="submit" id="form_submit" class="cmnBtn btn_5 btn_bg_blue radius-5 radius-5"><?php echo e(__('Login')); ?></button>
                            </div>
                              <?php if(preg_match('/(bytesed)/',url('/'))): ?>
                                <div class="adminlogin-info">
                                    <table class="table">
                                        <th><?php echo e(__('Username')); ?></th>
                                        <th><?php echo e(__('Password')); ?></th>
                                        <th><?php echo e(__('Action')); ?></th>
                                        <tbody>
                                        <tr class="border-0">
                                            <td class="border-0" id="td_username">super_admin</td>
                                            <td class="border-0" id="td_password">12345678</td>
                                            <td class="border-0">
                                                <button type="button" class="cmnBtn btn_5 btn_bg_success btnIcon radius-5 autoLogin" id="autoLogin"><?php echo e(__('Login')); ?></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                              <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="loginForm__right loginForm__bg" style="background-image: url('<?php echo e(get_image_url_id_wise(get_static_option('admin_login_page_background_image'))); ?>');"></div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        (function($){
           "use strict";
            $(document).ready(function ($){

                $(document).on('click','#autoLogin',function(){
                    let el = $(this);
                    let username = $('#td_username').text();
                    let passwrod = $('#td_password').text();
                    $('#username').val(username);
                    $('#password').val(passwrod);
                    $('#form_submit').trigger('click');
                });

                // admin login
                $(document).on('click','#form_submit',function (e){
                    e.preventDefault();
                    var el = $(this);
                    var erContainer = $(".error-message");
                    erContainer.html('');
                    el.text('<?php echo e(__('Please Wait..')); ?>');
                    $.ajax({
                        url: "<?php echo e(route('admin.login')); ?>",
                        type: "post",
                        data: {
                            _token : "<?php echo e(csrf_token()); ?>",
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
                            if (data.status == 'ok'){
                                el.text('<?php echo e(__('Redirecting')); ?>..');
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                location.reload();
                            }else{
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                el.text('<?php echo e(__('Login')); ?>');
                            }
                        }
                    });
                });

           });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.login-screens', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\easyadme\core\resources\views/auth/admin/login.blade.php ENDPATH**/ ?>