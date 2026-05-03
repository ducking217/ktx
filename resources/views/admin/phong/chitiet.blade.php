<x-admin-layout>
    <x-slot:title>Hồ sơ phòng {{ $phong->tenphong }}</x-slot:title>

    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.phong.index') }}" class="flex h-8 w-8 items-center justify-center rounded-lg bg-ui-bg text-ink-secondary hover:text-ink-primary ring-1 ring-ui-border transition-colors shadow-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-ink-secondary/60">Hệ thống phòng nội trú</span>
            </div>
            <h1 class="text-5xl font-black text-ink-primary font-display tracking-tight uppercase">Phòng {{ $phong->tenphong }}</h1>
            <p class="mt-2 text-lg text-ink-secondary font-medium italic">Thông tin định danh, danh sách nhân khẩu và lịch sử vận hành chi tiết.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="flex items-center gap-2 rounded-2xl bg-ui-bg p-1.5 ring-1 ring-inset ring-ui-border">
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-white px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-ink-primary shadow-sm ring-1 ring-ui-border">
                    <span class="h-1.5 w-1.5 rounded-full {{ $phong->gioitinh === 'Nam' ? 'bg-blue-500' : 'bg-rose-500' }}"></span>
                    Dành cho {{ $phong->gioitinh }}
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-white px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-ink-primary shadow-sm ring-1 ring-ui-border">
                    Tầng {{ $phong->tang }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Stats & Info -->
        <div class="space-y-8 lg:col-span-1">
            <article class="rounded-3xl bg-white border border-ui-border p-8 shadow-sm">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-6">Sơ đồ vị trí giường</h3>
                
                <div class="grid grid-cols-4 gap-3">
                    @foreach($beds as $index => $bed)
                        <div class="relative group/bed">
                            <div @class([
                                'flex aspect-square flex-col items-center justify-center rounded-xl border-2 transition-all cursor-help',
                                'border-emerald-50 bg-emerald-50/10 text-emerald-500 hover:border-emerald-200' => $bed['status'] === 'AVAILABLE',
                                'border-amber-50 bg-amber-50/10 text-amber-500 hover:border-amber-200' => $bed['status'] === 'PENDING',
                                'border-ui-bg bg-ui-bg/50 text-ink-primary hover:border-ink-primary/20' => $bed['status'] === 'OCCUPIED',
                            ])>
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M7 13V11H21V13H7M7 19V17H21V19H7M2 4V22H4V19H20V22H22V4H20V7H4V4H2Z"/></svg>
                                <span class="mt-0.5 text-[8px] font-black tabular-nums">{{ $index }}</span>
                            </div>

                            <div class="invisible absolute bottom-full left-1/2 mb-3 w-40 -translate-x-1/2 scale-95 opacity-0 transition-all group-hover/bed:visible group-hover/bed:scale-100 group-hover/bed:opacity-100 z-50">
                                <div class="rounded-xl bg-ink-primary p-3 shadow-xl ring-1 ring-white/10 text-center">
                                    <div class="text-[8px] font-black uppercase tracking-widest text-white/50 mb-1">Giường {{ $index }}</div>
                                    @if($bed['status'] === 'OCCUPIED')
                                        <div class="text-[10px] font-bold text-white truncate">{{ $bed['occupant']['name'] }}</div>
                                    @elseif($bed['status'] === 'PENDING')
                                        <div class="text-[10px] font-bold text-amber-400 truncate">{{ $bed['occupant']['name'] }}</div>
                                        <div class="text-[8px] text-white/40 italic">Chờ phê duyệt</div>
                                    @else
                                        <div class="text-[10px] font-bold text-emerald-400 uppercase">Trống</div>
                                    @endif
                                </div>
                                <div class="absolute -bottom-1 left-1/2 h-2 w-2 -translate-x-1/2 rotate-45 bg-ink-primary"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="rounded-3xl bg-white border border-ui-border p-8 shadow-sm">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-6">Trạng thái lấp đầy</h3>
                @php
                    $soluongdango = count($sinhviens);
                    $daydu = $soluongdango >= (int) $phong->succhuamax;
                    $phantram = $phong->succhuamax > 0 ? min(100, round($soluongdango / $phong->succhuamax * 100)) : 0;
                @endphp
                
                <div class="flex items-end justify-between mb-4">
                    <span class="text-5xl font-black text-ink-primary tabular-nums font-display">{{ $soluongdango }}<span class="text-xl text-ink-secondary/40">/{{ $phong->succhuamax }}</span></span>
                    <span class="text-sm font-bold text-ink-secondary uppercase">Giường đã ở</span>
                </div>

                <div class="h-3 w-full overflow-hidden rounded-full bg-ui-bg ring-1 ring-inset ring-ui-border">
                    <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $daydu ? 'bg-ink-primary' : 'bg-brand-emerald shadow-[0_0_8px_rgba(16,185,129,0.3)]' }}" @style(["width: $phantram%"])></div>
                </div>

                <div class="mt-8 space-y-4 pt-8 border-t border-ui-border">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-ink-secondary uppercase">Đơn giá tháng</span>
                        <span class="text-lg font-black text-ink-primary tabular-nums font-display">{{ number_format($phong->giaphong) }}đ</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-ink-secondary uppercase">Loại phòng</span>
                        <span class="text-sm font-bold text-ink-primary">{{ $phong->succhuamax }} người</span>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl bg-ui-bg/50 border border-ui-border p-8 ring-1 ring-inset ring-ui-border">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary mb-4">Ghi chú vận hành</h3>
                <p class="text-sm font-medium text-ink-secondary leading-relaxed italic">
                    {{ $phong->ghichu ?? 'Không có ghi chú đặc biệt cho phòng này.' }}
                </p>
            </article>
        </div>

        <!-- Main Content: Resident List -->
        <div class="lg:col-span-2 space-y-8">
            <article class="rounded-3xl bg-white border border-ui-border shadow-sm overflow-hidden">
                <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4 flex items-center justify-between">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Danh sách nhân khẩu hiện tại</h3>
                    <span class="text-[10px] font-bold text-ink-secondary/40 uppercase tabular-nums">{{ count($sinhviens) }} cư dân</span>
                </div>

                <div class="divide-y divide-ui-border">
                    @forelse ($sinhviens as $sinhvien)
                        <div class="group flex items-center justify-between p-6 transition-colors hover:bg-ui-bg/30">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-2xl bg-ui-bg ring-1 ring-ui-border">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($sinhvien->taikhoan)->name) }}&background=f8f9fa&color=0f172a&bold=true" alt="Avatar" />
                                </div>
                                <div>
                                    <div class="font-bold text-ink-primary font-display text-lg">{{ optional($sinhvien->taikhoan)->name ?? 'N/A' }}</div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">{{ $sinhvien->masinhvien }}</span>
                                        <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">{{ $sinhvien->lop }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="text-right hidden sm:block">
                                    <div class="text-xs font-bold text-ink-primary tabular-nums">{{ $sinhvien->sodienthoai }}</div>
                                    <div class="text-[10px] font-medium text-ink-secondary/40 uppercase tracking-widest mt-0.5">Liên lạc</div>
                                </div>
                                <a href="{{ route('admin.quanlysinhvien', ['q' => $sinhvien->masinhvien]) }}" class="flex h-9 w-9 items-center justify-center rounded-xl bg-ui-bg text-ink-secondary hover:text-ink-primary ring-1 ring-ui-border transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="px-8 py-24 text-center">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-4">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <h4 class="text-sm font-bold text-ink-primary uppercase tracking-widest">Phòng đang trống</h4>
                            <p class="mt-1 text-[11px] text-ink-secondary">Hiện tại chưa có sinh viên nào được xếp vào phòng này.</p>
                        </div>
                    @endforelse
                </div>
            </article>

            <!-- Maintenance History -->
            <article class="rounded-3xl bg-white border border-ui-border shadow-sm overflow-hidden">
                <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Nhật ký bảo trì & Sửa chữa</h3>
                </div>
                
                <div class="p-8">
                    @php
                        $baotris = \App\Models\Baotri::where('phong_id', $phong->id)->orderBy('ngaybaotri', 'desc')->get();
                    @endphp
                    
                    @if($baotris->isNotEmpty())
                        <div class="space-y-6">
                            @foreach($baotris as $bt)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="h-2.5 w-2.5 rounded-full ring-4 ring-ui-bg {{ $bt->trangthai === 'Đã hoàn thành' ? 'bg-brand-emerald' : 'bg-amber-500' }}"></div>
                                        <div class="w-px flex-1 bg-ui-border my-2"></div>
                                    </div>
                                    <div class="flex-1 pb-6">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-[10px] font-bold text-ink-secondary uppercase tabular-nums tracking-widest">{{ date('d/m/Y', strtotime($bt->ngaybaotri)) }}</span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest {{ $bt->trangthai === 'Đã hoàn thành' ? 'text-brand-emerald' : 'text-amber-600' }}">{{ $bt->trangthai }}</span>
                                        </div>
                                        <p class="text-sm font-bold text-ink-primary mb-1">{{ $bt->noidung }}</p>
                                        <p class="text-xs font-medium text-ink-secondary/60">Thực hiện: {{ $bt->nguoithuchien }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-xs font-bold text-ink-secondary/40 uppercase tracking-widest">Chưa có dữ liệu bảo trì</p>
                        </div>
                    @endif
                </div>
            </article>

            <!-- Room Assets -->
            <article class="rounded-3xl bg-white border border-ui-border shadow-sm overflow-hidden">
                <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Danh mục tài sản trong phòng</h3>
                </div>
                <div class="p-8">
                    @if($taisan->isNotEmpty())
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($taisan as $ts)
                                <div class="p-4 rounded-2xl bg-ui-bg/30 ring-1 ring-inset ring-ui-border">
                                    <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest mb-1">{{ $ts->ma_tai_san }}</div>
                                    <div class="text-xs font-bold text-ink-primary">{{ $ts->ten_tai_san }}</div>
                                    <div class="mt-2 text-[10px] font-black uppercase tracking-widest {{ $ts->tinh_trang === 'Tốt' ? 'text-brand-emerald' : 'text-status-error' }}">
                                        {{ $ts->tinh_trang }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-xs font-bold text-ink-secondary/40 uppercase tracking-widest">Chưa gán tài sản</p>
                        </div>
                    @endif
                </div>
            </article>

            <!-- Resident Reviews -->
            <article class="rounded-3xl bg-white border border-ui-border shadow-sm overflow-hidden">
                <div class="bg-ui-bg/50 border-b border-ui-border px-8 py-4 flex items-center justify-between">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Đánh giá từ cư dân</h3>
                    @php
                        $avgRating = round(\App\Models\Danhgia::where('phong_id', $phong->id)->avg('diem') ?? 0, 1);
                    @endphp
                    @if($avgRating > 0)
                        <div class="flex items-center gap-1.5">
                            <svg class="h-3 w-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-black text-ink-primary tabular-nums">{{ $avgRating }}</span>
                        </div>
                    @endif
                </div>
                <div class="p-8">
                    @php
                        $reviews = \App\Models\Danhgia::where('phong_id', $phong->id)->with('sinhvien.taikhoan')->orderByDesc('ngaydanhgia')->take(5)->get();
                    @endphp
                    @forelse($reviews as $rv)
                        <div class="flex gap-4 {{ !$loop->last ? 'border-b border-ui-border pb-6 mb-6' : '' }}">
                            <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-xl bg-ui-bg">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($rv->sinhvien->taikhoan?->name) }}&background=f8f9fa&color=0f172a&bold=true" alt="Reviewer" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="font-bold text-ink-primary text-xs truncate">{{ $rv->sinhvien->taikhoan?->name }}</div>
                                    <div class="flex items-center gap-0.5">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="h-2.5 w-2.5 {{ $i <= $rv->diem ? 'text-amber-400' : 'text-ink-secondary/20' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-xs text-ink-secondary leading-relaxed line-clamp-2 italic">"{{ $rv->noidung ?? 'Không có nhận xét.' }}"</p>
                                <div class="mt-2 text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest tabular-nums">{{ date('d/m/Y', strtotime($rv->ngaydanhgia)) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-xs font-bold text-ink-secondary/40 uppercase tracking-widest">Chưa có đánh giá nào</p>
                        </div>
                    @endforelse
                </div>
            </article>
        </div>
    </div>
</x-admin-layout>
