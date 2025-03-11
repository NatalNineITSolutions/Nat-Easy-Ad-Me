<?php $__currentLoopData = $data->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if (isset($component)) { $__componentOriginald58aaee7eca20361c7b88a24778f1fb9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald58aaee7eca20361c7b88a24778f1fb9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'chat::components.member.message','data' => ['message' => $message,'data' => $data]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('chat::member.message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($message),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald58aaee7eca20361c7b88a24778f1fb9)): ?>
<?php $attributes = $__attributesOriginald58aaee7eca20361c7b88a24778f1fb9; ?>
<?php unset($__attributesOriginald58aaee7eca20361c7b88a24778f1fb9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald58aaee7eca20361c7b88a24778f1fb9)): ?>
<?php $component = $__componentOriginald58aaee7eca20361c7b88a24778f1fb9; ?>
<?php unset($__componentOriginald58aaee7eca20361c7b88a24778f1fb9); ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laragon\www\easyadme\core\Modules/Chat\resources/views/member/message-body.blade.php ENDPATH**/ ?>