@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl bg-blue-50/50 p-4 border border-blue-100/50']) }}>
        <div class="flex items-center gap-3">
            <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-[11px] font-bold text-blue-600 uppercase tracking-widest">{{ $status }}</span>
        </div>
    </div>
@endif
