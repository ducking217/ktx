<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'name' => null,
    'title' => null,
    'subtitle' => null,
    'show' => false,
    'maxWidth' => '2xl'
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'name' => null,
    'title' => null,
    'subtitle' => null,
    'show' => false,
    'maxWidth' => '2xl'
]); ?>
<?php foreach (array_filter(([
    'name' => null,
    'title' => null,
    'subtitle' => null,
    'show' => false,
    'maxWidth' => '2xl'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
$modalName = $name ?? $attributes->get('id');
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
?>

<div
    <?php echo e($attributes->merge(['id' => $modalName, 'class' => 'fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0'])); ?>

    x-data="{
        show: <?php echo \Illuminate\Support\Js::from($show)->toHtml() ?>,
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            <?php echo e($attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : ''); ?>

        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="$event.detail == '<?php echo e($modalName); ?>' ? show = true : null"
    x-on:close-modal.window="$event.detail == '<?php echo e($modalName); ?>' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    style="display: <?php echo e($show ? 'block' : 'none'); ?>;"
>
    <div
        x-show="show"
        class="linear-modal-backdrop fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-slate-900/40"></div>
    </div>

    <div
        x-show="show"
        class="linear-modal-card mb-6 overflow-hidden transform transition-all sm:mx-auto sm:w-full <?php echo e($maxWidth); ?> <?php echo e($title ? 'rounded-2xl bg-ui-card ring-1 ring-ui-border shadow-xl' : ''); ?>"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <?php if($title): ?>
            <div class="px-6 py-4 bg-ui-bg/40 border-b border-ui-border">
                <div class="text-[11px] font-black uppercase tracking-widest text-ink-primary"><?php echo e($title); ?></div>
                <?php if($subtitle): ?>
                    <div class="mt-1 text-[10px] font-medium text-ink-secondary/60"><?php echo e($subtitle); ?></div>
                <?php endif; ?>
            </div>
            <div class="p-6">
                <?php echo e($slot); ?>

            </div>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\laragon\www\hethongquanlyktxv1\resources\views/components/modal.blade.php ENDPATH**/ ?>