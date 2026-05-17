<x-admin-layout>
    <x-slot:title>Quản lý Phòng nội trú</x-slot:title>

    <div class="space-y-8">
        <x-admin.page-header
            title="Hệ thống phòng"
            subtitle="Quản lý quỹ phòng, nhân khẩu và trạng thái hạ tầng toàn bộ KTX."
        >
            <div class="flex items-center gap-2">
                <button type="button" data-modal-target="modal-gan-taisan" data-modal-toggle="modal-gan-taisan" class="saas-btn-secondary h-11 px-6">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7h-7m7 0v7m0-7-2 2m-6 0H4v12h12V9m0 0 2-2"/></svg>
                    Thêm tài sản
                </button>
            </div>
        </x-admin.page-header>

        {{-- Filter Bar --}}
        <div class="saas-card p-6 bg-slate-50/50 border-dashed">
            <form action="{{ route('admin.phong.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
                <div class="flex-1 min-w-[300px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tìm kiếm định danh</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-brand-emerald transition-colors pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Mã phòng (VD: P.101)..." class="saas-input pl-12 h-11">
                    </div>
                </div>

                <div class="w-auto min-w-[200px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Khu vực tòa nhà</label>
                    <div class="relative group">
                        <select name="toa_nha_id" class="saas-input font-bold h-11 !pr-10" onchange="this.form.submit()">
                            <option value="">Tất cả các tòa</option>
                            @foreach ($toanhis as $toa)
                                <option value="{{ $toa->id }}" @selected(request('toa_nha_id') == $toa->id)>{{ $toa->ten_toa_nha }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="w-auto min-w-[140px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Vị trí tầng</label>
                    <select name="tang" class="saas-input font-bold h-11" onchange="this.form.submit()">
                        <option value="">Tất cả tầng</option>
                        @foreach($danhsachtang as $t)
                            <option value="{{ $t }}" @selected(request('tang') == $t)>Tầng {{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-1.5 h-11 bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                    <a href="{{ route('admin.phong.index', array_merge(request()->query(), ['view' => 'table'])) }}" 
                       class="flex h-9 w-9 items-center justify-center rounded-lg transition-all {{ $viewMode === 'table' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}" title="Chế độ bảng">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </a>
                    <a href="{{ route('admin.phong.index', array_merge(request()->query(), ['view' => 'grid'])) }}" 
                       class="flex h-9 w-9 items-center justify-center rounded-lg transition-all {{ $viewMode === 'grid' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}" title="Chế độ lưới">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </a>
                </div>
            </form>
        </div>

        @if ($viewMode === 'table')
            <x-admin.table-card>
                <thead>
                    <tr>
                        <th>Phòng nội trú</th>
                        <th class="text-center">Sức chứa</th>
                        <th class="text-center">Đối tượng</th>
                        <th>Mật độ lấp đầy</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-right">Đơn giá</th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($danhsachphong as $phong)
                        @php
                            $succhuamax = $phong->loaiphong->suc_chua ?? 0;
                            $soluongdango = $soluongdango_theophong[$phong->id] ?? 0;
                            $daydu = $succhuamax > 0 && $soluongdango >= $succhuamax;
                            $phantram = $succhuamax > 0 ? min(100, round($soluongdango / $succhuamax * 100)) : 0;
                            $toaName = $phong->toanha->ten_toa_nha ?? null;
                            $toaShort = $toaName ? preg_replace('/^tòa\\s*/iu', '', $toaName) : null;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-5">
                                <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-brand-emerald transition-colors">{{ $phong->ten_phong }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Tầng {{ $phong->tang }} • Tòa {{ $phong->toanha->ma_toa_nha ?? ($toaShort ?? ($toaName ?? 'Chưa có')) }}</div>
                            </td>
                            <td class="py-5 text-center">
                                <span class="text-xs font-bold text-slate-600 tabular-nums bg-slate-100 px-2 py-1 rounded-lg">{{ $succhuamax }} người</span>
                            </td>
                            <td class="py-5 text-center">
                                @php
                                    $genderBadgeRoom = match($phong->gioi_tinh_han_che->value) {
                                        'male' => 'saas-badge-info',
                                        'female' => 'saas-badge-error',
                                        default => 'saas-badge-success',
                                    };
                                @endphp
                                <span class="saas-badge {{ $genderBadgeRoom }}">
                                    {{ $phong->gioi_tinh_han_che->label() }}
                                </span>
                            </td>
                            <td class="py-5 min-w-[150px]">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700 {{ $daydu ? 'bg-slate-900' : 'bg-brand-emerald' }}" @style(["width: $phantram%"])></div>
                                    </div>
                                    <span class="text-[11px] font-bold text-slate-900 tabular-nums">{{ $soluongdango }}/{{ $succhuamax }}</span>
                                </div>
                            </td>
                            <td class="py-5 text-center">
                                @if($daydu)
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                        Kín chỗ
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Còn trống
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 text-right">
                                <div class="text-sm font-bold text-slate-900 tabular-nums">{{ number_format($phong->loaiphong->gia_thang ?? 0, 0, ',', '.') }}đ</div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">VND / Tháng</div>
                            </td>
                            <td class="py-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.phong.chitiet', ['id' => $phong->id]) }}" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chi tiết cư trú">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-24 text-center">
                                <div class="flex flex-col items-center gap-4 text-slate-200">
                                    <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không có dữ liệu phòng phù hợp</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-admin.table-card>
            @if(method_exists($danhsachphong, 'links'))
                <div class="mt-8">
                    {{ $danhsachphong->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($danhsachphong as $phong)
                    @php
                        $succhuamax = $phong->loaiphong->suc_chua ?? 0;
                        $soluongdango = $soluongdango_theophong[$phong->id] ?? 0;
                        $daydu = $succhuamax > 0 && $soluongdango >= $succhuamax;
                        $phantram = $succhuamax > 0 ? min(100, round($soluongdango / $succhuamax * 100)) : 0;
                        $isFemaleRoom = $phong->gioi_tinh_han_che->value === 'female';
                        $isMaleRoom = $phong->gioi_tinh_han_che->value === 'male';
                        $toaName = $phong->toanha->ten_toa_nha ?? null;
                        $toaShort = $toaName ? preg_replace('/^tòa\\s*/iu', '', $toaName) : null;
                    @endphp
                    <article class="saas-card p-6 relative overflow-hidden group hover:border-emerald-200 transition-all hover:shadow-xl hover:shadow-emerald-500/5">
                        <div class="absolute top-0 right-0 h-1.5 w-full {{ $daydu ? 'bg-slate-900' : ($isFemaleRoom ? 'bg-rose-500' : ($isMaleRoom ? 'bg-slate-500' : 'bg-emerald-500')) }}"></div>
                        
                        <header class="flex items-start justify-between mb-10">
                            <div>
                                <h3 class="text-4xl font-bold text-slate-900 leading-none tabular-nums group-hover:text-brand-emerald transition-colors">{{ $phong->ten_phong }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-3">Tầng {{ $phong->tang }} • Tòa {{ $phong->toanha->ma_toa_nha ?? ($toaShort ?? ($toaName ?? 'Chưa có')) }}</p>
                            </div>
                            <div class="h-11 w-11 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-brand-emerald/10 group-hover:text-brand-emerald transition-colors border border-slate-100 shadow-sm">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </header>

                        <div class="space-y-6">
                            <div>
                                <div class="flex items-end justify-between mb-2.5">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mật độ lấp đầy</span>
                                    <span class="text-xs font-bold text-slate-900 tabular-nums">{{ $soluongdango }} / {{ $succhuamax }} <span class="text-slate-300 font-medium">Giường</span></span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-1000 {{ $daydu ? 'bg-slate-900' : 'bg-brand-emerald' }}" @style(["width: $phantram%"])></div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-5 border-t border-slate-100">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Đơn giá định kỳ</span>
                                    <span class="text-sm font-bold text-slate-900 tabular-nums">{{ number_format($phong->loaiphong->gia_thang ?? 0, 0, ',', '.') }}đ</span>
                                </div>
                                <span class="saas-badge {{ $daydu ? 'saas-badge-error' : 'saas-badge-success' }}">
                                    {{ $daydu ? 'Full' : 'Available' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.phong.chitiet', ['id' => $phong->id]) }}" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chi tiết cư trú">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-24 text-center saas-card bg-slate-50/50 border-dashed border-2">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-200 mb-5 shadow-sm border border-slate-100">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 uppercase tracking-tight">Chưa có dữ liệu phòng</h3>
                        <p class="mt-2 text-xs text-slate-500 max-w-sm mx-auto font-medium">Hệ thống hiện tại chưa ghi nhận phòng nội trú nào phù hợp với các tiêu chí lọc đã chọn.</p>
                    </div>
                @endforelse
            </div>
            @if(method_exists($danhsachphong, 'links'))
                <div class="mt-8">
                    {{ $danhsachphong->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

    @push('modals')
        <x-modal id="modal-gan-taisan" title="Thêm tài sản (gán hàng loạt)" subtitle="Nhập loại tài sản và gán cho toàn bộ phòng trong 1 tòa, hoặc gán cho 1 phòng cụ thể.">
            <form method="POST" action="{{ route('admin.taisan.gan_hang_loat') }}" class="space-y-6" x-data="{ phamVi: '{{ old('pham_vi', 'toa') }}' }">
                @csrf

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Phạm vi áp dụng</label>
                    <div class="grid grid-cols-2 gap-2 rounded-2xl bg-slate-50 p-1 border border-slate-100">
                        <label class="cursor-pointer">
                            <input type="radio" name="pham_vi" value="toa" class="sr-only" x-model="phamVi">
                            <div :class="phamVi === 'toa' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="h-10 rounded-xl flex items-center justify-center text-[10px] font-bold uppercase tracking-widest transition-all">
                                Theo tòa
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="pham_vi" value="phong" class="sr-only" x-model="phamVi">
                            <div :class="phamVi === 'phong' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="h-10 rounded-xl flex items-center justify-center text-[10px] font-bold uppercase tracking-widest transition-all">
                                Theo phòng
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2" x-show="phamVi === 'toa'" x-cloak>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Chọn tòa</label>
                        <select name="toa_nha_id" class="saas-input font-bold" :required="phamVi === 'toa'">
                            <option value="">-- Chọn tòa --</option>
                            @foreach($toanhis as $toa)
                                <option value="{{ $toa->id }}" @selected(old('toa_nha_id') == $toa->id)>{{ $toa->ten_toa_nha }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2" x-show="phamVi === 'phong'" x-cloak>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Chọn phòng</label>
                        <select name="phong_id" class="saas-input font-bold" :required="phamVi === 'phong'">
                            <option value="">-- Chọn phòng --</option>
                            @foreach($toanhis as $toa)
                                @php $phongsByToa = ($tatCaPhongChoChon ?? collect())->where('toa_nha_id', $toa->id); @endphp
                                @if($phongsByToa->count() > 0)
                                    <optgroup label="Tòa {{ $toa->ten_toa_nha }}">
                                        @foreach($phongsByToa as $p)
                                            <option value="{{ $p->id }}" @selected(old('phong_id') == $p->id)>{{ $p->ten_phong }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tên tài sản</label>
                        <input name="ten_tai_san" value="{{ old('ten_tai_san') }}" class="saas-input font-bold" placeholder="VD: Giường đơn, Tủ, Quạt..." required maxlength="100" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Số lượng</label>
                        <input name="so_luong" type="number" value="{{ old('so_luong', 1) }}" class="saas-input font-bold tabular-nums" min="1" required />
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tình trạng</label>
                        <input name="tinh_trang" value="{{ old('tinh_trang', 'Tốt') }}" class="saas-input font-bold" maxlength="100" required />
                    </div>
                </div>

                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 p-4 border border-slate-100">
                    <input type="checkbox" name="cong_don" value="1" class="h-4 w-4 rounded border-slate-300 text-brand-emerald focus:ring-brand-emerald" @checked(old('cong_don', '1') == '1')>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-slate-900">Nếu phòng đã có tài sản này</div>
                        <div class="text-[11px] font-medium text-slate-500">Cộng dồn số lượng (không tạo bản ghi trùng tên tài sản).</div>
                    </div>
                </label>

                <div class="flex gap-4 pt-2">
                    <button type="submit" class="flex-[2] saas-btn-primary h-12 shadow-lg shadow-emerald-500/20">Gán tài sản</button>
                    <button type="button" data-modal-hide="modal-gan-taisan" class="flex-1 saas-btn-secondary h-12">Hủy bỏ</button>
                </div>
            </form>
        </x-modal>
    @endpush
</x-admin-layout>
