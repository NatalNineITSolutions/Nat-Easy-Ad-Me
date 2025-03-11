<?php $__env->startSection('site_title',__('Live Chat')); ?>
<?php $__env->startSection('content'); ?>
    <!-- Messages Area s t a r t-->
    <div class="messagesArea section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="messagesWrapper">
                        <div class="row">
                            <?php if($member_chat_list->count() > 0): ?>
                                <!-- all member listing  area-->
                                <div class="col-xl-5 col-lg-6 col-md-12">
                                    <div class="userList">
                                        <!-- Single member list -->
                                        <?php $__currentLoopData = $member_chat_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member_chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if (isset($component)) { $__componentOriginalaad3709f8ce0353b438645eb66444d83 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaad3709f8ce0353b438645eb66444d83 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'chat::components.member.user-list','data' => ['memberChat' => $member_chat]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('chat::member.user-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['memberChat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($member_chat)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaad3709f8ce0353b438645eb66444d83)): ?>
<?php $attributes = $__attributesOriginalaad3709f8ce0353b438645eb66444d83; ?>
<?php unset($__attributesOriginalaad3709f8ce0353b438645eb66444d83); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaad3709f8ce0353b438645eb66444d83)): ?>
<?php $component = $__componentOriginalaad3709f8ce0353b438645eb66444d83; ?>
<?php unset($__componentOriginalaad3709f8ce0353b438645eb66444d83); ?>
<?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <!--all message listing area -->
                                <div class="col-xl-7 col-lg-6 col-md-12">
                                    <div class="messagesDetails">
                                        <!-- Header top for chat user info -->
                                        <div class="showProduct mb-5">
                                            <div class="chat-wrapper-details-header d-none flex-between" id="chat_header">
                                            </div>
                                        </div>
                                        <!-- End Header top for chat user info -->

                                        <!-- MessageBox -->
                                        <div class="messageBox">
                                            <!--main message area start -->
                                            <div class="messageShow">
                                                <!--new design -->
                                                <div class="chat-wrapper-details-inner user-chat-body" id="chat_body">
                                                </div>
                                            </div>
                                            <!-- messageSend input box-->
                                            <div class="messageSend d-none" id="member-message-footer">
                                                <!--message box -->
                                                <form action="#" method="get">
                                                    <textarea class="input  form-message" name="message" id="message" placeholder="<?php echo e(__('Write your message')); ?>"></textarea>
                                                </form>

                                                <!--Submit Button -->
                                                <div class="btn-wrapper form-icon">
                                                    <!--file section -->
                                                    <div class="imgSlector" id="uploadImage">
                                                        <input class="photo-uploaded-file inputTag" id="message-file" type="file">
                                                        <span class="show_uploaded_file"></span>
                                                        <label class="live_chat_attach_btn" for="message-file">
                                                            <i class="fa-solid fa-paperclip fs-5"></i> <span class="attach_files_title"><?php echo e(__("Attach Files")); ?></span>
                                                        </label>
                                                    </div>
                                                    <a href="javascript:void(0)" class="btn-rounded2" id="member-send-message-to-user"> <?php echo e(__('Send Message')); ?></a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-lg-12 mt-5 mb-5">
                                    <div class="chat-wrapper">
                                        <div class="chat-wrapper-flex">
                                            <div class="chat-sidebar d-lg-none">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="chat-wrapper-contact">
                                                <div class="chat-wrapper-contact-close">
                                                    <div class="close-chat d-lg-none"> <i class="fas fa-times"></i> </div>
                                                    <ul class="chat-wrapper-contact-list">
                                                        <h4 class="text-danger text-center mt-5"><?php echo e(__('No Contacts Yet.')); ?></h4>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="chat-wrapper-details"> </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                 </div>
             </div>
        </div>
    </div>
<!-- End-of Messages Area -->
<audio id="chat-alert-sound" style="display: none">
    <source src="<?php echo e(asset('assets/uploads/chat_image/sound/facebook_chat.mp3')); ?>" />
</audio>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/common/js/helpers.js')); ?>"></script>
    <script>
        let user_list = { <?php echo e($arr); ?> };
    </script>
    <?php if (isset($component)) { $__componentOriginalf1c79c8ea18e2860687f4d18fb9318ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf1c79c8ea18e2860687f4d18fb9318ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'chat::components.livechat-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('chat::livechat-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf1c79c8ea18e2860687f4d18fb9318ac)): ?>
<?php $attributes = $__attributesOriginalf1c79c8ea18e2860687f4d18fb9318ac; ?>
<?php unset($__attributesOriginalf1c79c8ea18e2860687f4d18fb9318ac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf1c79c8ea18e2860687f4d18fb9318ac)): ?>
<?php $component = $__componentOriginalf1c79c8ea18e2860687f4d18fb9318ac; ?>
<?php unset($__componentOriginalf1c79c8ea18e2860687f4d18fb9318ac); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal3ab03256b03f3857a630453d06ffb0fb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3ab03256b03f3857a630453d06ffb0fb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'chat::components.member.member-chat-js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('chat::member.member-chat-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3ab03256b03f3857a630453d06ffb0fb)): ?>
<?php $attributes = $__attributesOriginal3ab03256b03f3857a630453d06ffb0fb; ?>
<?php unset($__attributesOriginal3ab03256b03f3857a630453d06ffb0fb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3ab03256b03f3857a630453d06ffb0fb)): ?>
<?php $component = $__componentOriginal3ab03256b03f3857a630453d06ffb0fb; ?>
<?php unset($__componentOriginal3ab03256b03f3857a630453d06ffb0fb); ?>
<?php endif; ?>
    <script>
        $(document).on('click','.get_user_id',function(){
            $('#user_id').val($(this).data('user-id'));
        });
    </script>
    <script>
        <?php if(count($errors) > 0): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  toastr.warning("<?php echo e($error); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\easyadme\core\Modules/Chat\resources/views/member/index.blade.php ENDPATH**/ ?>