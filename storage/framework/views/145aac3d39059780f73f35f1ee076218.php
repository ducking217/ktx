<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['active']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['active']); ?>
<?php foreach (array_filter((['active']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl bg-brand-emerald/10 px-3 py-2 text-start text-sm font-bold text-brand-emerald transition duration-150'
            : 'block w-full rounded-xl px-3 py-2 text-start text-sm font-bold text-ink-secondary/60 transition duration-150 hover:bg-ui-muted hover:text-ink-primary';
?>

<a <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <?php echo e($slot); ?>

</a>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/components/responsive-nav-link.blade.php ENDPATH**/ ?>