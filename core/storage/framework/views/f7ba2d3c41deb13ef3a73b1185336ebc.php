<?php if($tickets->count() > 0): ?>
    <div class="custom_table">
        <table class="table mt-3">
            <thead class="table-light">
            <tr>
                <th><?php echo e(__('ID')); ?></th>
                <th><?php echo e(__('Title')); ?></th>
                <th><?php echo e(__('Priority')); ?></th>
                <th><?php echo e(__('Status')); ?></th>
                <th><?php echo e(__('Action')); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="table_row">
                    <td><?php echo e($ticket->id); ?></td>
                    <td><?php echo e($ticket->title); ?></td>
                    <td>
                        <div class="dashboard_table__main__priority">
                            <?php if($ticket->priority=='low'): ?> <a href="javascript:void(0)" class="priorityBtn pending"><?php echo e(__(ucfirst($ticket->priority))); ?></a><?php endif; ?>
                            <?php if($ticket->priority=='high'): ?> <a href="javascript:void(0)" class="priorityBtn high"><?php echo e(__(ucfirst($ticket->priority))); ?></a><?php endif; ?>
                            <?php if($ticket->priority=='medium'): ?> <a href="javascript:void(0)" class="priorityBtn medium"><?php echo e(__(ucfirst($ticket->priority))); ?></a><?php endif; ?>
                            <?php if($ticket->priority=='urgent'): ?> <a href="javascript:void(0)" class="priorityBtn urgent"><?php echo e(__(ucfirst($ticket->priority))); ?></a><?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <?php if($ticket->status === 'open'): ?>
                            <span class="status accepted-status" ><?php echo e(__('Open')); ?></span>
                        <?php else: ?>
                            <span class="status cancel-status" ><?php echo e(__('Close')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-wrapper mb-20">
                         <a class="red-global-btn" href="<?php echo e(route('user.ticket.details',$ticket->id)); ?>"><i class="las la-eye"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="deposit-history-pagination mt-4">
        <?php if (isset($component)) { $__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pagination.laravel-paginate','data' => ['allData' => $tickets]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pagination.laravel-paginate'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['allData' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tickets)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f)): ?>
<?php $attributes = $__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f; ?>
<?php unset($__attributesOriginal0143df8887fb9686c5dbf1f1b0d7027f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f)): ?>
<?php $component = $__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f; ?>
<?php unset($__componentOriginal0143df8887fb9686c5dbf1f1b0d7027f); ?>
<?php endif; ?>
    </div>
<?php else: ?>
    <?php if (isset($component)) { $__componentOriginal3f9c527cb64b91d88649358c43ef5eb0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pagination.empty-data-placeholder','data' => ['title' => __('No Ticket Created Yet')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pagination.empty-data-placeholder'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('No Ticket Created Yet'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0)): ?>
<?php $attributes = $__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0; ?>
<?php unset($__attributesOriginal3f9c527cb64b91d88649358c43ef5eb0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f9c527cb64b91d88649358c43ef5eb0)): ?>
<?php $component = $__componentOriginal3f9c527cb64b91d88649358c43ef5eb0; ?>
<?php unset($__componentOriginal3f9c527cb64b91d88649358c43ef5eb0); ?>
<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Nat-Easy-Ad-Me\core\Modules/SupportTicket\resources/views/user/search-result.blade.php ENDPATH**/ ?>