<?php extract(collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>

<?php if (isset($component)) { $__componentOriginalb214106a69bfa466c2c4b4ba59e2cbd9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb214106a69bfa466c2c4b4ba59e2cbd9 = $attributes; } ?>
<?php $component = App\View\Components\StudentLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('student-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\StudentLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>
 <?php $__env->slot('title', null, []); ?> <?php echo e($title); ?> <?php $__env->endSlot(); ?>
<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb214106a69bfa466c2c4b4ba59e2cbd9)): ?>
<?php $attributes = $__attributesOriginalb214106a69bfa466c2c4b4ba59e2cbd9; ?>
<?php unset($__attributesOriginalb214106a69bfa466c2c4b4ba59e2cbd9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb214106a69bfa466c2c4b4ba59e2cbd9)): ?>
<?php $component = $__componentOriginalb214106a69bfa466c2c4b4ba59e2cbd9; ?>
<?php unset($__componentOriginalb214106a69bfa466c2c4b4ba59e2cbd9); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\hethongquanlyktxv1\storage\framework\views/5fa719fdac5687cb4dfb06c3c55cf990.blade.php ENDPATH**/ ?>