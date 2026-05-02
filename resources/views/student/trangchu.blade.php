@extends('student.layouts.chinh')

@section('student_page_title', 'Bảng điều khiển')

@section('noidung')
    @php
        $isAlumni = auth()->user()->vaitro === \App\Enums\UserRole::CuuSinhVien;
        $tongTienCanDong = (int) $hoadonchuathanhtoan->sum('tongtien');
        $ngayConLaiHopDong = null;

        if (!empty($sinhvien?->ngay_het_han)) {
            $ngayConLaiHopDong = now()->startOfDay()->diffInDays(
                \Illuminate\Support\Carbon::parse($sinhvien->ngay_het_han)->startOfDay(),
                false
            );
        }

        $tongThanhVien = (isset($thanhviencungphong) ? $thanhviencungphong->count() : 0) + ($sinhvien ? 1 : 0);
        $hoaDonGanNhat = $hoadonchuathanhtoan->take(3);
        $trangThaiDon = $isAlumni ? 'Cựu sinh viên' : 'Đang cư trú';

        if (!$isAlumni) {
            if (empty($sinhvien?->phong_id)) {
                $trangThaiDon = 'Chờ xếp phòng';
            } elseif (is_null($ngayConLaiHopDong)) {
                $trangThaiDon = 'Chờ ký Hợp đồng';
            }
        }
    @endphp

    <div class="space-y-10 animate-fade-up">
        
        {{-- KPI Cards Bento --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1: Phòng --}}
            <article class="pdu-card group relative overflow-hidden !p-0">
                <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-brand-emerald/5 transition-transform duration-700 group-hover:scale-[2.5]"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-brand-emerald border border-ui-border group-hover:border-brand-emerald/30 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-ink-secondary/30">Không gian sống</span>
                    </div>
                    <h3 class="font-display text-2xl font-black text-ink-primary tracking-tight mb-1 uppercase">{{ $phonghientai->tenphong ?? 'Chờ xếp' }}</h3>
                    <div class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest">
                        {{ $phonghientai ? ('Tòa '.$phonghientai->toa.' • Tầng '.$phonghientai->tang) : 'Chưa ghi nhận vị trí' }}
                    </div>
                </div>
                <div class="bg-ui-bg/50 px-6 py-3 border-t border-ui-border flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald animate-pulse"></span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-secondary/60">{{ $tongThanhVien }} cư dân đang lưu trú</span>
                </div>
            </article>

            {{-- Card 2: Tài chính --}}
            <article class="pdu-card group relative overflow-hidden !p-0">
                <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full {{ $tongTienCanDong > 0 ? 'bg-status-error/5' : 'bg-brand-emerald/5' }} transition-transform duration-700 group-hover:scale-[2.5]"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div @class([
                            'flex h-12 w-12 items-center justify-center rounded-xl border border-ui-border transition-colors group-hover:border-opacity-50',
                            'bg-ui-bg text-status-error group-hover:border-status-error/30' => $tongTienCanDong > 0,
                            'bg-ui-bg text-brand-emerald group-hover:border-brand-emerald/30' => $tongTienCanDong <= 0,
                        ])>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-ink-secondary/30">Tài chính</span>
                    </div>
                    <h3 @class([
                        'font-display text-2xl font-black tabular-nums tracking-tight mb-1',
                        'text-status-error' => $tongTienCanDong > 0,
                        'text-ink-primary' => $tongTienCanDong <= 0,
                    ])>{{ number_format($tongTienCanDong) }}đ</h3>
                    <div @class([
                        'text-[10px] font-bold uppercase tracking-widest',
                        'text-status-error/60' => $tongTienCanDong > 0,
                        'text-brand-emerald/60' => $tongTienCanDong <= 0,
                    ])>
                        {{ $tongTienCanDong > 0 ? 'Phát sinh công nợ' : 'Tài khoản sạch' }}
                    </div>
                </div>
                <a href="{{ route('student.hoadoncuaem') }}" class="block bg-ui-bg/50 px-6 py-3 border-t border-ui-border hover:bg-white transition-colors group/link">
                    <span class="text-[9px] font-black uppercase tracking-widest text-ink-primary flex items-center justify-between">
                        Xem chi tiết hóa đơn
                        <svg class="h-3 w-3 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>
            </article>

            {{-- Card 3: Trạng thái --}}
            <article class="pdu-card group relative overflow-hidden !p-0">
                <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-ink-primary/5 transition-transform duration-700 group-hover:scale-[2.5]"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-ink-primary border border-ui-border group-hover:border-ink-primary/30 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-ink-secondary/30">Pháp lý</span>
                    </div>
                    <h3 class="font-display text-2xl font-black text-ink-primary tracking-tight mb-1 uppercase">{{ $trangThaiDon }}</h3>
                    <div class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest">Năm học {{ date('Y') }}-{{ date('Y')+1 }}</div>
                </div>
                <div class="bg-ui-bg/50 px-6 py-3 border-t border-ui-border">
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-1 bg-ui-border rounded-full overflow-hidden">
                            @php $percent = $ngayConLaiHopDong ? max(0, min(100, (180 - $ngayConLaiHopDong) / 180 * 100)) : 0; @endphp
                            <div class="h-full bg-ink-primary" @style(["width: $percent%"])></div>
                        </div>
                        <span class="text-[9px] font-black uppercase text-ink-secondary/60 tabular-nums">{{ $ngayConLaiHopDong ?? 0 }} ngày còn lại</span>
                    </div>
                </div>
            </article>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- LEFT: Hóa đơn --}}
            <div class="lg:col-span-8 space-y-8">
                <article class="pdu-card !p-0 overflow-hidden">
                    <div class="flex items-center justify-between px-8 py-6 border-b border-ui-border bg-ui-bg/30">
                        <h2 class="text-[11px] font-black text-ink-primary uppercase tracking-widest">Giao dịch gần đây</h2>
                        <a href="{{ route('student.hoadoncuaem') }}" class="pdu-btn-ghost !px-3 !py-1.5 !text-[9px] uppercase tracking-widest">Tất cả</a>
                    </div>

                    <div class="divide-y divide-ui-border">
                        @forelse ($hoaDonGanNhat as $hoadon)
                            <div class="group flex items-center justify-between px-8 py-5 transition-colors hover:bg-ui-bg/30">
                                <div class="flex items-center gap-5 min-w-0">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary border border-ui-border group-hover:border-brand-emerald/30 group-hover:text-brand-emerald transition-all">
                                        @if($hoadon->loai_hoadon === 'dien_nuoc')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        @else
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-ink-primary text-sm truncate tracking-tight uppercase">{{ $hoadon->loai_hoadon === 'dien_nuoc' ? 'Tiền điện nước' : 'Phí lưu trú' }}</h4>
                                        <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest tabular-nums">Kỳ T{{ $hoadon->thang }}/{{ $hoadon->nam }}</div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0 pl-4">
                                    <div class="font-display text-base font-black text-ink-primary tabular-nums tracking-tight mb-1">{{ number_format($hoadon->tongtien) }}đ</div>
                                    @php
                                        $isPaid = $hoadon->trangthaithanhtoan === \App\Enums\InvoiceStatus::Paid;
                                    @endphp
                                    <span @class([
                                        'inline-flex items-center rounded-lg px-2 py-0.5 text-[8px] font-black uppercase tracking-widest ring-1',
                                        'bg-status-success/10 text-status-success ring-status-success/20' => $isPaid,
                                        'bg-status-error/10 text-status-error ring-status-error/20' => !$isPaid,
                                    ])>
                                        {{ $isPaid ? 'Đã thu' : 'Chưa đóng' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="py-20 flex flex-col items-center justify-center text-ink-secondary/20">
                                <svg class="h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-[10px] font-black uppercase tracking-widest italic">Lịch sử giao dịch trống</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                {{-- Quick Actions --}}
                <div class="grid grid-cols-3 gap-6">
                    <a href="{{ route('student.hoadoncuaem') }}" class="pdu-card group flex flex-col items-center gap-4 text-center hover:border-brand-emerald/40">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary border border-ui-border group-hover:bg-brand-emerald group-hover:text-white group-hover:border-brand-emerald transition-all duration-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-black text-ink-secondary uppercase tracking-widest group-hover:text-ink-primary transition-colors">Thanh toán</span>
                    </a>
                    <a href="{{ route('student.phongcuatoi') }}" class="pdu-card group flex flex-col items-center gap-4 text-center hover:border-brand-emerald/40">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary border border-ui-border group-hover:bg-brand-emerald group-hover:text-white group-hover:border-brand-emerald transition-all duration-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-[10px] font-black text-ink-secondary uppercase tracking-widest group-hover:text-ink-primary transition-colors">Gia hạn</span>
                    </a>
                    <a href="{{ route('student.thongbao') }}" class="pdu-card group flex flex-col items-center gap-4 text-center hover:border-brand-emerald/40">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary border border-ui-border group-hover:bg-brand-emerald group-hover:text-white group-hover:border-brand-emerald transition-all duration-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"/></svg>
                        </div>
                        <span class="text-[10px] font-black text-ink-secondary uppercase tracking-widest group-hover:text-ink-primary transition-colors">Thông báo</span>
                    </a>
                </div>
            </div>

            {{-- RIGHT: Thông báo & Khẩn cấp --}}
            <aside class="lg:col-span-4 space-y-8">
                <article class="pdu-card !p-0 overflow-hidden">
                    <div class="px-8 py-6 border-b border-ui-border bg-ui-bg/30">
                        <h2 class="text-[11px] font-black text-ink-primary uppercase tracking-widest">Tin tức KTX</h2>
                    </div>
                    <div class="divide-y divide-ui-border">
                        @forelse ($thongbao as $item)
                            <a href="{{ route('student.chitietthongbao', $item->id) }}" class="group block p-6 transition-colors hover:bg-ui-bg/30">
                                <div class="text-[8px] font-black text-brand-emerald uppercase tracking-widest mb-2">{{ $item->ngaydang->format('d/m/Y') }}</div>
                                <h4 class="font-bold text-ink-primary text-xs leading-relaxed line-clamp-2 tracking-tight group-hover:text-brand-emerald transition-colors">{{ $item->tieude }}</h4>
                            </a>
                        @empty
                            <div class="py-16 text-center text-ink-secondary/20">
                                <p class="text-[10px] font-black uppercase tracking-widest">Hộp thư trống</p>
                            </div>
                        @endforelse
                    </div>
                </article>

                <article class="pdu-card !bg-ink-primary !border-ink-primary !p-8 text-white relative overflow-hidden group shadow-xl shadow-ink-primary/20">
                    <div class="absolute -right-12 -bottom-12 h-40 w-40 rounded-full bg-white/5 transition-transform group-hover:scale-150 duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-8 border-b border-white/10 pb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-white ring-1 ring-white/20">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h2 class="text-[11px] font-black uppercase tracking-[0.25em] text-white/50">Hỗ trợ khẩn cấp</h2>
                        </div>
                        <div class="space-y-6">
                            @foreach ($lienhekhancap as $contact)
                                <div class="flex flex-col gap-1 group/line">
                                    <span class="text-[9px] font-black uppercase tracking-widest text-white/40 group-hover/line:text-white/60 transition-colors">{{ $contact['title'] }}</span>
                                    <a href="tel:{{ $contact['phone'] }}" class="font-display text-lg font-black tabular-nums tracking-tighter hover:text-brand-emerald transition-colors">{{ $contact['phone'] }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            </aside>
        </div>
    </div>
@endsection
