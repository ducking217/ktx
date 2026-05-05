<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => 'Không có dữ liệu',
    'description' => 'Dữ liệu sẽ hiển thị tại đây khi có bản ghi mới.',
    'actionLabel' => null,
    'actionHref' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => 'Không có dữ liệu',
    'description' => 'Dữ liệu sẽ hiển thị tại đây khi có bản ghi mới.',
    'actionLabel' => null,
    'actionHref' => null,
]); ?>
<?php foreach (array_filter(([
    'title' => 'Không có dữ liệu',
    'description' => 'Dữ liệu sẽ hiển thị tại đây khi có bản ghi mới.',
    'actionLabel' => null,
    'actionHref' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'linear-empty'])); ?>>
    <div class="linear-skeleton h-14 w-14 rounded-2xl"></div>
    <h3 class="linear-empty-title"><?php echo e($title); ?></h3>
    <p class="linear-empty-subtitle"><?php echo e($description); ?></p>

    <?php if($actionLabel && $actionHref): ?>
        <a href="<?php echo e($actionHref); ?>" class="linear-btn-primary mt-1">
            <?php echo e($actionLabel); ?>

        </a>
    <?php endif; ?>
</div>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/components/empty-state.blade.php ENDPATH**/ ?>