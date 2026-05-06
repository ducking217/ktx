@extends('student.layouts.chinh')

@section('student_page_title', 'Bảng điều khiển')

@section('noidung')
    @php
        $tongTienCanDong = (int) $hoadonchuathanhtoan->sum('tong_tien');
        $tongThanhVien = (isset($thanhviencungphong) ? $thanhviencungphong->count() : 0) + ($sinhvien ? 1 : 0);
        $hoaDonGanNhat = $hoadonchuathanhtoan->take(3);
    @endphp

    <div class="space-y-8">
        <x-admin.page-header
            title="Tổng quan cư dân"
            subtitle="Theo dõi trạng thái cư trú, hóa đơn và các thông báo mới nhất từ Ban quản lý."
        />

        {{-- KPI Cards Bento --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1: Phòng --}}
            <article class="saas-card p-6 flex flex-col justify-between group hover:border-slate-300 transition-all">
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300 border border-slate-100">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Vị trí hiện tại</span>
                    </div>
                    <h3 class="text-2xl font-bold tracking-tight text-slate-900 leading-tight mb-1">{{ $phonghientai->ten_phong ?? 'Chưa xếp phòng' }}</h3>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                        {{ $phonghientai ? ('Tòa '.$phonghientai->toa.' • Tầng '.$phonghientai->tang) : 'Liên hệ BQL để được sắp xếp' }}
                    </div>
                </div>
                <div class="inline-flex items-center gap-1.5 rounded-lg bg-slate-50 px-3 py-1.5 text-[10px] font-bold text-slate-600 uppercase tracking-widest border border-slate-200 w-fit tabular-nums">
                    {{ $tongThanhVien }} Thành viên
                </div>
            </article>

            {{-- Card 2: Tài chính --}}
            <article class="saas-card p-6 flex flex-col justify-between group hover:border-slate-300 transition-all">
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 transition-all duration-300 {{ $tongTienCanDong > 0 ? 'group-hover:bg-rose-600 group-hover:text-white' : 'group-hover:bg-slate-900 group-hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Công nợ hiện tại</span>
                    </div>
                    <div class="flex items-baseline gap-1 mb-1">
                        <span class="text-2xl font-bold tracking-tight tabular-nums {{ $tongTienCanDong > 0 ? 'text-rose-600' : 'text-brand-emerald' }}">{{ number_format($tongTienCanDong) }}</span>
                        <span class="text-xs font-bold text-slate-300">VNĐ</span>
                    </div>
                    <div class="text-[11px] font-bold uppercase tracking-widest {{ $tongTienCanDong > 0 ? 'text-rose-400' : 'text-brand-emerald/70' }}">
                        {{ $tongTienCanDong > 0 ? 'Cần thanh toán ngay' : 'Đã hoàn tất nghĩa vụ' }}
                    </div>
                </div>
                <a href="{{ route('student.hoadon.index') }}" class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-brand-emerald hover:text-brand-emerald/80 transition-colors w-fit">
                    Chi tiết hóa đơn
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </article>

            {{-- Card 3: Thời hạn Hợp đồng --}}
            <x-countdown-hopdong :hopdong="$hopdongHienTai" :soNgayCon="$soNgayCon" />
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- LEFT: Hóa đơn & Actions --}}
            <div class="lg:col-span-8 space-y-8">
                <article class="saas-card overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Giao dịch gần nhất</h2>
                        <a href="{{ route('student.hoadon.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-brand-emerald hover:text-brand-emerald/80">Tất cả</a>
                    </div>

                    <div class="divide-y divide-slate-50">
                        @forelse ($hoaDonGanNhat as $hoadon)
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100 group-hover:bg-white transition-colors">
                                        @if($hoadon->loai_hoadon === 'dien_nuoc')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        @else
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 tracking-tight">{{ preg_replace('/\bKy\s+/u', 'Tháng ', (string) $hoadon->ghi_chu) }}</h4>
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $hoadon->loai_hoadon === 'dien_nuoc' ? 'Hóa đơn dịch vụ' : 'Hợp đồng cư trú' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-slate-900 tabular-nums mb-1">{{ number_format($hoadon->tong_tien) }}đ</div>
                                    @php
                                        $isPaid = $hoadon->trang_thai === \App\Enums\InvoiceStatus::Paid;
                                    @endphp
                                    <span class="saas-badge {{ $isPaid ? 'saas-badge-success' : 'saas-badge-error' }} !py-0.5 !px-2">
                                        {{ $isPaid ? 'Đã thu' : 'Chờ nộp' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có dữ liệu giao dịch</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                {{-- Pro Tool Grid --}}
                <div class="grid grid-cols-3 gap-6">
                    @php
                        $quickActions = [
                            ['route' => 'student.hoadon.index', 'label' => 'Thanh toán', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'student.hopdong.index', 'label' => 'Gia hạn', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'params' => ['tab' => 'gia-han']],
                            ['route' => 'student.thongbao', 'label' => 'Bản tin', 'icon' => 'M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0'],
                        ];
                    @endphp
                    @foreach ($quickActions as $action)
                        <a href="{{ route($action['route'], $action['params'] ?? []) }}" class="saas-card p-5 group flex flex-col items-center gap-3 transition-all hover:border-slate-300 text-center">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all duration-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/></svg>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-900 transition-colors">{{ $action['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Notifications & Emergency --}}
            <aside class="lg:col-span-4 space-y-8">
                <article class="saas-card overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/30">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Thông báo mới nhất</h2>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse ($thongbao as $item)
                            <a href="{{ route('student.chitietthongbao', $item->id) }}" class="group block p-5 transition-colors hover:bg-slate-50/50">
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 tabular-nums">{{ $item->created_at->format('d/m/Y') }}</div>
                                <h4 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 tracking-tight group-hover:text-brand-emerald transition-colors">{{ $item->tieu_de }}</h4>
                            </a>
                        @empty
                            <div class="py-12 text-center">
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có thông báo mới</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                <article class="saas-card bg-slate-900 border-slate-800 p-6 text-white relative overflow-hidden group">
                    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-slate-800/30 blur-3xl group-hover:bg-emerald-500/10 transition-colors duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6 border-b border-slate-800 pb-5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-800 text-slate-400 ring-1 ring-slate-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h2 class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Đường dây nóng</h2>
                        </div>
                        <div class="space-y-5">
                            @foreach ($lienhekhancap as $contact)
                                <div class="flex flex-col gap-1 group/line">
                                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-600 group-hover/line:text-slate-400 transition-colors">{{ $contact['title'] }}</span>
                                    <a href="tel:{{ $contact['phone'] }}" class="text-sm font-bold tabular-nums tracking-tight hover:text-brand-emerald transition-colors text-slate-300">{{ $contact['phone'] }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            </aside>
        </div>
    </div>
@endsection
