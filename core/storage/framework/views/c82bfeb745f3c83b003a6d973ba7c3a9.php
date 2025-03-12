<table class="dataTablesExample">
    <thead>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-bulk-delete')): ?>
        <th class="no-sort">
            <div class="mark-all-checkbox">
                <input type="checkbox" class="all-checkbox">
            </div>
        </th>
    <?php endif; ?>
    <th><?php echo e(__('ID')); ?></th>
    <th><?php echo e(__('Category')); ?></th>
    <th><?php echo e(__('Icon')); ?></th>
    <th><?php echo e(__('Image')); ?></th>
    <th><?php echo e(__('Status')); ?></th>
    <th><?php echo e(__('Create Date')); ?></th>
    <th><?php echo e(__('Action')); ?></th>
    </thead>
    <tbody>
    <?php if(!empty($categories) && $categories->count()): ?>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-bulk-delete')): ?>
                    <td>
                        <?php if (isset($component)) { $__componentOriginal2f3acf431e4ef3aaad9c59423cc34c19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f3acf431e4ef3aaad9c59423cc34c19 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.bulk-action.bulk-delete-checkbox','data' => ['id' => $data->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bulk-action.bulk-delete-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2f3acf431e4ef3aaad9c59423cc34c19)): ?>
<?php $attributes = $__attributesOriginal2f3acf431e4ef3aaad9c59423cc34c19; ?>
<?php unset($__attributesOriginal2f3acf431e4ef3aaad9c59423cc34c19); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2f3acf431e4ef3aaad9c59423cc34c19)): ?>
<?php $component = $__componentOriginal2f3acf431e4ef3aaad9c59423cc34c19; ?>
<?php unset($__componentOriginal2f3acf431e4ef3aaad9c59423cc34c19); ?>
<?php endif; ?>
                    </td>
                <?php endif; ?>
                <td><?php echo e($data->id); ?></td>
                <td><?php echo e($data->name); ?></td>
                <td><i class="<?php echo e($data->icon); ?> btn btn-primary"></i></td>
                <td>
                    <?php echo render_image_markup_by_attachment_id($data->image,' ','thumb'); ?>

                </td>
                <td>
                    <?php if($data->status==1): ?>
                        <span class="alert alert-success"><?php echo e(__('Active')); ?></span>
                    <?php else: ?>
                        <span class="alert alert-danger"><?php echo e(__('Inactive')); ?></span>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-status-change')): ?>
                            <span><?php if (isset($component)) { $__componentOriginal086f7010becd4d657cdb856682d3d79f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal086f7010becd4d657cdb856682d3d79f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status.status-change','data' => ['url' => route('admin.category.status',$data->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status.status-change'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.category.status',$data->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal086f7010becd4d657cdb856682d3d79f)): ?>
<?php $attributes = $__attributesOriginal086f7010becd4d657cdb856682d3d79f; ?>
<?php unset($__attributesOriginal086f7010becd4d657cdb856682d3d79f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal086f7010becd4d657cdb856682d3d79f)): ?>
<?php $component = $__componentOriginal086f7010becd4d657cdb856682d3d79f; ?>
<?php unset($__componentOriginal086f7010becd4d657cdb856682d3d79f); ?>
<?php endif; ?></span>
                    <?php endif; ?>
                </td>
                <td><?php echo e(date('d-m-Y', strtotime($data->created_at))); ?></td>
                <td>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-edit')): ?>
                        <?php if (isset($component)) { $__componentOriginal95a57cf8b726360d66c2d339617390c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal95a57cf8b726360d66c2d339617390c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon.edit-icon','data' => ['url' => route('admin.category.edit',$data->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon.edit-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.category.edit',$data->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal95a57cf8b726360d66c2d339617390c3)): ?>
<?php $attributes = $__attributesOriginal95a57cf8b726360d66c2d339617390c3; ?>
<?php unset($__attributesOriginal95a57cf8b726360d66c2d339617390c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal95a57cf8b726360d66c2d339617390c3)): ?>
<?php $component = $__componentOriginal95a57cf8b726360d66c2d339617390c3; ?>
<?php unset($__componentOriginal95a57cf8b726360d66c2d339617390c3); ?>
<?php endif; ?>
                   <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-delete')): ?>
                        <?php if (isset($component)) { $__componentOriginal7973b0ce98592c79f9209abd6e46a09b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7973b0ce98592c79f9209abd6e46a09b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.popup.delete-popup','data' => ['url' => route('admin.category.delete',$data->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('popup.delete-popup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.category.delete',$data->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7973b0ce98592c79f9209abd6e46a09b)): ?>
<?php $attributes = $__attributesOriginal7973b0ce98592c79f9209abd6e46a09b; ?>
<?php unset($__attributesOriginal7973b0ce98592c79f9209abd6e46a09b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7973b0ce98592c79f9209abd6e46a09b)): ?>
<?php $component = $__componentOriginal7973b0ce98592c79f9209abd6e46a09b; ?>
<?php unset($__componentOriginal7973b0ce98592c79f9209abd6e46a09b); ?>
<?php endif; ?>
                   <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <span><?php echo e(__('Category No Found')); ?></span>
    <?php endif; ?>
    </tbody>
</table>
<div class="custom_pagination mt-5 d-flex justify-content-end">
    <?php echo e($categories->links()); ?>

</div>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\resources\views/backend/pages/category/search-category.blade.php ENDPATH**/ ?>