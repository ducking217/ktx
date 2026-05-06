<x-admin-layout>
    <x-slot:title>Quản lý tòa nhà</x-slot:title>

    <div class="space-y-6">
        <x-admin.page-header
            title="Hệ thống tòa nhà"
            subtitle="Quản lý danh mục cơ sở hạ tầng, cấu trúc tầng và định mức vận hành."
        >
            <a href="{{ route('admin.toanha.tao') }}" class="saas-btn-primary h-9 px-4 text-xs shadow-sm shadow-emerald-500/20">
                <svg class="mr-1.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Thêm tòa nhà
            </a>
        </x-admin.page-header>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Tòa nhà</th>
                    <th>Mã tòa</th>
                    <th>Số phòng</th>
                    <th>Số tầng</th>
                    <th>Mô tả</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($danhSachToaNha as $toaNha)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-slate-900 flex items-center justify-center text-slate-300 flex-shrink-0 shadow-sm">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 12h1m4 0h1m-4-4h1m4 0h1m-4-4h1m4 0h1"/></svg>
                                </div>
                                <div class="text-xs font-bold text-slate-900 group-hover:text-brand-emerald transition-colors uppercase tracking-tight">{{ $toaNha->ten_toa_nha }}</div>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="saas-badge saas-badge-info text-[8px] font-bold px-2.5 py-0.5">{{ $toaNha->ma_toa_nha }}</span>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-900 tabular-nums">{{ $toaNha->phongs_count }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase">phòng</span>
                                @if(!is_null($toaNha->so_phong))
                                    <span class="text-[9px] font-bold text-slate-300 tabular-nums">/ {{ $toaNha->so_phong }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4">
                            @php $soTangThucTe = (int) ($toaNha->phongs_max_tang ?? 0); @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-900 tabular-nums">{{ $soTangThucTe }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase">tầng</span>
                                @if(!is_null($toaNha->so_tang))
                                    <span class="text-[9px] font-bold text-slate-300 tabular-nums">/ {{ $toaNha->so_tang }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4">
                            <p class="max-w-[180px] truncate text-[11px] text-slate-500 font-medium" title="{{ $toaNha->mo_ta }}">
                                {{ $toaNha->mo_ta ?? 'Chưa có mô tả' }}
                            </p>
                        </td>
                        <td class="py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.toanha.chitiet', $toaNha->id) }}" class="h-8 w-8 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-lg transition-all" title="Chỉnh sửa">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.toanha.xoa', $toaNha->id) }}" onsubmit="return confirm('Xác nhận gỡ bỏ tòa nhà này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="h-8 w-8 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-lg transition-all" title="Xóa">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Chưa có tòa nhà nào</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>
    </div>
</x-admin-layout>
