<x-landing-layout>
    <x-slot:title>Vật tư & tài sản · Phòng {{ $phong->tenphong }}</x-slot:title>

    <section class="pt-36 pb-20 lg:pt-44 lg:pb-28 bg-[#fafafa] relative overflow-hidden min-h-screen">
        <div class="absolute inset-0 opacity-100 bg-[radial-gradient(#d1d5db_1.5px,transparent_1.5px)] [background-size:32px_32px] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>

        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            @php
                $back = request()->query('back', 'public');
                $backUrl = $back === 'student'
                    ? route('student.phong.index')
                    : route('public.danhsachphong');

                $gioiTinhLabel = $phong->gioitinh === 'Nu' ? 'Nữ' : ($phong->gioitinh === 'Nam' ? 'Nam' : $phong->gioitinh);
                $isAvailable = (int) $sochocontrong > 0;
            @endphp

            <div class="mb-12 border-b border-ui-border pb-8">
                <a href="{{ $backUrl }}" class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-widest text-ink-secondary hover:text-ink-primary transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Danh sách phòng
                </a>

                <div class="mt-8 flex flex-wrap items-start justify-between gap-8">
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-widest text-ink-secondary mb-3">Vật tư & tài sản</p>
                        <h1 class="font-display text-4xl sm:text-5xl font-bold tracking-tight text-ink-primary">Phòng {{ $phong->tenphong }}</h1>
                        @if($phong->mota)
                            <p class="mt-4 text-ink-secondary max-w-2xl text-lg leading-relaxed">{{ $phong->mota }}</p>
                        @else
                            <p class="mt-4 text-ink-secondary max-w-2xl text-lg leading-relaxed">Danh sách vật tư và tài sản hiện có trong phòng.</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border {{ $isAvailable ? 'border-brand-emerald text-brand-emerald bg-brand-emerald/5' : 'border-red-500 text-red-600 bg-red-500/5' }}">
                            {{ $isAvailable ? 'Còn ' . $sochocontrong . ' chỗ' : 'Đã đầy' }}
                        </span>
                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border border-ui-border bg-ui-bg text-ink-primary">
                            {{ $gioiTinhLabel }}
                        </span>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 border border-ui-border shadow-sm">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/70">Tầng</div>
                        <div class="mt-2 text-xl font-display font-bold tracking-tight text-ink-primary tabular-nums">{{ $phong->tang }}</div>
                    </div>
                    <div class="bg-white p-5 border border-ui-border shadow-sm">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/70">Giá phòng</div>
                        <div class="mt-2 flex items-baseline gap-1">
                            <span class="text-xl font-display font-bold tracking-tight text-ink-primary tabular-nums">{{ number_format($phong->giaphong, 0, ',', '.') }}</span>
                            <span class="text-xs font-bold text-ink-secondary">đ/tháng</span>
                        </div>
                    </div>
                    <div class="bg-white p-5 border border-ui-border shadow-sm">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/70">Đang ở</div>
                        <div class="mt-2 text-xl font-display font-bold tracking-tight text-ink-primary tabular-nums">{{ $soluongdango }}</div>
                    </div>
                    <div class="bg-white p-5 border border-ui-border shadow-sm">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/70">Chỗ trống</div>
                        <div class="mt-2 text-xl font-display font-bold tracking-tight {{ $isAvailable ? 'text-ink-primary' : 'text-red-600' }} tabular-nums">{{ $sochocontrong }}</div>
                    </div>
                </div>
            </div>

            @php
                $tongMuc = $vattu->count() + $taisan->count();
            @endphp

            <div>
                <div class="flex items-baseline justify-between gap-6 mb-6">
                    <h2 class="font-display text-2xl font-bold tracking-tight text-ink-primary">Vật tư & tài sản</h2>
                    <div class="text-[11px] font-bold uppercase tracking-widest text-ink-secondary">{{ $tongMuc }} mục</div>
                </div>

                @if($tongMuc > 0)
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($vattu as $item)
                            <article class="bg-white p-5 border border-ui-border shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-bold text-ink-primary truncate" title="{{ $item->tenvattu }}">{{ $item->tenvattu }}</h3>
                                            <span class="shrink-0 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border border-ui-border bg-ui-bg text-ink-secondary">Vật tư</span>
                                        </div>
                                        <div class="mt-3 flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center gap-2 px-2.5 py-1 bg-ui-bg text-ink-primary text-[11px] font-bold border border-ui-border tabular-nums">
                                                SL: {{ $item->soluong }}
                                            </span>
                                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border
                                                @if($item->tinhtrang === 'Hoat dong tot') border-brand-emerald text-brand-emerald bg-brand-emerald/5
                                                @elseif($item->tinhtrang === 'Can sua') border-amber-500/50 text-amber-700 bg-amber-50
                                                @else border-red-500/60 text-red-600 bg-red-500/5 @endif">
                                                {{ $item->tinhtrang }}
                                            </span>
                                        </div>
                                        @if($item->mota)
                                            <p class="mt-4 text-sm text-ink-secondary leading-relaxed">{{ $item->mota }}</p>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach

                        @foreach($taisan as $item)
                            <article class="bg-white p-5 border border-ui-border shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-bold text-ink-primary truncate" title="{{ $item->tentaisan }}">{{ $item->tentaisan }}</h3>
                                            <span class="shrink-0 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border border-ui-border bg-ui-bg text-ink-secondary">Tài sản</span>
                                        </div>
                                        <div class="mt-3 flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center gap-2 px-2.5 py-1 bg-ui-bg text-ink-primary text-[11px] font-bold border border-ui-border tabular-nums">
                                                SL: {{ $item->soluong }}
                                            </span>
                                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border
                                                @if($item->tinhtrang === 'Dang su dung') border-brand-emerald text-brand-emerald bg-brand-emerald/5
                                                @elseif($item->tinhtrang === 'Can sua') border-amber-500/50 text-amber-700 bg-amber-50
                                                @else border-ui-border text-ink-secondary bg-ui-bg @endif">
                                                {{ $item->tinhtrang }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 bg-white border border-ui-border shadow-sm text-center">
                        <div class="text-3xl mb-4 opacity-60">�</div>
                        <h3 class="text-lg font-display font-bold text-ink-primary mb-2">Chưa có vật tư hoặc tài sản</h3>
                        <p class="text-sm text-ink-secondary">Hiện chưa có mục nào được ghi nhận cho phòng này.</p>
                    </div>
                @endif
            </div>

            <div class="mt-16 flex justify-center">
                <a href="{{ $backUrl }}" class="bg-ui-bg text-ink-primary hover:bg-ui-border py-3 px-6 text-[11px] font-bold tracking-wide transition-colors inline-flex items-center justify-center gap-2 uppercase border border-ui-border">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Quay lại danh sách phòng
                </a>
            </div>
        </div>
    </section>
</x-landing-layout>
