@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 py-4 text-sm font-bold text-brand-emerald transition duration-150 border-b-2 border-brand-emerald'
            : 'inline-flex items-center px-1 py-4 text-sm font-bold text-ink-secondary/60 transition duration-150 hover:text-ink-primary';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
