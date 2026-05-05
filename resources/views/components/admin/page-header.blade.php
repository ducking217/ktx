@props([
    'title',
    'subtitle' => null,
])

<header {{ $attributes->merge(['class' => 'flex flex-col md:flex-row md:items-center justify-between gap-4']) }}>
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h2>
        @if($subtitle)
            <p class="text-sm text-slate-500 font-medium mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>

    @if(trim($slot))
        <div class="flex items-center gap-3">
            {{ $slot }}
        </div>
    @endif
</header>

