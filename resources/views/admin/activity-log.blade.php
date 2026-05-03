<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-ink-primary">
            {{ __('Nhật ký hoạt động hệ thống') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <div class="mb-6 rounded-3xl border border-ui-border bg-ui-card p-6 shadow-sm">
                <form action="{{ route('admin.activity-log') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-5">
                    <div>
                        <label class="mb-1.5 block text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Model</label>
                        <select name="model" class="w-full rounded-2xl border-ui-border bg-ui-bg text-sm font-bold text-ink-primary focus:border-brand-emerald focus:ring-brand-emerald">
                            <option value="">Tất cả Model</option>
                            @foreach($models as $m)
                                <option value="{{ $m }}" {{ request('model') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Người thực hiện</label>
                        <select name="user_id" class="w-full rounded-2xl border-ui-border bg-ui-bg text-sm font-bold text-ink-primary focus:border-brand-emerald focus:ring-brand-emerald">
                            <option value="">Tất cả Admin</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ request('user_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Hành động</label>
                        <select name="action" class="w-full rounded-2xl border-ui-border bg-ui-bg text-sm font-bold text-ink-primary focus:border-brand-emerald focus:ring-brand-emerald">
                            <option value="">Tất cả hành động</option>
                            @foreach($actions as $act)
                                <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Từ ngày</label>
                        <input type="date" name="from" value="{{ request('from') }}" class="w-full rounded-2xl border-ui-border bg-ui-bg text-sm font-bold text-ink-primary focus:border-brand-emerald focus:ring-brand-emerald">
                    </div>
                    <div class="flex items-end gap-2">
                        <div class="flex-1">
                            <label class="mb-1.5 block text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Đến ngày</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-2xl border-ui-border bg-ui-bg text-sm font-bold text-ink-primary focus:border-brand-emerald focus:ring-brand-emerald">
                        </div>
                        <button type="submit" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-emerald text-white shadow-lg shadow-brand-emerald/20 transition-transform hover:scale-105 active:scale-95">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Activity Table -->
            <div class="overflow-hidden rounded-3xl border border-ui-border bg-ui-card shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-ui-border bg-ui-bg/50">
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Thời gian</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Người thực hiện</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Model</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50 text-center">Hành động</th>
                                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-ink-secondary/50">Tóm tắt thay đổi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ui-border">
                            @forelse($logs as $log)
                                <tr class="group transition-colors hover:bg-ui-bg/30">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-ink-primary tabular-nums">{{ $log->created_at->format('d/m/Y') }}</div>
                                        <div class="text-[10px] font-medium text-ink-secondary/40 tabular-nums">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="h-8 w-8 rounded-full bg-ui-bg ring-1 ring-ui-border flex items-center justify-center text-xs font-black text-brand-emerald">
                                                {{ substr($log->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <div class="font-bold text-ink-primary">{{ $log->user->name ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="rounded-lg bg-ui-bg px-2.5 py-1 text-[11px] font-black text-ink-secondary/60 ring-1 ring-inset ring-ui-border">
                                            {{ $log->ten_model }} #{{ $log->id_ban_ghi }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $badgeClass = match(strtolower($log->hanh_dong)) {
                                                'created', 'tạo mới', 'thêm mới' => 'bg-emerald-500/10 text-emerald-600 ring-emerald-500/20',
                                                'updated', 'cập nhật', 'sửa' => 'bg-amber-500/10 text-amber-600 ring-amber-500/20',
                                                'deleted', 'xóa' => 'bg-rose-500/10 text-rose-600 ring-rose-500/20',
                                                default => 'bg-slate-500/10 text-slate-600 ring-slate-500/20'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase tracking-widest ring-1 ring-inset {{ $badgeClass }}">
                                            {{ $log->hanh_dong }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" data-modal-target="modal-log-{{ $log->id }}" data-modal-toggle="modal-log-{{ $log->id }}" class="flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-white text-ink-secondary shadow-sm transition-colors hover:bg-ui-bg hover:text-brand-emerald">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-20 text-center">
                                        <div class="text-lg font-display font-black text-ink-secondary/20 uppercase italic tracking-widest">Không có dữ liệu nhật ký</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($logs->hasPages())
                    <div class="border-t border-ui-border bg-ui-bg/30 px-6 py-4">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('modals')
        @foreach($logs as $log)
            <x-modal id="modal-log-{{ $log->id }}" title="Chi tiết nhật ký hoạt động" subtitle="Thông tin đầy đủ về thay đổi dữ liệu của bản ghi #{{ $log->id }}.">
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4 rounded-2xl bg-ui-bg/50 p-4 ring-1 ring-inset ring-ui-border">
                        <div>
                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Thời gian</div>
                            <div class="text-xs font-bold text-ink-primary tabular-nums">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                        </div>
                        <div>
                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Người thực hiện</div>
                            <div class="text-xs font-bold text-ink-primary">{{ $log->user->name ?? 'Hệ thống' }}</div>
                        </div>
                        <div>
                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Hành động</div>
                            <div class="text-xs font-bold text-ink-primary uppercase">{{ $log->hanh_dong }}</div>
                        </div>
                        <div>
                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Đối tượng</div>
                            <div class="text-xs font-bold text-ink-primary">{{ $log->ten_model }} #{{ $log->id_ban_ghi }}</div>
                        </div>
                    </div>

                    @if($log->du_lieu_cu)
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-ink-primary uppercase tracking-widest">Dữ liệu trước thay đổi</label>
                            <pre class="w-full bg-ui-bg border-ui-border rounded-xl px-4 py-3 text-[10px] text-ink-secondary overflow-x-auto custom-scrollbar font-mono">{{ json_encode($log->du_lieu_cu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif

                    @if($log->du_lieu_moi)
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-brand-emerald uppercase tracking-widest">Dữ liệu sau thay đổi</label>
                            <pre class="w-full bg-brand-emerald/5 border border-brand-emerald/10 rounded-xl px-4 py-3 text-[10px] text-brand-emerald overflow-x-auto custom-scrollbar font-mono">{{ json_encode($log->du_lieu_moi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif

                    <div class="flex gap-3 pt-2">
                        <button type="button" data-modal-hide="modal-log-{{ $log->id }}" class="w-full rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Đóng chi tiết</button>
                    </div>
                </div>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
