<x-admin-layout>
    <x-slot:title>Quản lý Gia hạn cư trú</x-slot:title>

    <div class="space-y-8">
        <x-admin.page-header
            title="Yêu cầu gia hạn"
            subtitle="Thẩm định nguyện vọng kéo dài thời gian lưu trú và cập nhật chu kỳ hợp đồng mới."
        >
            <form action="{{ route('admin.giahan.index') }}" method="GET" class="flex items-center gap-3">
                <label class="sr-only" for="extension-status">Bộ lọc trạng thái</label>
                <div class="relative group">
                    <select id="extension-status" name="status" onchange="this.form.submit()" class="saas-input !h-11 !pr-10 font-bold uppercase tracking-widest text-[10px] min-w-[200px] shadow-sm">
                        <option value="Tất cả" {{ $status === 'Tất cả' ? 'selected' : '' }}>Mọi trạng thái</option>
                        @foreach(\App\Enums\ExtensionStatus::cases() as $case)
                            <option value="{{ $case->value }}" {{ $status === $case->value ? 'selected' : '' }}>{{ $case->label() }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-blue-500 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </form>
        </x-admin.page-header>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Cư dân / Định danh</th>
                    <th>Hợp đồng hiện tại</th>
                    <th class="text-center">Chu kỳ cũ</th>
                    <th class="text-center">Đề xuất gia hạn</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($yeuCauGiaHan as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight">{{ $item->sinhvien?->user?->name ?? $item->sinhvien?->taikhoan?->name ?? 'N/A' }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mt-1.5">{{ $item->sinhvien?->ma_sinh_vien ?? $item->sinhvien?->masinhvien ?? 'N/A' }}</div>
                        </td>
                        <td class="py-5">
                            <div class="text-xs font-bold text-slate-900 tabular-nums tracking-tight">{{ $item->hopdong ? 'REF-' . $item->hopdong->id : 'N/A' }}</div>
                            <div class="flex items-center gap-1.5 text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1.5">
                                <span class="h-1 w-1 rounded-full bg-blue-500"></span>
                                {{ $item->hopdong?->phong?->ten_phong ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <div class="text-xs font-bold text-slate-500 tabular-nums tracking-tight">
                                {{ $item->hopdong?->ngay_ket_thuc?->format('d/m/Y') ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <div class="text-xs font-bold text-emerald-600 tabular-nums tracking-tight bg-emerald-50 px-2.5 py-1 rounded-lg inline-block">
                                {{ $item->ngay_ket_thuc_moi?->format('d/m/Y') ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            @php
                                $statusEnumExt = $item->trang_thai;
                                $statusBadgeExt = match($statusEnumExt->value) {
                                    'pending' => 'saas-badge-warning',
                                    'approved' => 'saas-badge-success',
                                    'rejected' => 'saas-badge-error',
                                    default => 'saas-badge-info',
                                };
                            @endphp
                            <span class="saas-badge {{ $statusBadgeExt }}">
                                {{ $statusEnumExt->label() }}
                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @if($item->trang_thai->value === 'pending')
                                    <button type="button" data-modal-target="modal-approve-{{ $item->id }}" data-modal-toggle="modal-approve-{{ $item->id }}" class="p-2 text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 rounded transition-colors" title="Chấp thuận gia hạn">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <button type="button" data-modal-target="modal-reject-{{ $item->id }}" data-modal-toggle="modal-reject-{{ $item->id }}" class="p-2 text-rose-500 hover:text-rose-600 hover:bg-rose-50 rounded transition-colors" title="Từ chối yêu cầu">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                @else
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest px-2">Xử lý xong</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Không tìm thấy yêu cầu gia hạn</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if($yeuCauGiaHan->hasPages())
            <div class="mt-8">
                {{ $yeuCauGiaHan->links() }}
            </div>
        @endif
    </div>

    @push('modals')
        @foreach ($yeuCauGiaHan as $item)
            {{-- Modal Duyệt --}}
            <x-modal id="modal-approve-{{ $item->id }}" title="Phê duyệt gia hạn" subtitle="Xác nhận kéo dài thời hạn lưu trú cho cư dân theo đề xuất mới.">
                <div class="p-6 rounded-2xl bg-blue-50/50 border border-blue-100 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-white border border-blue-100 flex items-center justify-center shadow-sm">
                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hạn cư trú mới</div>
                            <div class="text-lg font-bold text-slate-900 tabular-nums">{{ $item->ngay_ket_thuc_moi?->format('d/m/Y') ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.giahan.duyet', $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label for="ghi_chu_admin_approve_{{ $item->id }}" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Phản hồi cho cư dân</label>
                        <textarea id="ghi_chu_admin_approve_{{ $item->id }}" name="ghi_chu_admin" rows="4" class="saas-input !h-auto !py-4 resize-none" placeholder="Ví dụ: Đã phê duyệt gia hạn. Vui lòng hoàn tất nghĩa vụ tài chính trước ngày ghi nhận..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-approve-{{ $item->id }}" class="saas-btn-secondary flex-1 h-12">Hủy bỏ</button>
                        <button type="submit" class="saas-btn-primary flex-1 h-12 shadow-lg shadow-emerald-500/20 !bg-emerald-600 hover:!bg-emerald-700">Xác nhận phê duyệt</button>
                    </div>
                </form>
            </x-modal>

            {{-- Modal Từ chối --}}
            <x-modal id="modal-reject-{{ $item->id }}" title="Từ chối gia hạn" subtitle="Yêu cầu cung cấp lý do cụ thể khi không chấp thuận gia hạn cư trú cho sinh viên.">
                <form action="{{ route('admin.giahan.tuchoi', $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label for="ghi_chu_admin_reject_{{ $item->id }}" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Lý do từ chối <span class="text-rose-500">*</span></label>
                        <textarea id="ghi_chu_admin_reject_{{ $item->id }}" name="ghi_chu_admin" rows="4" required class="saas-input !h-auto !py-4 border-rose-100 focus:border-rose-500 resize-none" placeholder="Vui lòng nêu rõ lý do không gia hạn (Vi phạm kỷ luật, không thuộc đối tượng ưu tiên...)"></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-reject-{{ $item->id }}" class="saas-btn-secondary flex-1 h-12">Quay lại</button>
                        <button type="submit" class="saas-btn-primary flex-1 h-12 shadow-lg shadow-rose-500/20 !bg-rose-600 hover:!bg-rose-700">Xác nhận từ chối</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
