<x-admin-layout>
    <x-slot:title>Điều hành Bảo trì Hạ tầng định kỳ</x-slot:title>

    <div class="space-y-10 pb-20">
        <x-admin.page-header
            title="Kế hoạch bảo trì"
            subtitle="Hệ thống điều phối, giám sát và quản trị vòng đời bảo dưỡng hạ tầng kỹ thuật."
        >
            <button type="button" data-modal-target="modal-thembaotri" data-modal-toggle="modal-thembaotri" class="saas-btn-primary h-12 px-8 shadow-lg shadow-blue-500/20 group">
                <svg class="h-4.5 w-4.5 mr-2.5 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Lập lịch vận hành mới
            </button>
        </x-admin.page-header>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Target Asset</th>
                    <th>Nội dung công tác</th>
                    <th>Scheduled Date</th>
                    <th>Field Technician</th>
                    <th class="text-center">Operational Status</th>
                    <th class="text-right">Management Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($baotri as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-6">
                            <div class="flex items-center gap-2.5 font-black text-blue-600 text-[13px] tracking-tight group-hover:translate-x-1 transition-transform">
                                <div class="h-2 w-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(37,99,235,0.4)]"></div>
                                {{ $item->phong->ten_phong ?? 'Toàn hệ thống' }}
                            </div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2 ml-4">Infrastructure Asset</div>
                        </td>
                        <td class="py-6 max-w-xs">
                            <div class="text-[13px] font-bold leading-relaxed text-slate-600 italic border-l-2 border-slate-100 pl-4">"{{ $item->noidung }}"</div>
                        </td>
                        <td class="py-6">
                            <div class="text-[13px] font-black text-slate-900 tabular-nums tracking-tight">{{ date('d/m/Y', strtotime($item->ngaybaotri)) }}</div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-[0.15em] mt-1.5">Fiscal Period</div>
                        </td>
                        <td class="py-6">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center text-sm shadow-sm group-hover:bg-slate-900 group-hover:text-white transition-all">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <span class="text-[13px] font-black text-slate-700 uppercase tracking-tight">{{ $item->nguoithuchien }}</span>
                            </div>
                        </td>
                        <td class="py-6 text-center">
                            @php
                                $statusClass = $item->trangthai === 'Đã hoàn thành' ? 'saas-badge-success' : 'saas-badge-warning';
                            @endphp
                            <span class="saas-badge {{ $statusClass }} border-none shadow-sm font-black px-4 py-1.5">
                                {{ $item->trangthai }}
                            </span>
                        </td>
                        <td class="py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" data-modal-target="modal-suabaotri-{{ $item->id }}" data-modal-toggle="modal-suabaotri-{{ $item->id }}" class="h-9 w-9 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all" title="Cập nhật kế hoạch">
                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>

                                @if ($item->trangthai !== 'Đã hoàn thành')
                                    <form method="POST" action="{{ route('admin.hoanthanhbaotri', $item->id) }}" x-data="{ showConfirm: false }" x-on:confirmed="$el.requestSubmit()" class="inline">
                                        @csrf
                                        <button type="button" @click="showConfirm = true" class="h-9 px-5 rounded-xl bg-emerald-900 text-white text-[10px] font-black uppercase tracking-[0.15em] hover:scale-105 transition-all shadow-lg shadow-emerald-900/20">Hoàn tất</button>
                                        <x-confirmation-modal message="Xác nhận đối soát và nghiệm thu công tác bảo trì này?" />
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.xoabaotri', $item->id) }}" x-data="{ showConfirm: false }" x-on:confirmed="$el.requestSubmit()" class="inline">
                                    @csrf
                                    <button type="button" @click="showConfirm = true" class="h-9 w-9 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all" title="Hủy bỏ kế hoạch">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">Maintenance Schedule is Clear</h4>
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
        <x-modal id="modal-thembaotri" title="Thiết lập Lịch trình vận hành" subtitle="Khởi tạo kế hoạch bảo dưỡng kỹ thuật định kỳ cho hạ tầng.">
            <form method="POST" action="{{ route('admin.thembaotri') }}" class="space-y-8 p-2">
                @csrf
                <div>
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Target Infrastructure Asset</label>
                    <div class="relative group">
                        <select name="phong_id" class="saas-input h-12 px-5 font-black uppercase tracking-tight appearance-none bg-white">
                            <option value="">-- Toàn bộ hệ thống kỹ thuật --</option>
                            @foreach ($phongs as $phong)
                                <option value="{{ $phong->id }}">{{ $phong->ten_phong }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Nội dung công tác bảo dưỡng</label>
                    <textarea name="noidung" required rows="4" class="saas-input p-5 font-bold min-h-[120px] leading-relaxed resize-none" placeholder="Chi tiết các hạng mục cần đối soát và khắc phục..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Ngày thực thi</label>
                        <input name="ngaybaotri" required type="date" value="{{ date('Y-m-d') }}" class="saas-input h-12 px-5 font-black tabular-nums bg-white" />
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Technician In-Charge</label>
                        <input name="nguoithuchien" required type="text" class="saas-input h-12 px-5 font-black uppercase tracking-tight" placeholder="Assignee name..." />
                    </div>
                </div>

                <div class="flex gap-4 pt-8 border-t border-slate-100">
                    <button type="button" data-modal-hide="modal-thembaotri" class="saas-btn-secondary h-12 flex-1 justify-center text-[11px] font-black uppercase tracking-widest">Hủy bỏ</button>
                    <button type="submit" class="saas-btn-primary h-12 flex-[2] justify-center text-[11px] font-black uppercase tracking-widest shadow-xl shadow-blue-500/20">Xác nhận lịch trình</button>
                </div>
            </form>
        </x-modal>

        @foreach ($baotri as $item)
            <x-modal id="modal-suabaotri-{{ $item->id }}" title="Hiệu chỉnh Kế hoạch #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}" subtitle="Cập nhật tham số và điều phối lại công tác bảo trì hạ tầng.">
                <form method="POST" action="{{ route('admin.suabaotri', $item->id) }}" class="space-y-8 p-2">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Vị trí vận hành</label>
                        <div class="relative group">
                            <select name="phong_id" class="saas-input h-12 px-5 font-black uppercase tracking-tight appearance-none bg-white">
                                <option value="">-- Toàn bộ hệ thống kỹ thuật --</option>
                                @foreach ($phongs as $phong)
                                    <option value="{{ $phong->id }}" {{ $item->phong_id == $phong->id ? 'selected' : '' }}>{{ $phong->ten_phong }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Nội dung công việc</label>
                        <textarea name="noidung" required rows="4" class="saas-input p-5 font-bold min-h-[120px] leading-relaxed resize-none">{{ $item->noidung }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Ngày bảo trì</label>
                            <input name="ngaybaotri" required type="date" value="{{ $item->ngaybaotri }}" class="saas-input h-12 px-5 font-black tabular-nums bg-white" />
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Field Technician</label>
                            <input name="nguoithuchien" required type="text" value="{{ $item->nguoithuchien }}" class="saas-input h-12 px-5 font-black uppercase tracking-tight" />
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2.5 block">Trạng thái vận hành</label>
                        <div class="relative">
                            <select name="trangthai" class="saas-input h-12 px-5 font-black uppercase tracking-tight appearance-none bg-white">
                                <option value="Chưa thực hiện" {{ $item->trangthai === 'Chưa thực hiện' ? 'selected' : '' }}>Chưa thực hiện</option>
                                <option value="Đã hoàn thành" {{ $item->trangthai === 'Đã hoàn thành' ? 'selected' : '' }}>Đã hoàn thành</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-8 border-t border-slate-100">
                        <button type="button" data-modal-hide="modal-suabaotri-{{ $item->id }}" class="saas-btn-secondary h-12 flex-1 justify-center text-[11px] font-black uppercase tracking-widest">Hủy bỏ</button>
                        <button type="submit" class="saas-btn-primary h-12 flex-[2] justify-center text-[11px] font-black uppercase tracking-widest shadow-xl shadow-blue-500/20">Lưu thay đổi</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
        @endforeach
    @endpush
</x-admin-layout>
