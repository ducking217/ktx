<x-admin-layout>
    <x-slot:title>Bảng điều khiển</x-slot:title>

    {{-- Row 1: Stats --}}
    <section class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-12">

        {{-- Operational Overview --}}
        <article class="saas-card lg:col-span-8 p-8 flex flex-col justify-between overflow-hidden relative">
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald animate-pulse"></span>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Tổng quan vận hành</span>
                </div>

                <h2 class="text-2xl font-bold tracking-tight text-slate-900 leading-tight mb-2">
                    Công suất lấp đầy: <span class="text-brand-emerald tabular-nums">{{ $tyLeLapDay }}%</span>
                </h2>
                <p class="text-xs text-slate-400 font-medium max-w-xl leading-relaxed">
                    Đang vận hành <span class="text-slate-700 font-bold tabular-nums">{{ $phongDangSuDung }}</span> phòng,
                    còn <span class="text-slate-700 font-bold tabular-nums">{{ $phongTrong }}</span> phòng trống,
                    <span class="text-slate-700 font-bold tabular-nums">{{ $phongBaoTri }}</span> đang bảo trì.
                </p>
            </div>

            <div class="relative z-10 mt-8 grid grid-cols-3 gap-8 border-t border-slate-100 pt-6">
                <div class="space-y-3">
                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Chỉ số lưu trú</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-3xl font-bold tracking-tight text-slate-900 tabular-nums">{{ $tyLeLapDay }}</span>
                        <span class="text-sm font-bold text-slate-300">%</span>
                    </div>
                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200/50">
                        <div class="h-full rounded-full bg-brand-emerald transition-all duration-700" style="--width: {{ $tyLeLapDay }}%; width: var(--width);"></div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Phòng trống</div>
                    <div class="text-3xl font-bold tracking-tight text-brand-emerald tabular-nums">{{ $phongTrong }}</div>
                    <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2 py-0.5 text-[9px] font-bold text-emerald-600 uppercase tracking-widest border border-emerald-100">
                        <span class="h-1 w-1 rounded-full bg-emerald-500"></span>
                        Khả dụng
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Đang bảo trì</div>
                    <div class="text-3xl font-bold tracking-tight text-slate-900 tabular-nums">{{ $phongBaoTri }}</div>
                    <span class="inline-flex items-center gap-1.5 rounded-md bg-amber-50 px-2 py-0.5 text-[9px] font-bold text-amber-600 uppercase tracking-widest border border-amber-100">
                        <span class="h-1 w-1 rounded-full bg-amber-500 animate-pulse"></span>
                        Đang xử lý
                    </span>
                </div>
            </div>
        </article>

        {{-- Financial Pulse --}}
        <article class="saas-card lg:col-span-4 p-8 flex flex-col justify-between overflow-hidden">
            <div>
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Doanh thu tháng này</div>
                        <div class="text-2xl font-bold tracking-tight text-slate-900 tabular-nums">
                            {{ number_format($doanhThuThangNay) }}<span class="ml-1 text-sm font-bold text-slate-300">đ</span>
                        </div>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 shadow-sm">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-[9px] font-bold border {{ $chenhLechDoanhThu >= 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-rose-50 text-rose-700 border-rose-100' }}">
                    <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $chenhLechDoanhThu >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}"/></svg>
                    {{ abs($tyLeDoanhThu) }}% so với tháng trước
                </div>
            </div>

            <div class="mt-6">
                <div class="flex items-end gap-1.5 h-16 mb-3">
                    @foreach($xuHuongDoanhThu as $item)
                        <div class="flex-1 rounded-md bg-slate-100 hover:bg-slate-800 transition-all cursor-default relative group/bar" style="--height: {{ $item['height'] }}%; height: var(--height);">
                            <div class="invisible absolute -top-9 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[9px] px-2 py-1 rounded-lg opacity-0 group-hover/bar:visible group-hover/bar:opacity-100 transition-all whitespace-nowrap z-20 font-bold tabular-nums">
                                {{ number_format($item['value']) }}đ
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center text-[8px] font-bold uppercase tracking-widest text-slate-300">Xu hướng 6 tháng</div>
            </div>
        </article>
    </section>

    {{-- Row 2: Action tiles --}}
    <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2">
        <a href="{{ route('admin.dangky.index') }}" class="saas-card p-5 flex items-center justify-between group hover:border-brand-emerald/20 transition-all hover:shadow-lg hover:shadow-brand-emerald/10">
            <div class="flex items-center gap-4">
                <div class="relative h-10 w-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300 border border-slate-100 shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    @if($dangKyChoDuyet > 0)
                        <span class="absolute -top-1.5 -right-1.5 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-brand-emerald px-1 text-[8px] font-bold text-white ring-2 ring-white">{{ $dangKyChoDuyet }}</span>
                    @endif
                </div>
                <div>
                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Chờ phê duyệt</div>
                    <div class="text-sm font-bold text-slate-900 group-hover:text-brand-emerald transition-colors">Đăng ký cư trú mới</div>
                </div>
            </div>
            <svg class="h-4 w-4 text-slate-200 group-hover:text-brand-emerald/60 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('admin.baohong.index') }}" class="saas-card p-5 flex items-center justify-between group hover:border-amber-200 transition-all hover:shadow-lg hover:shadow-amber-500/5">
            <div class="flex items-center gap-4">
                <div class="relative h-10 w-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 border border-slate-100 shadow-sm">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @if($suCoMo > 0)
                        <span class="absolute -top-1.5 -right-1.5 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-amber-500 px-1 text-[8px] font-bold text-white ring-2 ring-white">{{ $suCoMo }}</span>
                    @endif
                </div>
                <div>
                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Vận hành kỹ thuật</div>
                    <div class="text-sm font-bold text-slate-900 group-hover:text-amber-600 transition-colors">Báo hỏng & Sửa chữa</div>
                </div>
            </div>
            <svg class="h-4 w-4 text-slate-200 group-hover:text-amber-400 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
    </section>

    {{-- Row 3: Activity center --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
        <div class="space-y-6 xl:col-span-8">

            {{-- Recent Registrations --}}
            <article class="saas-card overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 tracking-tight">Hồ sơ đăng ký mới</h2>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Luồng đăng ký thời gian thực</p>
                    </div>
                    <a href="{{ route('admin.dangky.index') }}" class="saas-btn-secondary h-8 px-4 text-[9px] font-bold uppercase tracking-widest">Quản lý</a>
                </div>

                @if ($listDangKy->isEmpty())
                    <div class="p-16 flex flex-col items-center justify-center text-center">
                        <div class="h-12 w-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4 border border-slate-100 border-dashed">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có hồ sơ chờ xử lý</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($listDangKy as $dangky)
                            <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50/50 transition-colors group">
                                <div class="h-8 w-8 rounded-lg bg-slate-900 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                    {{ $dangky['initial'] }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-slate-900 truncate group-hover:text-brand-emerald transition-colors">{{ $dangky['name'] }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 flex items-center gap-1.5">
                                        <span class="text-slate-600">{{ $dangky['phongName'] }}</span>
                                        <span class="h-0.5 w-0.5 rounded-full bg-slate-300"></span>
                                        <span class="tabular-nums">{{ $dangky['time'] }}</span>
                                    </div>
                                </div>
                                <span class="saas-badge {{ str_contains($dangky['statusClass'], 'success') ? 'saas-badge-success' : 'saas-badge-info' }} text-[8px] px-2.5 py-0.5">{{ $dangky['statusLabel'] }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>

            {{-- Maintenance Requests --}}
            <article class="saas-card overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 tracking-tight">Phát hiện sự cố</h2>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Cảnh báo bảo trì hạ tầng</p>
                    </div>
                    <a href="{{ route('admin.baohong.index') }}" class="saas-btn-secondary h-8 px-4 text-[9px] font-bold uppercase tracking-widest">Điều phối</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse ($listBaoHong as $baohong)
                        <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="h-8 w-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center border border-amber-100 group-hover:bg-amber-500 group-hover:text-white transition-all duration-200 flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 group-hover:text-amber-600 transition-colors leading-tight">{{ $baohong['mota'] }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 flex items-center gap-1.5">
                                        <span class="text-slate-600">Phòng {{ $baohong['phongName'] }}</span>
                                        <span class="h-0.5 w-0.5 rounded-full bg-slate-300"></span>
                                        <span class="tabular-nums">{{ $baohong['time'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <span class="saas-badge saas-badge-warning text-[8px] px-2.5 py-0.5">{{ $baohong['statusLabel'] }}</span>
                        </div>
                    @empty
                        <div class="p-16 flex flex-col items-center justify-center text-center">
                            <div class="h-12 w-12 bg-emerald-50 text-emerald-400 rounded-2xl flex items-center justify-center mb-4 border border-emerald-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Hạ tầng đạt chuẩn</p>
                        </div>
                    @endforelse
                </div>
            </article>
        </div>

        <div class="space-y-6 xl:col-span-4">

            {{-- Tower Capacity --}}
            <article class="saas-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Công suất tòa nhà</h3>
                    <div class="h-7 w-7 rounded-lg bg-slate-50 flex items-center justify-center text-slate-300 border border-slate-100">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1"/></svg>
                    </div>
                </div>
                <div class="space-y-5">
                    @foreach ($listCongSuat as $toa)
                        <div class="group cursor-default">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-slate-700 group-hover:text-brand-emerald transition-colors uppercase tracking-tight">{{ $toa['name'] }}</span>
                                <span class="text-[9px] font-bold text-slate-500 tabular-nums bg-slate-50 px-2 py-0.5 rounded border border-slate-100">{{ $toa['percentage'] }}%</span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-slate-800 group-hover:bg-brand-emerald transition-all duration-500 rounded-full" style="--width: {{ $toa['percentage'] }}%; width: var(--width);"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            {{-- Quick Access --}}
            <article class="saas-card overflow-hidden">
                    <div class="px-6 py-5 bg-slate-900">
                    <div class="flex items-center gap-2 mb-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald"></span>
                        <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Truy cập nhanh</span>
                    </div>
                    <p class="text-white text-xs font-medium opacity-60 leading-relaxed">Cấu hình tham số và báo cáo tài chính.</p>
                </div>
                <div class="p-3 space-y-1 bg-ui-card">
                    <a href="{{ route('admin.hoadon.index', ['tab' => 'cong-no']) }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition-all group border border-transparent hover:border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-lg bg-brand-emerald/10 text-brand-emerald flex items-center justify-center border border-brand-emerald/15 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all duration-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors uppercase tracking-tight">Công nợ (trong Hóa đơn)</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-200 group-hover:text-slate-600 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('admin.cauhinh.index') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition-all group border border-transparent hover:border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center border border-slate-100 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all duration-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors uppercase tracking-tight">Tham số hệ thống</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-200 group-hover:text-slate-600 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>
        </div>
    </div>
</x-admin-layout>
