<x-admin-layout>
    <x-slot:title>Quản lý tòa nhà</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Hệ thống tòa nhà</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Quản lý danh sách các tòa nhà trong khu nội trú.</p>
        </div>

        <div>
            <a href="{{ route('admin.toanha.tao') }}" class="inline-flex items-center gap-2 rounded-xl bg-ink-primary px-5 py-2.5 text-xs font-bold text-white shadow-sm transition-all hover:bg-ink-primary/90 active:scale-[0.98]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Thêm tòa nhà mới
            </a>
        </div>
    </div>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Thông tin tòa nhà</th>
                        <th class="px-6 py-4 font-bold">Mã tòa</th>
                        <th class="px-6 py-4 font-bold">Số lượng phòng</th>
                        <th class="px-6 py-4 font-bold">Mô tả</th>
                        <th class="px-6 py-4 font-bold text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($danhSachToaNha as $toaNha)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-4">
                                <div class="font-black text-ink-primary font-display text-lg uppercase tracking-tight">{{ $toaNha->ten_toa_nha }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-ui-bg px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-ink-primary ring-1 ring-inset ring-ui-border">
                                    {{ $toaNha->ma_toa_nha }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-ink-primary">{{ $toaNha->danhsachphong_count }}</span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">Phòng</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="max-w-xs truncate text-xs text-ink-secondary" title="{{ $toaNha->mo_ta }}">
                                    {{ $toaNha->mo_ta ?? 'Chưa có mô tả' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.toanha.chitiet', $toaNha->id) }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-ink-primary" title="Chỉnh sửa">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.toanha.xoa', $toaNha->id) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận xóa tòa nhà {{ $toaNha->ten_toa_nha }}?', action: () => showConfirm = true })" class="flex h-8 w-8 items-center justify-center rounded-lg border border-rose-100 bg-rose-50 text-rose-600 shadow-sm transition-colors hover:bg-rose-600 hover:text-white" title="Xóa">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Không có tòa nhà nào</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Vui lòng khởi tạo tòa nhà đầu tiên để quản lý.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
</x-admin-layout>
