@props([
    'items',
    'active' => null,
    'route',
    'param' => 'status',
    'defaultLabel' => 'Tất cả',
    'defaultValue' => null,
])

@php
    $activeValue = $active;
    $tabs = collect($items)->map(fn ($label, $value) => [
        'label' => $label,
        'value' => $value,
    ]);
@endphp

<nav class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80 w-fit" aria-label="Bộ lọc trạng thái">
    @foreach($tabs as $tab)
        @php
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
        @endphp

        <a
            href="{{ route($route, $hrefParams) }}"
            class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all {{ $isActive ? 'bg-white text-brand-emerald shadow-sm' : 'text-slate-400 hover:text-slate-600' }}"
            aria-current="{{ $isActive ? 'page' : 'false' }}"
        >
            {{ $label }}
        </a>
    @endforeach
</nav>
