<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'caption' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'caption' => null,
]); ?>
<?php foreach (array_filter(([
    'caption' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<article <?php echo e($attributes->merge(['class' => 'saas-card overflow-hidden'])); ?>>
    <?php if(isset($header)): ?>
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
            <?php echo e($header); ?>

        </div>
    <?php endif; ?>
    <div class="overflow-x-auto">
        <table class="saas-table">
            <?php if($caption): ?>
                <caption class="sr-only"><?php echo e($caption); ?></caption>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </table>
    </div>
</article>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/components/admin/table-card.blade.php ENDPATH**/ ?>