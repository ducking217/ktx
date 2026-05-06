<x-admin-layout>
    <x-slot:title>Nhật ký hoạt động</x-slot:title>

    <div class="space-y-6">
        <x-admin.page-header
            title="Nhật ký hoạt động"
            subtitle="Truy xuất nguồn gốc thao tác và kiểm soát biến động dữ liệu toàn cục."
        />

        {{-- Filter --}}
        <div class="saas-card p-5 border-slate-200/60 shadow-sm">
            <form action="{{ route('admin.activity-log') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-5">
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Thực thể</label>
                    <select name="model" class="saas-input text-xs font-bold">
                        <option value="">Tất cả</option>
                        @foreach($models as $m)
                            <option value="{{ $m }}" {{ request('model') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Quản trị viên</label>
                    <select name="user_id" class="saas-input text-xs font-bold">
                        <option value="">Tất cả</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ request('user_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Loại hành động</label>
                    <select name="action" class="saas-input text-xs font-bold">
                        <option value="">Tất cả</option>
                        @foreach($actions as $act)
                            <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Từ ngày</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="saas-input text-xs font-bold tabular-nums">
                </div>
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Đến ngày</label>
                        <input type="date" name="to" value="{{ request('to') }}" class="saas-input text-xs font-bold tabular-nums">
                    </div>
                    <button type="submit" aria-label="Tìm kiếm" class="saas-btn-primary h-11 w-11 flex-shrink-0 flex items-center justify-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" /></svg>
                    </button>
                </div>
            </form>
        </div>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Người thực hiện</th>
                    <th>Đối tượng</th>
                    <th class="text-center">Hành động</th>
                    <th class="text-right">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4 whitespace-nowrap">
                            <div class="text-xs font-bold text-slate-900 tabular-nums group-hover:text-brand-emerald transition-colors">{{ $log->created_at->format('d/m/Y') }}</div>
                            <div class="text-[9px] font-bold text-slate-400 tabular-nums mt-0.5 uppercase tracking-widest">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-7 w-7 rounded-lg bg-slate-900 flex items-center justify-center text-[9px] font-bold text-white flex-shrink-0">
                                    {{ substr($log->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">{{ $log->user->name ?? 'Hệ thống' }}</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Quản trị viên</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200/50 text-[9px] font-bold text-slate-600 uppercase tracking-tight">{{ $log->ten_model }}</span>
                                <span class="text-[9px] font-bold text-slate-400 tabular-nums">#{{ $log->id_ban_ghi }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            @php
                                $action = strtolower($log->hanh_dong);
                                $badgeClass = match(true) {
                                    str_contains($action, 'tạo') || str_contains($action, 'thêm') || str_contains($action, 'create') => 'saas-badge-success',
                                    str_contains($action, 'cập nhật') || str_contains($action, 'sửa') || str_contains($action, 'update') => 'saas-badge-warning',
                                    str_contains($action, 'xóa') || str_contains($action, 'delete') => 'saas-badge-error',
                                    default => 'saas-badge-info'
                                };
                            @endphp
                            <span class="saas-badge {{ $badgeClass }} text-[8px] font-bold px-2.5 py-0.5">{{ $log->hanh_dong }}</span>
                        </td>
                        <td class="py-4 text-right">
                            <button type="button" aria-label="Xem chi tiết" data-modal-target="modal-log-{{ $log->id }}" data-modal-toggle="modal-log-{{ $log->id }}" class="h-11 w-11 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/15 rounded-lg transition-all" title="Xem chi tiết">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không tìm thấy dữ liệu nhật ký</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if($logs->hasPages())
            <div class="py-4">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    @push('modals')
        @foreach($logs as $log)
            <x-modal id="modal-log-{{ $log->id }}" title="Chi tiết thay đổi" subtitle="Biến động dữ liệu của bản ghi #{{ $log->id_ban_ghi }} — {{ $log->ten_model }}">
                <div class="space-y-5">
                    <div class="grid grid-cols-2 gap-3 rounded-xl bg-slate-50 p-4 border border-slate-100">
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Thời gian</div>
                            <div class="text-xs font-bold text-slate-900 tabular-nums">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Người thực hiện</div>
                            <div class="text-xs font-bold text-slate-900">{{ $log->user->name ?? 'Hệ thống' }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Hành động</div>
                            <div class="text-xs font-bold text-brand-emerald uppercase">{{ $log->hanh_dong }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Đối tượng</div>
                            <div class="text-xs font-bold text-slate-900">{{ $log->ten_model }} #{{ $log->id_ban_ghi }}</div>
                        </div>
                    </div>

                    @if($log->du_lieu_cu)
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                Trước thay đổi
                            </label>
                            <div class="bg-slate-900 rounded-xl p-4 border border-slate-800">
                                <pre class="w-full text-[11px] text-slate-300 overflow-x-auto font-mono leading-relaxed">{{ json_encode($log->du_lieu_cu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    @endif

                    @if($log->du_lieu_moi)
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-brand-emerald uppercase tracking-widest flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-brand-emerald"></span>
                                Sau thay đổi
                            </label>
                            <div class="bg-brand-emerald/5 border border-brand-emerald/15 rounded-xl p-4">
                                <pre class="w-full text-[11px] text-ink-primary overflow-x-auto font-mono leading-relaxed">{{ json_encode($log->du_lieu_moi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    @endif

                    <button type="button" data-modal-hide="modal-log-{{ $log->id }}" class="saas-btn-secondary w-full justify-center h-9 text-xs font-bold uppercase tracking-widest">Đóng</button>
                </div>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
