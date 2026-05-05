@props([
    'caption' => null,
])

<article {{ $attributes->merge(['class' => 'saas-card overflow-hidden']) }}>
    @isset($header)
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
            {{ $header }}
        </div>
    @endisset
    <div class="overflow-x-auto">
        <table class="saas-table">
            @if($caption)
                <caption class="sr-only">{{ $caption }}</caption>
            @endif
            {{ $slot }}
        </table>
    </div>
</article>
