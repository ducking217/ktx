@php
    $toast_loai = session('toast_loai');
    $toast_noidung = session('toast_noidung');

    if (session('success')) {
        $toast_loai = 'thanhcong';
        $toast_noidung = session('success');
    } elseif (session('error')) {
        $toast_loai = 'loi';
        $toast_noidung = session('error');
    }
@endphp

@if ($toast_loai && $toast_noidung)
    @php
        $mau = ($toast_loai === 'thanhcong' || $toast_loai === 'success')
            ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
            : 'border-rose-200 bg-rose-50 text-rose-700';
        $tieude = ($toast_loai === 'thanhcong' || $toast_loai === 'success') ? 'Thành công' : 'Lỗi';
    @endphp

    <div class="fixed bottom-5 right-5 z-50 animate-pop-in">
        <div id="toast-thongbao" class="linear-panel flex w-full max-w-sm items-start gap-3 p-3" role="alert" aria-live="assertive">
            <div class="inline-flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-md border {{ $mau }}" aria-hidden="true">
                @if ($toast_loai === 'thanhcong' || $toast_loai === 'success')
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                @else
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.8" d="M12 9v4m0 4h.01M10.29 3.86l-7.17 12.4A2 2 0 004.85 19h14.3a2 2 0 001.73-2.74l-7.17-12.4a2 2 0 00-3.46 0z"/></svg>
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-bold tracking-wide text-slate-900">{{ $tieude }}</div>
                <div class="mt-0.5 text-sm text-slate-600">{{ $toast_noidung }}</div>
            </div>
            <button type="button"
                    class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-transparent text-slate-400 transition hover:border-slate-200 hover:bg-slate-100 hover:text-slate-900"
                    data-dismiss-target="#toast-thongbao"
                    aria-label="Đóng thông báo">
                <span class="sr-only">Đóng</span>
                <svg class="h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m1 1 12 12M13 1 1 13"/>
                </svg>
            </button>
        </div>
    </div>
@endif
