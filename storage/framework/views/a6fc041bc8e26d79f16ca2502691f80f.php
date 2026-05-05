<?php
    $segments = request()->segments();
    $currentPath = '';
?>

<?php if(count($segments) > 0): ?>
    <nav class="linear-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo e(auth()->check() ? route('dieuhuong') : route('login')); ?>">Trang chủ</a>

        <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $currentPath .= '/'.$segment;
                $label = \Illuminate\Support\Str::of($segment)->replace(['-', '_'], ' ')->title();
            ?>

            <span>/</span>
            <?php if($loop->last): ?>
                <span class="font-semibold text-slate-900"><?php echo e($label); ?></span>
            <?php else: ?>
                <a href="<?php echo e(url($currentPath)); ?>"><?php echo e($label); ?></a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
<?php endif; ?>

<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/components/breadcrumbs.blade.php ENDPATH**/ ?>