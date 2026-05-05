@props([
    'title' => 'Xác nhận',
    'message' => 'Bạn có chắc chắn muốn thực hiện hành động này?',
    'confirmText' => 'Xác nhận',
    'cancelText' => 'Hủy',
    'type' => 'warning', // warning, danger, info
])

@php
$typeStyles = [
    'warning' => ['icon' => 'text-status-warning', 'bg' => 'bg-status-warning/10', 'button' => 'linear-btn-primary'],
    'danger' => ['icon' => 'text-status-error', 'bg' => 'bg-status-error/10', 'button' => 'linear-btn-danger'],
    'info' => ['icon' => 'text-status-info', 'bg' => 'bg-status-info/10', 'button' => 'linear-btn-primary'],
];
$style = $typeStyles[$type] ?? $typeStyles['warning'];
@endphp

<div
    x-show="showConfirm"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    @click.self="showConfirm = false"
    style="display: none;"
>
    <div
        x-show="showConfirm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="linear-modal-card max-w-md w-full bg-ui-card rounded-2xl shadow-2xl overflow-hidden ring-1 ring-ui-border"
    >
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full {{ $style['bg'] }} flex items-center justify-center">
                        <svg class="h-5 w-5 {{ $style['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($type === 'danger')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            @elseif($type === 'warning')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @endif
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-ink-primary">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-ink-secondary/80">{{ $message }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    @click="showConfirm = false"
                    class="linear-btn-secondary"
                >
                    {{ $cancelText }}
                </button>
                <button
                    type="button"
                    @click="$dispatch('confirmed'); showConfirm = false"
                    class="{{ $style['button'] }}"
                >
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>
