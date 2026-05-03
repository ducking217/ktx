<x-admin-layout>
    <x-slot:title>Bảng điều khiển Admin</x-slot:title>

    <!-- STATS - Bento Grid -->
    <section class="mb-8 grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- 1. Operational Narrative (Bento Large) -->
        <article class="md:col-span-12 xl:col-span-8 pdu-card flex flex-col justify-between min-h-[280px] relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-brand-emerald/5 blur-3xl transition-all duration-500 group-hover:bg-brand-emerald/10"></div>
            
            <div class="relative z-10">
                <div class="pdu-chip mb-6 bg-brand-emerald/10 text-brand-emerald ring-1 ring-brand-emerald/20">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-emerald opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-emerald"></span>
                    </span>
                    Realtime Operations
                </div>
                
                <h2 class="text-3xl font-display font-black tracking-tight mb-4 leading-tight">
                    Công suất vận hành <br/>
                    đang ở mức <span class="text-brand-emerald">{{ $tyLeLapDay }}%</span>
                </h2>
                <p class="text-ink-secondary text-base max-w-lg leading-relaxed font-medium">
                    Hệ thống ghi nhận <span class="text-ink-primary font-bold">{{ $phongDangSuDung }}</span> đơn vị lưu trú đang hoạt động. 
                    Hạ tầng đang được duy trì ở trạng thái tối ưu.
                </p>
            </div>

            <div class="relative z-10 mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-ui-border pt-6">
                <div class="flex flex-col gap-1">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Lấp đầy</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-display font-black tracking-tighter tabular-nums">{{ $tyLeLapDay }}</span>
                        <span class="text-xs font-bold text-ink-secondary/40">%</span>
                    </div>
                    <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-ui-bg ring-1 ring-ui-border/50">
                        <div class="h-full bg-brand-emerald transition-all duration-1000 ease-out" @style(["width: $tyLeLapDay%"])></div>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Sẵn sàng</div>
                    <div class="text-2xl font-display font-black tracking-tighter text-status-success tabular-nums">{{ $phongTrong }}</div>
                    <div class="text-[10px] font-medium text-ink-secondary/40 italic">Đơn vị trống</div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Bảo trì</div>
                    <div class="text-2xl font-display font-black tracking-tighter text-status-warning tabular-nums">{{ $phongBaoTri }}</div>
                    <div class="text-[10px] font-medium text-ink-secondary/40 italic">Đang xử lý</div>
                </div>
            </div>
        </article>

        <!-- 2. Financial Pulse (Bento Medium) -->
        <article class="md:col-span-12 xl:col-span-4 pdu-card flex flex-col justify-between group">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Doanh thu T{{ $thanghientai }}</div>
                    <div class="h-11 w-11 rounded-xl bg-ui-bg flex items-center justify-center text-ink-primary border border-ui-border transition-colors group-hover:border-brand-emerald/30 group-hover:bg-brand-emerald/5">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                
                <div class="text-[34px] font-display font-black tracking-tighter text-ink-primary mb-3 tabular-nums leading-none">
                    {{ number_format($doanhThuThangNay) }}<span class="text-lg ml-1 font-bold text-ink-secondary/30 uppercase">đ</span>
                </div>

                <div class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-[11px] font-black ring-1 ring-inset {{ $chenhLechDoanhThu >= 0 ? 'bg-status-success/5 text-status-success ring-status-success/20' : 'bg-status-error/5 text-status-error ring-status-error/20' }}">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $chenhLechDoanhThu >= 0 ? 'M5 10l7-7 7 7M12 3v18' : 'M19 14l-7 7-7-7M12 21V3' }}"/></svg>
                    <span class="tabular-nums">{{ abs($tyLeDoanhThu) }}% <span class="opacity-60 font-bold uppercase text-[9px] ml-0.5 tracking-tighter">vs tháng trước</span></span>
                </div>
            </div>

            <div class="relative z-10 mt-8">
                <div class="flex items-end gap-1.5 h-16 mb-4">
                    @foreach($xuHuongDoanhThu as $item)
                        <div class="flex-1 bg-ui-muted rounded-t-lg transition-all duration-300 hover:bg-brand-emerald relative group/bar" @style(["height: {$item['height']}%"])>
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-ink-primary text-ink-white text-[10px] px-2 py-1 rounded-lg opacity-0 group-hover/bar:opacity-100 transition-all pointer-events-none font-bold tabular-nums whitespace-nowrap shadow-xl ring-1 ring-ink-white/10">
                                {{ number_format($item['value']) }}
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-2 h-2 bg-ink-primary rotate-45"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/30 text-center">Biểu đồ doanh thu 6 tháng</div>
            </div>
        </article>
    </section>

    <!-- ACTION TILES -->
    <section class="mb-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Registration Tile -->
        <a href="{{ route('admin.duyetdangky') }}" class="pdu-card group flex items-center justify-between hover:border-brand-emerald/40 min-h-[88px]">
            <div class="flex items-center gap-5 relative z-10">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-ink-primary border border-ui-border transition-all duration-300 group-hover:bg-brand-emerald/5 group-hover:border-brand-emerald/30 relative">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    @if($dangKyChoDuyet > 0)
                        <span class="absolute -top-2 -right-2 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-brand-emerald px-1.5 text-[10px] font-black text-ink-white ring-2 ring-ui-card tabular-nums shadow-sm">{{ $dangKyChoDuyet }}</span>
                    @endif
                </div>
                <div>
                    <div class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mb-1">Thẩm định</div>
                    <div class="text-xl font-display font-black text-ink-primary tracking-tight">Đơn đăng ký</div>
                </div>
            </div>
            <div class="h-11 w-11 rounded-full bg-ui-bg flex items-center justify-center text-ink-secondary/20 transition-all group-hover:text-brand-emerald group-hover:bg-brand-emerald/10 shadow-inner">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>

        <!-- Maintenance Tile -->
        <a href="{{ route('admin.quanlybaohong') }}" class="pdu-card group flex items-center justify-between hover:border-status-warning/40 min-h-[88px]">
            <div class="flex items-center gap-5 relative z-10">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-ink-primary border border-ui-border transition-all duration-300 group-hover:bg-status-warning/5 group-hover:border-status-warning/30 relative">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @if($suCoMo > 0)
                        <span class="absolute -top-2 -right-2 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-status-warning px-1.5 text-[10px] font-black text-ink-white ring-2 ring-ui-card tabular-nums shadow-sm">{{ $suCoMo }}</span>
                    @endif
                </div>
                <div>
                    <div class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mb-1">Vận hành</div>
                    <div class="text-xl font-display font-black text-ink-primary tracking-tight">Sự cố hạ tầng</div>
                </div>
            </div>
            <div class="h-11 w-11 rounded-full bg-ui-bg flex items-center justify-center text-ink-secondary/20 transition-all group-hover:text-status-warning group-hover:bg-status-warning/10 shadow-inner">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>

        <!-- Map Tile -->
        <a href="{{ route('admin.phong.map') }}" class="pdu-card group flex items-center justify-between hover:border-ink-primary/20 min-h-[88px]">
            <div class="flex items-center gap-5 relative z-10">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-ui-bg text-ink-primary border border-ui-border transition-all duration-300 group-hover:bg-ink-primary/5 group-hover:border-ink-primary/30 relative">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.488V5.488a2 2 0 011.553-1.944L9 2l6 3 5.447-2.724A2 2 0 0121 4.224v10a2 2 0 01-1.553 1.944L15 19l-6 1z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mb-1">Mô phỏng</div>
                    <div class="text-xl font-display font-black text-ink-primary tracking-tight italic">Visualizer</div>
                </div>
            </div>
            <div class="h-11 w-11 rounded-full bg-ui-bg flex items-center justify-center text-ink-secondary/20 transition-all group-hover:text-ink-primary group-hover:bg-ink-primary/10 shadow-inner">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
    </section>

    <!-- ACTIVITY & PERFORMANCE HUB -->
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-12">
        <div class="xl:col-span-8 space-y-8">
            <!-- Recent Registrations -->
            <article class="pdu-card relative overflow-hidden">
                <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-black text-ink-primary font-display tracking-tight uppercase">Đơn đăng ký mới</h2>
                        <p class="text-sm text-ink-secondary mt-1 font-medium italic">Hồ sơ chờ phê duyệt từ sinh viên.</p>
                    </div>
                    <a href="{{ route('admin.duyetdangky') }}" class="pdu-btn-ghost group/btn">
                        Toàn bộ hồ sơ
                        <svg class="ml-2 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                @if ($listDangKy->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center bg-ui-bg/40 rounded-2xl border border-ui-border border-dashed">
                        <div class="h-16 w-16 rounded-2xl bg-ui-card flex items-center justify-center mb-5 text-ink-secondary/20 ring-1 ring-ui-border">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="text-lg font-black text-ink-primary tracking-tight">Hệ thống đang trống</div>
                        <div class="text-sm text-ink-secondary mt-2 max-w-xs mx-auto font-medium">Chưa ghi nhận yêu cầu đăng ký mới nào.</div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($listDangKy as $dangky)
                            <div class="group flex items-center gap-4 rounded-2xl border border-ui-border bg-ui-bg/30 p-4 transition-all hover:bg-ui-card hover:border-brand-emerald/30">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-ui-card border border-ui-border font-black text-ink-primary text-lg font-display transition-colors group-hover:bg-brand-emerald group-hover:text-white group-hover:border-brand-emerald">
                                    {{ $dangky['initial'] }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="truncate text-lg font-black text-ink-primary font-display tracking-tight leading-none mb-1.5 group-hover:text-brand-emerald transition-colors">{{ $dangky['name'] }}</div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/70">{{ $dangky['phongName'] }}</span>
                                        <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                        <span class="text-[10px] font-bold text-ink-secondary/30 tabular-nums uppercase">{{ $dangky['time'] }}</span>
                                    </div>
                                </div>
                                <span class="shrink-0 rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest {{ $dangky['statusClass'] }}">{{ $dangky['statusLabel'] }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>

            <!-- Technical Issues -->
            <article class="pdu-card">
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-ink-primary font-display tracking-tight uppercase">Sự cố kỹ thuật</h2>
                        <p class="text-sm text-ink-secondary mt-1 font-medium italic">Yêu cầu bảo trì và sửa chữa hạ tầng.</p>
                    </div>
                    <a href="{{ route('admin.quanlybaohong') }}" class="pdu-btn-ghost">
                        Xử lý sự cố
                    </a>
                </div>

                @if ($listBaoHong->isEmpty())
                    <div class="flex items-center justify-center gap-4 py-12 text-sm text-status-success bg-status-success/5 rounded-2xl font-black uppercase tracking-widest border border-status-success/20 border-dashed">
                        <div class="h-10 w-10 rounded-full bg-status-success flex items-center justify-center text-white shadow-lg shadow-status-success/20">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Infrastructure Optimized
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($listBaoHong as $baohong)
                            <div class="flex items-center justify-between rounded-2xl border border-ui-border bg-ui-bg/30 p-5 transition-all hover:bg-ui-card hover:border-status-warning/30 group">
                                <div class="flex items-center gap-5">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-ui-card text-ink-secondary border border-ui-border transition-colors group-hover:bg-status-warning group-hover:text-white group-hover:border-status-warning">
                                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-lg font-black text-ink-primary font-display tracking-tight leading-none mb-2 group-hover:text-status-warning transition-colors">{{ $baohong['mota'] }}</div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/70">Phòng {{ $baohong['phongName'] }}</span>
                                            <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                            <span class="text-[10px] font-bold text-ink-secondary/30 uppercase tracking-widest tabular-nums">{{ $baohong['time'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="rounded-lg bg-ui-card border border-ui-border px-4 py-2 text-[10px] font-black uppercase tracking-widest text-ink-primary group-hover:border-status-warning/20">
                                    {{ $baohong['statusLabel'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>
        </div>

        <div class="xl:col-span-4 space-y-8">
            <!-- Tower Performance -->
            <article class="pdu-card">
                <h2 class="text-xl font-black text-ink-primary font-display mb-8 tracking-tight uppercase border-b border-ui-border pb-5 italic">Hiệu suất tòa</h2>
                <div class="space-y-8">
                    @foreach ($listCongSuat as $toa)
                        <div class="group">
                            <div class="mb-4 flex items-center justify-between text-[11px] font-black uppercase tracking-widest">
                                <span class="text-ink-secondary group-hover:text-ink-primary transition-colors">{{ $toa['name'] }}</span>
                                <span class="text-ink-primary tabular-nums">{{ $toa['percentage'] }}%</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-ui-bg overflow-hidden ring-1 ring-ui-border/50 p-0.5">
                                <div class="h-full rounded-full bg-ink-primary transition-all duration-700 ease-out group-hover:bg-brand-emerald" @style(["width: {$toa['percentage']}%"])></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <!-- Financial Insights -->
            <article class="pdu-card relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-ink-primary/5 blur-2xl"></div>

                <h2 class="text-xl font-black text-ink-primary font-display mb-2 tracking-tight uppercase italic relative z-10">Tài chính</h2>
                <p class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/30 mb-8 border-b border-ui-border pb-5 relative z-10">Dòng tiền 6 tháng</p>

                <div class="space-y-6 relative z-10">
                    @foreach ($xuHuongDoanhThu as $item)
                        <div class="group/row cursor-default">
                            <div class="mb-3 flex items-center justify-between text-[10px] font-bold uppercase tracking-widest">
                                <span class="text-ink-secondary/50 group-hover/row:text-ink-primary transition-colors">{{ $item['label'] }}</span>
                                <span class="text-ink-primary tabular-nums font-black">{{ number_format($item['value']) }}đ</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-ui-bg overflow-hidden ring-1 ring-ui-border/50">
                                <div class="h-full rounded-full bg-ink-secondary/20 transition-all duration-700 group-hover/row:bg-brand-emerald group-hover/row:w-full" @style(["width: {$item['percentage']}%"])></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('admin.baocaocongno') }}" class="mt-10 pdu-btn-primary w-full group/btn">
                    Chi tiết sổ cái
                    <svg class="ml-2 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </article>

            <!-- Quick Config -->
            <a href="{{ route('admin.quanlycauhinh') }}" class="pdu-card group flex items-center justify-between hover:border-ink-primary/30">
                <div class="flex items-center gap-5">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary border border-ui-border transition-all duration-300 group-hover:bg-ink-primary group-hover:text-white group-hover:border-ink-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <div>
                        <div class="text-base font-black text-ink-primary font-display tracking-tight uppercase leading-none mb-1 group-hover:text-ink-primary transition-colors">Tham số hệ thống</div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/30">Global Configuration</div>
                    </div>
                </div>
                <div class="h-8 w-8 rounded-full bg-ui-bg flex items-center justify-center text-ink-secondary/20 transition-all group-hover:text-ink-primary group-hover:bg-ink-primary/10">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
        </div>
    </div>
</x-admin-layout>
