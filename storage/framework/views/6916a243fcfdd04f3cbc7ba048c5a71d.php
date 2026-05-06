<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'items',
    'active' => null,
    'route',
    'param' => 'status',
    'defaultLabel' => 'Tất cả',
    'defaultValue' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'items',
    'active' => null,
    'route',
    'param' => 'status',
    'defaultLabel' => 'Tất cả',
    'defaultValue' => null,
]); ?>
<?php foreach (array_filter(([
    'items',
    'active' => null,
    'route',
    'param' => 'status',
    'defaultLabel' => 'Tất cả',
    'defaultValue' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $activeValue = $active;
    $tabs = collect($items)->map(fn ($label, $value) => [
        'label' => $label,
        'value' => $value,
    ]);
?>

<nav class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80 w-fit" aria-label="Bộ lọc trạng thái">
    <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $value = $tab['value'];
            $label = $tab['label'];

            $isDefault = $defaultValue === null
                ? ($value === $defaultLabel)
                : ($value === $defaultValue);

            $isActive = $activeValue !== null
                ? ((string) $activeValue === (string) $value)
                : $isDefault;

            $hrefParams = array_merge(
                request()->query(),
                [$param => $value],
            );
        ?>

        <a
            href="<?php echo e(route($route, $hrefParams)); ?>"
            class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all <?php echo e($isActive ? 'bg-white text-brand-emerald shadow-sm' : 'text-slate-400 hover:text-slate-600'); ?>"
            aria-current="<?php echo e($isActive ? 'page' : 'false'); ?>"
        >
            <?php echo e($label); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/components/admin/status-tabs.blade.php ENDPATH**/ ?>