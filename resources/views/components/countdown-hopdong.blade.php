@props(['hopdong', 'soNgayCon'])

@php
    $statusClass = '';
    $statusLabel = '';
    $icon = '';
    
    if ($soNgayCon === null) {
        $statusClass = 'saas-badge bg-slate-100 text-slate-600 ring-slate-500/10';
        $statusLabel = 'Chưa có hợp đồng';
        $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
    } elseif ($soNgayCon > 30) {
        $statusClass = 'saas-badge saas-badge-success';
        $statusLabel = 'Hợp đồng đang hiệu lực';
        $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
    } elseif ($soNgayCon > 7) {
        $statusClass = 'saas-badge saas-badge-warning';
        $statusLabel = 'Sắp hết hạn';
        $icon = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
    } elseif ($soNgayCon > 0) {
        $statusClass = 'saas-badge saas-badge-error';
        $statusLabel = 'Sắp hết hạn khẩn cấp';
        $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
    } else {
        $statusClass = 'saas-badge saas-badge-error opacity-80';
        $statusLabel = 'Đã hết hạn';
        $icon = 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z';
    }
@endphp

<div class="saas-card overflow-hidden">
    <div class="p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h3 class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Thời hạn hợp đồng</h3>
                <div class="{{ $statusClass }}">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $icon }}"/></svg>
                    {{ $statusLabel }}
                </div>
            </div>
            
            @if($hopdong)
                <div class="text-right">
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Phòng</div>
                    <div class="text-sm font-bold text-slate-900">{{ $hopdong->phong->tenphong }}</div>
                </div>
            @endif
        </div>

        @if($hopdong)
            <div class="flex items-baseline gap-1.5 mb-4">
                @if($soNgayCon > 0)
                    <span class="text-4xl font-bold tracking-tight text-slate-900 tabular-nums leading-none">{{ $soNgayCon }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ngày còn lại</span>
                @else
                    <span class="text-3xl font-bold tracking-tight text-rose-600 uppercase">Hết hạn</span>
                @endif
            </div>

            <div class="flex items-center gap-4 py-3 border-y border-slate-100 mb-6">
                <div class="flex-1">
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Ngày bắt đầu</div>
                    <div class="text-xs font-bold text-slate-900">{{ \Carbon\Carbon::parse($hopdong->ngay_bat_dau)->format('d/m/Y') }}</div>
                </div>
                <div class="w-px h-6 bg-slate-200"></div>
                <div class="flex-1">
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Ngày kết thúc</div>
                    <div class="text-xs font-bold text-slate-900">{{ \Carbon\Carbon::parse($hopdong->ngay_ket_thuc)->format('d/m/Y') }}</div>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <a href="{{ route('student.giahan.tao') }}" class="saas-btn-primary w-full justify-center group">
                    <span>Gửi yêu cầu gia hạn</span>
                    <svg class="w-4 h-4 ml-1.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        @else
            <div class="py-8 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm border border-slate-100">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <p class="text-sm font-bold text-slate-900 mb-1">Bạn chưa có hợp đồng thuê phòng</p>
                <p class="text-[10px] text-slate-500 mb-4">Hãy đăng ký phòng để bắt đầu sử dụng dịch vụ.</p>
                <a href="{{ route('student.danhsachphong') }}" class="saas-btn-secondary py-1.5 px-4 text-xs mx-auto">
                    Đăng ký phòng ngay
                </a>
            </div>
        @endif
    </div>
</div>
