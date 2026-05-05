<x-admin-layout>
    <x-slot:title>Phát hành Thông báo nội khu</x-slot:title>

    <div class="space-y-8">
        <x-admin.page-header
            title="Bảng tin KTX"
            subtitle="Phát hành, quản lý và lưu trữ các thông báo quan trọng tới toàn thể cộng đồng cư dân."
        >
            <button type="button" data-modal-target="modal-themthongbao" data-modal-toggle="modal-themthongbao" class="saas-btn-primary h-11 px-6 shadow-lg shadow-blue-500/20">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tạo thông báo mới
            </button>
        </x-admin.page-header>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Nội dung tóm lược</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($thongbao as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5 max-w-xs">
                            <div class="text-sm font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $item->tieu_de }}</div>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Đã phát hành</span>
                            </div>
                        </td>
                        <td class="py-5 max-w-md">
                            <div class="text-xs font-medium leading-relaxed text-slate-600 line-clamp-2 border-l-2 border-slate-100 pl-3">
                                {{ Str::limit($item->noi_dung, 120) }}
                            </div>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button" data-modal-target="modal-suathongbao-{{ $item->id }}" data-modal-toggle="modal-suathongbao-{{ $item->id }}" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chỉnh sửa nội dung">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>

                                <form method="POST" action="{{ route('admin.xoathongbao', ['id' => $item->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()" class="inline">
                                    @csrf
                                    <button type="button" @click="showConfirm = true" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Gỡ bỏ thông báo">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                    <x-confirmation-modal type="danger" message="Xác nhận gỡ bỏ hoàn toàn thông báo này khỏi hệ thống?" />
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Bảng tin chưa có dữ liệu</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if(method_exists($thongbao, 'links'))
            <div class="mt-8">
                {{ $thongbao->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @push('modals')
        <x-modal id="modal-themthongbao" title="Soạn thảo thông báo" subtitle="Thiết lập nội dung mới để phát hành tới cộng đồng cư dân.">
            <form method="POST" action="{{ route('admin.themthongbao') }}" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label for="tieu_de_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tiêu đề bài đăng</label>
                    <input name="tieu_de" id="tieu_de_new" type="text" placeholder="Ví dụ: Thông báo lịch vệ sinh học kỳ mới..." value="{{ old('tieu_de') }}" class="saas-input font-bold" required>
                </div>
                <div class="space-y-2">
                    <label for="noidung_new" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Nội dung văn bản</label>
                    <textarea name="noi_dung" id="noidung_new" placeholder="Nhập nội dung chi tiết tại đây..." rows="8" class="saas-input !h-auto !py-4 font-medium leading-relaxed min-h-[200px] resize-none" required>{{ old('noi_dung') }}</textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-themthongbao" class="saas-btn-secondary flex-1 h-12">Hủy bỏ</button>
                    <button type="submit" class="saas-btn-primary flex-[2] h-12 shadow-lg shadow-blue-500/20">Phát hành thông báo</button>
                </div>
            </form>
        </x-modal>

        @foreach($thongbao as $item)
            <x-modal id="modal-suathongbao-{{ $item->id }}" title="Hiệu chỉnh thông báo" subtitle="Cập nhật lại nội dung thông báo #{{ $item->id }}.">
                <form method="POST" action="{{ route('admin.capnhatthongbao', ['id' => $item->id]) }}" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label for="tieu_de_{{ $item->id }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Tiêu đề bài đăng</label>
                        <input name="tieu_de" id="tieu_de_{{ $item->id }}" type="text" value="{{ $item->tieu_de }}" class="saas-input font-bold" required>
                    </div>

                    <div class="space-y-2">
                        <label for="noidung_{{ $item->id }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Nội dung chi tiết</label>
                        <textarea name="noi_dung" id="noidung_{{ $item->id }}" rows="10" class="saas-input !h-auto !py-4 font-medium leading-relaxed min-h-[250px] resize-none" required>{{ $item->noi_dung }}</textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" data-modal-hide="modal-suathongbao-{{ $item->id }}" class="saas-btn-secondary flex-1 h-12">Hủy bỏ</button>
                        <button type="submit" class="saas-btn-primary flex-[2] h-12 shadow-lg shadow-blue-500/20">Lưu thay đổi</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
