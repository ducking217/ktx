<x-admin-layout>
    <x-slot:title>Sơ đồ KTX</x-slot:title>

    <div class="space-y-10">
        {{-- CAMPUS KPI --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-ui-card p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50">Tổng quy mô</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink-primary font-display tabular-nums">384</span>
                    <span class="text-[10px] font-bold text-ink-secondary/40 uppercase">Giường</span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-[9px] font-bold text-ink-secondary/40 uppercase tracking-wider">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                    48 Phòng • 2 Tòa • 3 Tầng
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-ui-card p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-emerald-600/70">Sẵn sàng</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-emerald-600 font-display tabular-nums">{{ number_format($campusStats['available']) }}</span>
                    <span class="text-[10px] font-bold text-emerald-600/40 uppercase italic">Trống</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]" @style(['width' => ($campusStats['available'] / 384 * 100) . '%'])></div>
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-ui-card p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-ink-primary">Đã lưu trú</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-ink-primary font-display tabular-nums">{{ number_format($campusStats['occupied']) }}</span>
                    <span class="text-[10px] font-bold text-ink-primary/40 uppercase italic">Người</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-ink-primary" @style(['width' => ($campusStats['occupied'] / 384 * 100) . '%'])></div>
                </div>
            </article>

            <article class="relative overflow-hidden rounded-2xl border border-ui-border bg-ui-card p-6 shadow-sm transition-all hover:shadow-md">
                <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-ink-secondary/50 text-amber-600/70">Đang chờ</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-amber-600 font-display tabular-nums">{{ number_format($campusStats['pending']) }}</span>
                    <span class="text-[10px] font-bold text-amber-600/40 uppercase italic">Hồ sơ</span>
                </div>
                <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-ui-bg">
                    <div class="h-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.3)]" @style(['width' => ($campusStats['pending'] / 384 * 100) . '%'])></div>
                </div>
            </article>
        </div>

        {{-- FILTERS --}}
        <div>
            <x-admin.page-header
                title="Sơ đồ thực địa"
                subtitle="Giám sát vị trí Tòa {{ $toa }} — Tầng {{ $tang }}"
            >
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                        @foreach($allToa as $t)
                            <a href="{{ request()->fullUrlWithQuery(['toa_nha_id' => $t->id, 'tang' => request('tang')]) }}"
                               class="rounded-lg px-5 py-2 text-[10px] font-bold uppercase tracking-widest transition-all {{ $toaNhaId == $t->id ? 'bg-ui-card text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary' }}">
                                Tòa {{ $t->ten_toa_nha }}
                            </a>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                        @foreach($allTang as $tg)
                            <a href="{{ request()->fullUrlWithQuery(['tang' => $tg]) }}"
                               class="rounded-lg px-5 py-2 text-[10px] font-bold uppercase tracking-widest transition-all {{ $tang === $tg ? 'bg-ui-card text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary' }}">
                                Tầng {{ $tg }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </x-admin.page-header>
        </div>

        {{-- ROOM GRID --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($mapData as $data)
                @php 
                    $phong = $data['phong']; 
                    $soluongdango = $phong->so_nguoi_dang_o ?? 0;
                    $succhuamax = $phong->loaiphong->suc_chua ?? 0;
                @endphp
                <article class="group relative rounded-2xl border border-ui-border bg-ui-card p-5 shadow-sm transition-all hover:border-ink-primary/20 hover:shadow-md">
                    <header class="mb-5 flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('admin.phong.chitiet', $phong->id) }}" class="group/title block">
                                <h3 class="text-lg font-bold text-ink-primary font-display uppercase tracking-tight group-hover/title:text-ink-primary/70 transition-colors">{{ $phong->ten_phong }}</h3>
                            </a>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="text-[9px] font-bold uppercase tracking-widest text-ink-secondary/40"><span class="tabular-nums">{{ $soluongdango }}/{{ $succhuamax }}</span> Đang ở</span>
                            </div>
                        </div>
                        <span class="mt-0.5 inline-flex flex-shrink-0 items-center rounded-full px-2 py-0.5 text-[8px] font-bold uppercase tracking-widest ring-1 ring-inset {{ $phong->gioi_tinh_han_che->value === 'female' ? 'bg-rose-50 text-rose-600 ring-rose-500/20' : ($phong->gioi_tinh_han_che->value === 'male' ? 'bg-slate-50 text-slate-700 ring-slate-500/20' : 'bg-gray-50 text-gray-600 ring-gray-500/20') }}">
                            {{ $phong->gioi_tinh_han_che->label() }}
                        </span>
                    </header>

                    @php
                        $bedList = collect($data['beds'] ?? []);
                        $availableCount = $bedList->where('status', 'AVAILABLE')->count();
                        $pendingCount = $bedList->where('status', 'PENDING')->count();
                        $occupiedCount = $bedList->where('status', 'OCCUPIED')->count();
                        $totalCount = max(1, $availableCount + $pendingCount + $occupiedCount);
                    @endphp

                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-bold uppercase tracking-widest text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                Trống {{ $availableCount }}
                            </span>
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-1 text-[9px] font-bold uppercase tracking-widest text-amber-700 ring-1 ring-inset ring-amber-600/10">
                                Chờ {{ $pendingCount }}
                            </span>
                            <span class="inline-flex items-center rounded-full bg-ui-bg px-2 py-1 text-[9px] font-bold uppercase tracking-widest text-ink-primary/70 ring-1 ring-inset ring-ui-border">
                                Đã ở {{ $occupiedCount }}
                            </span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-ui-bg ring-1 ring-ui-border">
                            <div class="flex h-full w-full">
                                <div class="h-full bg-emerald-500/70" @style(['width' => (($availableCount / $totalCount) * 100) . '%'])></div>
                                <div class="h-full bg-amber-500/70" @style(['width' => (($pendingCount / $totalCount) * 100) . '%'])></div>
                                <div class="h-full bg-ink-primary/70" @style(['width' => (($occupiedCount / $totalCount) * 100) . '%'])></div>
                            </div>
                        </div>
                    </div>

                    <footer class="mt-5 border-t border-ui-border pt-4">
                        <a href="{{ route('admin.phong.chitiet', $phong->id) }}" class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60 transition-colors hover:text-ink-primary">
                            Hồ sơ vận hành
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </footer>
                </article>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-ui-bg text-ink-secondary/20">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1"/></svg>
                    </div>
                    <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-ink-secondary/40">Không tìm thấy dữ liệu phòng</p>
                </div>
            @endforelse
        </div>

        {{-- LEGEND --}}
        <div class="flex items-center justify-center gap-8 border-t border-ui-border pt-10 text-[9px] font-bold uppercase tracking-[0.2em] text-ink-secondary/40">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]"></span> Trống
            </div>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.3)]"></span> Đang chờ
            </div>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-ink-primary shadow-[0_0_8px_rgba(15,23,42,0.1)]"></span> Đã ở
            </div>
        </div>
    </div>
</x-admin-layout>
