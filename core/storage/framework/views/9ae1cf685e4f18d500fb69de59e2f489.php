<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo e(__('Add New Ticket')); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('user.ticket')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-3">
                    <?php if (isset($component)) { $__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.text','data' => ['title' => __('Title'),'type' => __('text'),'name' => 'title','id' => 'title','placeholder' => __('Enter ticket title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Title')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('text')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('title'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('title'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Enter ticket title'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2)): ?>
<?php $attributes = $__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2; ?>
<?php unset($__attributesOriginal2497cd08ed4b80389f11a0f1101e9ba2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2)): ?>
<?php $component = $__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2; ?>
<?php unset($__componentOriginal2497cd08ed4b80389f11a0f1101e9ba2); ?>
<?php endif; ?>
                    <div class="single-input mb-3">
                        <label for="priority" class="label-title"><?php echo e(__('Department')); ?></label>
                        <select name="department" id="department" class="form-control select2_activation">
                            <option value="" disabled><?php echo e(__('Select Department')); ?></option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="single-input mb-3">
                        <label for="priority" class="label-title"><?php echo e(__('Priority')); ?></label>
                        <select name="priority" id="priority" class="form-control select2_activation">
                            <option value="" disabled><?php echo e(__('Select Priority')); ?></option>
                            <option value="urgent"><?php echo e(__('Urgent')); ?></option>
                            <option value="high"><?php echo e(__('High')); ?></option>
                            <option value="medium"><?php echo e(__('Medium')); ?></option>
                            <option value="low"><?php echo e(__('Low')); ?></option>
                        </select>
                    </div>
                    <?php if (isset($component)) { $__componentOriginalc90a87905706cb9b5d0ad735e5b8e7c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc90a87905706cb9b5d0ad735e5b8e7c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.summernote','data' => ['title' => __('Description'),'name' => 'description','id' => 'description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form.summernote'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Description')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('description'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('description')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc90a87905706cb9b5d0ad735e5b8e7c5)): ?>
<?php $attributes = $__attributesOriginalc90a87905706cb9b5d0ad735e5b8e7c5; ?>
<?php unset($__attributesOriginalc90a87905706cb9b5d0ad735e5b8e7c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc90a87905706cb9b5d0ad735e5b8e7c5)): ?>
<?php $component = $__componentOriginalc90a87905706cb9b5d0ad735e5b8e7c5; ?>
<?php unset($__componentOriginalc90a87905706cb9b5d0ad735e5b8e7c5); ?>
<?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="red-global-close-btn mt-4" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <?php if (isset($component)) { $__componentOriginal632b1038db5541c1a915a7b91a4b9d06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal632b1038db5541c1a915a7b91a4b9d06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn.submit-btn','data' => ['title' => __('Create Ticket'),'class' => 'red-global-btn mt-4 pr-4 pl-4 add_ticket']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('btn.submit-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Create Ticket')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('red-global-btn mt-4 pr-4 pl-4 add_ticket')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal632b1038db5541c1a915a7b91a4b9d06)): ?>
<?php $attributes = $__attributesOriginal632b1038db5541c1a915a7b91a4b9d06; ?>
<?php unset($__attributesOriginal632b1038db5541c1a915a7b91a4b9d06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal632b1038db5541c1a915a7b91a4b9d06)): ?>
<?php $component = $__componentOriginal632b1038db5541c1a915a7b91a4b9d06; ?>
<?php unset($__componentOriginal632b1038db5541c1a915a7b91a4b9d06); ?>
<?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/SupportTicket\resources/views/user/add-modal.blade.php ENDPATH**/ ?>