@extends('student.layouts.chinh')

@section('student_page_title', 'Phòng của tôi')

@section('noidung')
    <div class="space-y-8">
        <x-admin.page-header
            title="Quản lý phòng ở"
            subtitle="Thông tin chi tiết về phòng lưu trú, thành viên cùng phòng và các tiện ích liên quan."
        />

        @if(!$coPhong)
            {{-- Chưa có phòng --}}
            <div class="saas-card p-12 text-center flex flex-col items-center justify-center min-h-[400px]">
                <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-50 text-slate-300 border border-slate-100 border-dashed">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 tracking-tight">Bạn chưa có hồ sơ lưu trú</h3>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-10 max-w-sm mx-auto leading-relaxed">Hãy đăng ký phòng để bắt đầu sử dụng các dịch vụ tại Ký túc xá PDU.</p>
                
                @if($danhsachphongtrong->count() > 0)
                    <div class="w-full text-left mt-12 border-t border-slate-100 pt-10">
                        <div class="flex items-center gap-2 mb-8">
                            <div class="h-1.5 w-1.5 rounded-full bg-blue-600"></div>
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Đề xuất phòng trống</h4>
                        </div>
                        
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($danhsachphongtrong as $phong_item)
                                <article class="saas-card p-6 flex flex-col group hover:border-slate-300 transition-all">
                                    <div class="flex items-start justify-between mb-6">
                                        <div>
                                            <h3 class="text-2xl font-bold text-slate-900 leading-none mb-2 tracking-tight group-hover:text-blue-600 transition-colors">{{ $phong_item->tenphong }}</h3>
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tòa {{ $phong_item->toa }} • Tầng {{ $phong_item->tang }}</div>
                                        </div>
                                        <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100 group-hover:bg-slate-900 group-hover:text-white transition-all">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3 mb-8 border-y border-slate-50 py-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Phí tháng</span>
                                            <span class="text-sm font-bold text-slate-900 tabular-nums">{{ number_format($phong_item->giaphong) }}đ</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Khả dụng</span>
                                            <span class="saas-badge saas-badge-success !py-0 !px-2 text-[10px]">{{ $phong_item->succhuamax - $phong_item->dango }} / {{ $phong_item->succhuamax }}</span>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('student.dangkyphong') }}" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="phong_id" value="{{ $phong_item->id }}">
                                        <button type="submit" class="saas-btn-primary w-full h-10 text-[10px] uppercase font-bold tracking-widest">Gửi yêu cầu đăng ký</button>
                                    </form>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="mt-10">
                    <a href="{{ route('student.danhsachphong') }}" class="saas-btn-secondary h-10 px-6 text-[10px] font-bold uppercase tracking-widest">
                        Khám phá tất cả phòng
                        <svg class="h-3.5 w-3.5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        @else
            {{-- Có phòng --}}
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
                            <div class="text-xl font-bold text-slate-900 tabular-nums">{{ $banCungPhong->count() + 1 }} / {{ $phong->succhuamax }} <span class="text-[9px] text-slate-400">SV</span></div>
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
                                <p class="text-[11px] font-medium text-rose-600 mb-5 leading-relaxed">Hợp đồng hiện tại sẽ hết hạn vào ngày <span class="font-bold underline">{{ $canhBaoHetHan['ngay_het_han'] }}</span>. Hãy thực hiện gia hạn hoặc đăng ký trả phòng.</p>
                                <div class="flex items-center gap-3">
                                    <button type="button" data-modal-target="modal-giahan" data-modal-toggle="modal-giahan" class="saas-btn-primary !bg-rose-600 hover:!bg-rose-700 !border-rose-700 h-9 px-4 text-[10px] uppercase font-bold tracking-widest">Gia hạn ngay</button>
                                    @if(!($daGuiYeuCauTraPhong ?? false))
                                        <button type="button" data-modal-target="modal-traphong" data-modal-toggle="modal-traphong" class="saas-btn-secondary h-9 px-4 text-[10px] uppercase font-bold tracking-widest">Yêu cầu trả phòng</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Contract Details --}}
                    @if($hopdongHienTai)
                        <article class="saas-card">
                            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                                <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Pháp lý & Hợp đồng</h3>
                                @if(!($daGuiYeuCauTraPhong ?? false))
                                    <button type="button" data-modal-target="modal-traphong" data-modal-toggle="modal-traphong" class="text-[10px] font-bold uppercase tracking-widest text-rose-500 hover:text-rose-600">Thanh lý hợp đồng</button>
                                @else
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 italic">Đang chờ thanh lý...</span>
                                @endif
                            </div>
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-8">
                                <div>
                                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1">Ngày hiệu lực</div>
                                    <div class="text-sm font-bold text-slate-900 tabular-nums">{{ date('d/m/Y', strtotime($hopdongHienTai->ngay_bat_dau)) }}</div>
                                </div>
                                <div>
                                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1">Ngày kết thúc</div>
                                    <div class="text-sm font-bold text-slate-900 tabular-nums">{{ date('d/m/Y', strtotime($hopdongHienTai->ngay_ket_thuc)) }}</div>
                                </div>
                                <div>
                                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1">Đơn giá áp dụng</div>
                                    <div class="text-sm font-bold text-slate-900 tabular-nums">{{ number_format($hopdongHienTai->gia_thuc_te) }}đ</div>
                                </div>
                            </div>
                        </article>
                    @endif

                    {{-- Roommates --}}
                    @if($banCungPhong->count() > 0)
                        <article class="saas-card overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/30">
                                <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Thành viên phòng</h3>
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
                                                <span>{{ $ban->mssv ?? 'N/A' }}</span>
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
                    
                    {{-- Financial Status --}}
                    @if($hoadonChuaThanhToan->count() > 0)
                        <article class="saas-card border-rose-200 overflow-hidden group">
                            <div class="px-6 py-4 border-b border-rose-100 bg-rose-50/50 flex items-center justify-between">
                                <h3 class="text-[10px] font-bold uppercase tracking-widest text-rose-600">Khoản nợ tồn đọng</h3>
                                <svg class="h-4 w-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="p-6">
                                <div class="mb-8">
                                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1">Tổng cộng (Phòng)</div>
                                    <div class="text-3xl font-black text-rose-600 tabular-nums tracking-tighter">{{ number_format($tongNo) }}<span class="text-sm font-bold ml-1">đ</span></div>
                                </div>

                                <div class="space-y-3">
                                    @foreach($hoadonChuaThanhToan as $hoadon_item)
                                        <div class="flex items-center justify-between rounded-xl bg-slate-50 p-4 border border-slate-100 hover:bg-white transition-colors">
                                            <div>
                                                <div class="text-xs font-bold text-slate-900 mb-1">T.{{ $hoadon_item->thang }}/{{ $hoadon_item->nam }}</div>
                                                <div class="text-[9px] font-bold text-rose-400 uppercase tracking-widest">Hạn: {{ date('d/m', strtotime($hoadon_item->ngayxuat . ' +5 days')) }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-bold text-slate-900 tabular-nums">{{ number_format($hoadon_item->tongtien) }}đ</div>
                                                <a href="{{ route('student.phongcuatoi.hoadon.chitiet', $hoadon_item->id) }}" class="inline-block mt-1 text-[9px] font-bold uppercase tracking-widest text-blue-600 hover:text-blue-700">Chi tiết</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('student.hoadoncuaem') }}" class="saas-btn-primary w-full h-10 mt-6 text-[10px] uppercase font-bold tracking-widest">Thanh toán ngay</a>
                            </div>
                        </article>
                    @endif

                    {{-- Room Assets --}}
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
                            
                            <div class="space-y-2">
                                <a href="{{ route('public.chitietvattu', ['id' => $phong->id, 'back' => 'student']) }}" class="saas-btn-secondary w-full h-9 text-[10px] uppercase font-bold tracking-widest">Tất cả vật tư</a>
                                <a href="{{ route('student.danhsachbaohong') }}" class="saas-btn-ghost w-full h-9 text-[10px] uppercase font-bold tracking-widest text-blue-600">Báo hỏng / Sự cố</a>
                            </div>
                        </div>
                    </article>

                </aside>
            </div>
        @endif
    </div>

    {{-- MODALS --}}
    @if($coPhong)
        {{-- Modal Gia hạn --}}
        <div id="modal-giahan" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm animate-in fade-in duration-300">
            <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl border border-slate-200 animate-in zoom-in-95 duration-300">
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 tracking-tight">Gia hạn hợp đồng</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Hệ thống quản lý cư trú</p>
                    </div>
                    <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition-all" data-modal-hide="modal-giahan">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-6 mb-8 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 border border-slate-100 shadow-sm mx-auto mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 mb-2">Tính năng đang cập nhật</h4>
                    <p class="text-[11px] font-medium text-slate-500 leading-relaxed">Chức năng tự động gia hạn đang được phát triển. Vui lòng liên hệ trực tiếp BQL để làm thủ tục.</p>
                </div>
                <button type="button" data-modal-hide="modal-giahan" class="saas-btn-primary w-full h-11 text-[10px] uppercase font-bold tracking-widest">Đã hiểu</button>
            </div>
        </div>

        {{-- Modal Trả phòng --}}
        <x-modal name="modal-traphong" title="Yêu cầu thanh lý hợp đồng" subtitle="Ban quản lý sẽ xử lý yêu cầu trong 24-48h làm việc" maxWidth="md">
            <div class="p-2">
                @if(($daGuiYeuCauTraPhong ?? false) === true)
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-6 mb-6 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-emerald-500 border border-emerald-100 shadow-sm mx-auto mb-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 mb-1">Yêu cầu đã được gửi</h4>
                        <p class="text-[11px] font-medium text-slate-500 leading-relaxed">Hệ thống đang xử lý. BQL sẽ liên hệ bạn để kiểm kê tài sản và thanh toán nợ.</p>
                    </div>
                    <button type="button" x-on:click="$dispatch('close')" class="saas-btn-primary w-full h-11 text-[10px] uppercase font-bold tracking-widest">Đóng</button>
                @else
                    <div class="rounded-2xl bg-rose-50 border border-rose-100 p-6 mb-8">
                        <h4 class="text-sm font-bold text-rose-900 mb-2">Xác nhận trả phòng?</h4>
                        <p class="text-[11px] font-medium text-rose-600 leading-relaxed mb-0">
                            Sau khi gửi yêu cầu, bạn không thể tự ý hủy bỏ. Vui lòng đảm bảo các khoản phí dịch vụ đã được chuẩn bị đầy đủ.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('student.yeucautraphong') }}" class="space-y-3">
                        @csrf
                        <button type="submit" class="saas-btn-primary !bg-rose-600 hover:!bg-rose-700 !border-rose-700 w-full h-11 text-[10px] uppercase font-bold tracking-widest">Xác nhận gửi yêu cầu</button>
                        <button type="button" x-on:click="$dispatch('close')" class="saas-btn-secondary w-full h-11 text-[10px] uppercase font-bold tracking-widest">Hủy bỏ</button>
                    </form>
                @endif
            </div>
        </x-modal>

    @endif
@endsection
