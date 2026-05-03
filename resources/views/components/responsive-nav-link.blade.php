@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl bg-brand-emerald/10 px-3 py-2 text-start text-sm font-bold text-brand-emerald transition duration-150'
            : 'block w-full rounded-xl px-3 py-2 text-start text-sm font-bold text-ink-secondary/60 transition duration-150 hover:bg-ui-muted hover:text-ink-primary';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
