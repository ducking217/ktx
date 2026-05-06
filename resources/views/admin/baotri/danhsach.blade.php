<x-admin-layout>
    <x-slot:title>Điều hành Bảo trì Hạ tầng định kỳ</x-slot:title>

    <div class="space-y-10 pb-20">
        <x-admin.page-header
            title="Kế hoạch bảo trì"
            subtitle="Hệ thống điều phối, giám sát và quản trị vòng đời bảo dưỡng hạ tầng kỹ thuật."
        >
            <div class="flex w-full flex-col gap-3 lg:flex-row lg:items-center lg:justify-end">
                <form action="{{ route('admin.baotri.index') }}" method="GET" class="w-full lg:w-[320px]">
                    <label class="sr-only" for="q">Tìm nhanh</label>
                    <div class="relative">
                        <input id="q" name="q" value="{{ $tuKhoa ?? '' }}" class="saas-input h-11 pr-10" placeholder="Tìm theo phòng..." />
                        <button type="submit" class="absolute inset-y-0 right-1.5 my-1.5 w-9 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors" aria-label="Tìm kiếm">
                            <svg class="mx-auto h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z"/></svg>
                        </button>
                    </div>
                </form>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <form action="{{ route('admin.baotri.xuat_excel') }}" method="GET" class="w-full sm:w-auto">
                        @if(($tuKhoa ?? '') !== '')
                            <input type="hidden" name="q" value="{{ $tuKhoa }}">
                        @endif
                        <button type="submit" class="saas-btn-secondary h-11 px-5 group whitespace-nowrap w-full sm:w-auto justify-center" aria-label="Xuất dữ liệu">
                            <svg class="h-4.5 w-4.5 mr-2.5 group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="sm:hidden">Xuất</span>
                            <span class="hidden sm:inline">Xuất dữ liệu</span>
                        </button>
                    </form>

                    <button type="button" data-modal-target="modal-thembaotri" data-modal-toggle="modal-thembaotri" class="saas-btn-primary h-11 px-6 shadow-lg shadow-emerald-500/20 group whitespace-nowrap w-full sm:w-auto justify-center">
                        <svg class="h-4.5 w-4.5 mr-2.5 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span class="sm:hidden">Lập lịch</span>
                        <span class="hidden sm:inline">Lập lịch vận hành</span>
                    </button>
                </div>
            </div>
        </x-admin.page-header>

        <x-admin.table-card>
            <colgroup>
                <col class="w-[140px]">
                <col class="w-[360px]">
                <col class="w-[160px]">
                <col class="w-[180px]">
                <col class="w-[160px]">
                <col class="w-[180px]">
            </colgroup>
            <thead>
                <tr>
                    <th>Phạm vi</th>
                    <th>Nội dung công tác</th>
                    <th>Ngày thực hiện</th>
                    <th>Người thực hiện</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($baotri as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4">
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-900">
                                <span class="h-2 w-2 rounded-full bg-brand-emerald"></span>
                                <span class="tabular-nums">{{ $item->phong->ten_phong ?? 'Toàn hệ thống' }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="text-sm font-medium text-slate-700 truncate" title="{{ $item->noi_dung }}">{{ $item->noi_dung }}</div>
                        </td>
                        <td class="py-4">
                            <div class="text-sm font-semibold text-slate-900 tabular-nums">{{ $item->ngay_bao_tri ? \Illuminate\Support\Carbon::parse($item->ngay_bao_tri)->format('d/m/Y') : '—' }}</div>
                            <div class="mt-1 text-[10px] font-medium text-slate-500">Tháng bảo trì</div>
                        </td>
                        <td class="py-4">
                            @php
                                $nguoiThucHien = (string) ($item->nguoi_thuc_hien ?? '');
                                $nguoiThucHienInitial = $nguoiThucHien !== '' ? mb_strtoupper(mb_substr(trim($nguoiThucHien), 0, 1)) : '—';
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-2xl bg-slate-50 ring-1 ring-inset ring-slate-200/70 flex items-center justify-center text-sm font-semibold text-slate-700 tabular-nums">
                                    {{ $nguoiThucHienInitial }}
                                </div>
                                <span class="text-sm font-semibold text-slate-900 truncate" title="{{ $nguoiThucHien }}">{{ $nguoiThucHien ?: '—' }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            @php
                                $statusValue = (string) ($item->trang_thai ?? '');
                                $statusLabel = match ($statusValue) {
                                    'done' => 'Đã hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                    default => 'Đã lên lịch',
                                };
                                $statusClass = match ($statusValue) {
                                    'done' => 'saas-badge-success',
                                    'cancelled' => 'saas-badge-error',
                                    default => 'saas-badge-warning',
                                };
                            @endphp
                            <span class="saas-badge {{ $statusClass }} border-none shadow-sm font-semibold px-3 py-1">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="py-4 text-right">
                            <div class="inline-flex items-center gap-1 rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200/70 p-0.5">
                                <button
                                    type="button"
                                    data-modal-target="modal-suabaotri-{{ $item->id }}"
                                    data-modal-toggle="modal-suabaotri-{{ $item->id }}"
                                    class="h-9 w-9 inline-flex items-center justify-center rounded-lg bg-white text-slate-800 ring-1 ring-inset ring-slate-200/70 hover:bg-slate-100 hover:ring-slate-300 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900/15"
                                    title="Cập nhật"
                                    aria-label="Cập nhật"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>

                                @if ($statusValue !== 'done' && $statusValue !== 'cancelled')
                                    <form method="POST" action="{{ route('admin.baotri.hoanthanh', $item->id) }}" x-data="{ showConfirm: false }" x-on:confirmed="$el.requestSubmit()" class="inline">
                                        @csrf
                                        <button
                                            type="button"
                                            @click="showConfirm = true"
                                            class="h-9 px-3 rounded-lg bg-emerald-600 text-white text-[11px] font-semibold hover:bg-emerald-700 transition-colors shadow-sm whitespace-nowrap focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/40"
                                        >
                                            Hoàn tất
                                        </button>
                                        <x-confirmation-modal message="Xác nhận đối soát và nghiệm thu công tác bảo trì này?" />
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.baotri.xoa', $item->id) }}" x-data="{ showConfirm: false }" x-on:confirmed="$el.requestSubmit()" class="inline">
                                    @csrf
                                    <button
                                        type="button"
                                        @click="showConfirm = true"
                                        class="h-9 w-9 inline-flex items-center justify-center rounded-lg bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200/70 hover:bg-rose-100 hover:ring-rose-300 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500/40"
                                        title="Xóa"
                                        aria-label="Xóa"
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                    <x-confirmation-modal type="danger" message="Hệ thống sẽ gỡ bỏ kế hoạch bảo trì này vĩnh viễn. Bạn chắc chắn?" />
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-40 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="h-20 w-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 border border-slate-100 border-dashed">
                                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">Không có kế hoạch bảo trì</h4>
                                <p class="text-[11px] text-slate-400 font-medium max-w-xs">Chưa có kế hoạch bảo trì nào được thiết lập trong giai đoạn này.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if(method_exists($baotri, 'links'))
            <div class="py-12">
                {{ $baotri->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @push('modals')
        <x-modal id="modal-thembaotri" title="Thiết lập lịch trình vận hành" subtitle="Khởi tạo kế hoạch bảo dưỡng kỹ thuật định kỳ cho hạ tầng." maxWidth="xl">
            <form method="POST" action="{{ route('admin.baotri.store') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="saas-label" for="baotri-phong-id">Phạm vi bảo trì</label>
                    <div class="relative group">
                        <select id="baotri-phong-id" name="phong_id" class="saas-input h-11 appearance-none bg-white font-semibold">
                            <option value="">-- Toàn bộ hệ thống kỹ thuật --</option>
                            @foreach ($phongs as $phong)
                                <option value="{{ $phong->id }}">{{ $phong->ten_phong }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="saas-label" for="baotri-noi-dung">Nội dung công tác</label>
                    <textarea id="baotri-noi-dung" name="noi_dung" required rows="4" class="saas-input p-3 text-sm leading-relaxed resize-none" placeholder="Chi tiết các hạng mục cần đối soát và khắc phục..."></textarea>
                    <input type="hidden" name="trang_thai" value="planned">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="saas-label" for="baotri-ngay">Ngày thực hiện</label>
                        <input id="baotri-ngay" name="ngay_bao_tri" required type="date" value="{{ date('Y-m-d') }}" class="saas-input h-11 tabular-nums bg-white" />
                    </div>
                    <div>
                        <label class="saas-label" for="baotri-nguoi">Người thực hiện</label>
                        <input id="baotri-nguoi" name="nguoi_thuc_hien" required type="text" class="saas-input h-11 font-semibold" placeholder="Nhập tên người thực hiện..." />
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 pt-4 border-t border-slate-100 sm:flex-row sm:justify-end">
                    <button type="submit" class="saas-btn-primary h-11 px-6 text-xs font-semibold shadow-xl shadow-emerald-500/20">Tạo lịch bảo trì</button>
                    <button type="button" data-modal-hide="modal-thembaotri" class="saas-btn-secondary h-11 px-5 text-xs font-semibold">Hủy</button>
                </div>
            </form>
        </x-modal>

        @foreach ($baotri as $item)
            <x-modal id="modal-suabaotri-{{ $item->id }}" title="Cập nhật lịch bảo trì" subtitle="Hiệu chỉnh thông tin và trạng thái vận hành." maxWidth="xl">
                <form method="POST" action="{{ route('admin.baotri.capnhat', $item->id) }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="saas-label" for="baotri-phong-id-{{ $item->id }}">Phạm vi bảo trì</label>
                        <div class="relative group">
                            <select id="baotri-phong-id-{{ $item->id }}" name="phong_id" class="saas-input h-11 appearance-none bg-white font-semibold">
                                <option value="">-- Toàn bộ hệ thống kỹ thuật --</option>
                                @foreach ($phongs as $phong)
                                    <option value="{{ $phong->id }}" {{ $item->phong_id == $phong->id ? 'selected' : '' }}>{{ $phong->ten_phong }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="saas-label" for="baotri-noi-dung-{{ $item->id }}">Nội dung công tác</label>
                        <textarea id="baotri-noi-dung-{{ $item->id }}" name="noi_dung" required rows="4" class="saas-input p-3 text-sm leading-relaxed resize-none">{{ $item->noi_dung }}</textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="saas-label" for="baotri-ngay-{{ $item->id }}">Ngày thực hiện</label>
                            <input id="baotri-ngay-{{ $item->id }}" name="ngay_bao_tri" required type="date" value="{{ $item->ngay_bao_tri }}" class="saas-input h-11 tabular-nums bg-white" />
                        </div>
                        <div>
                            <label class="saas-label" for="baotri-nguoi-{{ $item->id }}">Người thực hiện</label>
                            <input id="baotri-nguoi-{{ $item->id }}" name="nguoi_thuc_hien" required type="text" value="{{ $item->nguoi_thuc_hien }}" class="saas-input h-11 font-semibold" />
                        </div>
                    </div>

                    <div>
                        <label class="saas-label" for="baotri-trang-thai-{{ $item->id }}">Trạng thái</label>
                        <div class="relative">
                            <select id="baotri-trang-thai-{{ $item->id }}" name="trang_thai" class="saas-input h-11 appearance-none bg-white font-semibold">
                                <option value="planned" {{ $item->trang_thai === 'planned' ? 'selected' : '' }}>Đã lên lịch</option>
                                <option value="done" {{ $item->trang_thai === 'done' ? 'selected' : '' }}>Đã hoàn thành</option>
                                <option value="cancelled" {{ $item->trang_thai === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            <div class="absolute inset-y-0 right-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 pt-4 border-t border-slate-100 sm:flex-row sm:justify-end">
                        <button type="submit" class="saas-btn-primary h-11 px-6 text-xs font-semibold shadow-xl shadow-emerald-500/20">Lưu thay đổi</button>
                        <button type="button" data-modal-hide="modal-suabaotri-{{ $item->id }}" class="saas-btn-secondary h-11 px-5 text-xs font-semibold">Hủy</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
