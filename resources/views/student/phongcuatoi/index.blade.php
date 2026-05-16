@extends('student.layouts.chinh')

@section('student_page_title', 'Phòng của tôi')

@section('noidung')
    <div class="space-y-8">
        <x-admin.page-header
            title="Quản lý phòng ở"
            subtitle="Thông tin chi tiết về phòng lưu trú, thành viên cùng phòng và các tiện ích liên quan."
        />

        {{-- Nhánh 1: Chưa được xếp phòng (hiển thị đăng ký gần nhất + gợi ý phòng phù hợp) --}}
        @if(!$coPhong)
            @php
                $dangkyPhongGanNhat = $dangkyPhongGanNhat ?? null;
                $trangThaiDangKy = $dangkyPhongGanNhat?->trang_thai?->value ?? $dangkyPhongGanNhat?->trang_thai ?? null;
                $isPending = $trangThaiDangKy === \App\Enums\RegistrationStatus::Pending->value;
                $phongDaChon = $dangkyPhongGanNhat?->phong?->ten_phong ?? null;
                $toaDaChon = $dangkyPhongGanNhat?->toanha?->ten_toa_nha ?? $dangkyPhongGanNhat?->phong?->toanha?->ten_toa_nha ?? null;
                $loaiPhongDaChon = $dangkyPhongGanNhat?->loaiphong?->ten_loai ?? $dangkyPhongGanNhat?->phong?->loaiphong?->ten_loai ?? null;
            @endphp

            <div class="grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-8 space-y-6">
                    @if($dangkyPhongGanNhat && $isPending)
                        <div class="saas-card p-8 bg-brand-emerald/5 border-brand-emerald/15">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-emerald/10 text-brand-emerald ring-1 ring-brand-emerald/20">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-slate-900">Đang chờ duyệt đăng ký phòng</div>
                                    <div class="mt-1 text-sm text-slate-600">
                                        Bạn đã chọn <span class="font-semibold">{{ $phongDaChon ?? 'một phòng' }}</span>
                                        @if($toaDaChon) ({{ $toaDaChon }}) @endif
                                        @if($loaiPhongDaChon) • {{ $loaiPhongDaChon }} @endif.
                                    </div>
                                    <div class="mt-4 text-xs text-slate-500">Ban quản lý sẽ xét duyệt và phản hồi trong thời gian sớm nhất.</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="saas-card p-12 text-center flex flex-col items-center justify-center min-h-[360px] border-dashed">
                            <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-50 text-slate-300 border border-slate-100 border-dashed">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2 tracking-tight">Bạn chưa có hồ sơ lưu trú</h3>
                            <p class="text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">Chọn một phòng trống phù hợp và gửi đăng ký để Ban quản lý xét duyệt.</p>
                            <div class="mt-8">
                                <a href="{{ route('student.phong.index') }}" class="saas-btn-primary h-11 px-5 text-sm font-semibold">Xem phòng trống</a>
                            </div>
                        </div>
                    @endif
                </div>

                <aside class="lg:col-span-4 space-y-6">
                    <div class="saas-card p-6 bg-slate-50/50 border-dashed">
                        <div class="text-sm font-semibold text-slate-900">Gợi ý để xét duyệt nhanh</div>
                        <ul class="mt-3 space-y-2 text-sm text-slate-600">
                            <li>Chọn phòng đúng giới tính theo quy định.</li>
                            <li>Kiểm tra còn giường trống trước khi gửi.</li>
                            <li>Giữ liên lạc để nhận thông báo khi có kết quả.</li>
                        </ul>
                    </div>
                </aside>
            </div>
        @else
            {{-- Nhánh 2: Đang có phòng (tổng quan phòng hiện tại + cảnh báo hết hạn + bạn cùng phòng + kiểm kê) --}}
            <div class="grid gap-8 lg:grid-cols-12">
                {{-- MAIN COLUMN --}}
                <div class="lg:col-span-8 space-y-8">
                    
                    {{-- Room Identification --}}
                    <article class="saas-card p-8 flex flex-col md:flex-row md:items-center justify-between gap-8 group hover:border-slate-300 transition-all">
                        <div class="flex items-center gap-6">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 border border-slate-100 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-none tabular-nums">{{ $phong->tenphong }}</h2>
                                    <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-600 border border-slate-200">Tầng {{ $phong->tang }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Tòa {{ $phong->toa }}</span>
                                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Dành cho {{ $phong->gioitinh }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-left md:text-right border-l-0 md:border-l border-slate-100 md:pl-8">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Mức phí niêm yết</div>
                            <div class="text-2xl font-bold text-slate-900 tracking-tight tabular-nums">{{ number_format($phong->giaphong) }}đ<span class="text-xs text-slate-300 ml-1">/Tháng</span></div>
                        </div>
                    </article>

                    {{-- Metrics Grid --}}
                    <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="saas-card p-5 bg-slate-50/50">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Sức chứa</div>
                            <div class="text-xl font-bold text-slate-900 tabular-nums">{{ $banCungPhong->count() + 1 }} / {{ $phong->succhuamax }} <span class="text-[9px] text-slate-400">Sinh viên</span></div>
                        </div>
                        <div class="saas-card p-5 bg-slate-50/50">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Trạng thái</div>
                            <span class="saas-badge saas-badge-success !py-0 !px-2 text-[10px]">Đang lưu trú</span>
                        </div>
                    </section>

                    {{-- Notifications/Warnings --}}
                    @if($canhBaoHetHan)
                        <div class="saas-card overflow-hidden bg-rose-50 border-rose-100 p-6 flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600 border border-rose-100 shadow-sm">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-rose-900 tracking-tight mb-1">Thời hạn lưu trú sắp kết thúc ({{ $canhBaoHetHan['so_ngay_con_lai'] }} ngày còn lại)</h3>
                                <p class="text-[11px] font-medium text-rose-600 leading-relaxed">
                                    Hợp đồng hiện tại sẽ hết hạn vào ngày <span class="font-bold underline">{{ $canhBaoHetHan['ngay_het_han'] }}</span>.
                                    Vui lòng vào mục <span class="font-bold">Hợp đồng & gia hạn</span> để thực hiện các thao tác liên quan.
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Roommates --}}
                    @if($banCungPhong->count() > 0)
                        <article class="saas-card overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/30">
                                <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Thành viên cùng phòng</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-slate-50">
                                @foreach($banCungPhong as $ban)
                                    <div class="flex items-center gap-4 p-5 hover:bg-slate-50/50 transition-colors group">
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-slate-100 font-bold text-slate-500 border border-slate-200 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all">
                                            {{ strtoupper(substr($ban->taikhoan->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm tracking-tight mb-0.5">{{ $ban->taikhoan->name ?? 'Người dùng' }}</div>
                                            <div class="flex items-center gap-2 text-[9px] font-bold uppercase tracking-widest text-slate-400">
                                                <span>{{ $ban->mssv ?? 'Chưa có' }}</span>
                                                <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                                                <span>Sinh viên</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endif
                </div>

                {{-- SIDEBAR --}}
                <aside class="lg:col-span-4 space-y-8">
                    
                    {{-- Sidebar: Kiểm kê nhanh tài sản/vật tư trong phòng (preview một phần, chi tiết xem ở menu tương ứng) --}}
                    <article class="saas-card overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                            <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Kiểm kê vật tư</h3>
                            <span class="saas-badge bg-slate-100 text-slate-500 !py-0 !px-2 text-[10px]">{{ $taisan->count() + $vattu->count() }} mục</span>
                        </div>
                        <div class="p-6">
                            @if($taisan->count() === 0 && $vattu->count() === 0)
                                <div class="py-10 text-center border border-slate-100 border-dashed rounded-2xl bg-slate-50/50">
                                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Chưa ghi nhận tài sản</p>
                                </div>
                            @else
                                <div class="grid grid-cols-2 gap-3 mb-6">
                                    @foreach($taisan->take(4) as $item_ts)
                                        <div class="rounded-xl bg-slate-50 p-3 border border-slate-100">
                                            <div class="text-[10px] font-bold text-slate-900 truncate mb-1" title="{{ $item_ts->tentaisan }}">{{ $item_ts->tentaisan }}</div>
                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">SL: {{ $item_ts->soluong }}</div>
                                        </div>
                                    @endforeach
                                    @foreach($vattu->take(max(0, 4 - $taisan->count())) as $item_vt)
                                        <div class="rounded-xl bg-slate-50 p-3 border border-slate-100">
                                            <div class="text-[10px] font-bold text-slate-900 truncate mb-1" title="{{ $item_vt->tenvattu }}">{{ $item_vt->tenvattu }}</div>
                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">SL: {{ $item_vt->soluong }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="text-xs text-slate-500 font-medium">
                                Xem chi tiết ở các mục tương ứng trong thanh điều hướng.
                            </div>
                        </div>
                    </article>

                </aside>
            </div>
        @endif
    </div>
@endsection
