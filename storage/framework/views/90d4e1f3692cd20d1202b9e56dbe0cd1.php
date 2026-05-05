<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title',
    'subtitle' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title',
    'subtitle' => null,
]); ?>
<?php foreach (array_filter(([
    'title',
    'subtitle' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<header <?php echo e($attributes->merge(['class' => 'flex flex-col md:flex-row md:items-center justify-between gap-4'])); ?>>
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-slate-900"><?php echo e($title); ?></h2>
        <?php if($subtitle): ?>
            <p class="text-sm text-slate-500 font-medium mt-0.5"><?php echo e($subtitle); ?></p>
        <?php endif; ?>
    </div>

    <?php if(trim($slot)): ?>
        <div class="flex items-center gap-3">
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?>
</header>

<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/components/admin/page-header.blade.php ENDPATH**/ ?>