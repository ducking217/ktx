<x-admin-layout>
    <x-slot:title>Quản lý tài khoản</x-slot:title>

    <div class="space-y-6">
        <x-admin.page-header title="Tài khoản quản trị" subtitle="Quản lý nhân sự và phân quyền vận hành hệ thống KTX.">
            <a href="{{ route('admin.accounts.tao') }}" class="saas-btn-primary h-9 px-4 text-xs shadow-sm shadow-emerald-500/20">
                <svg class="mr-1.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tạo tài khoản
            </a>
        </x-admin.page-header>

        <div class="saas-card p-5 border-slate-200/60 shadow-sm">
            <form action="{{ route('admin.accounts.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[240px]">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tìm kiếm</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center text-slate-400 pointer-events-none">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên, thư điện tử hoặc số điện thoại..." class="saas-input pl-9 text-xs">
                    </div>
                </div>
                <div class="w-44">
                    <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Vai trò</label>
                    <select name="role" class="saas-input text-xs font-bold">
                        <option value="">Tất cả vai trò</option>
                        @foreach(\App\Enums\UserRole::cases() as $role)
                            @if($role->isAdminGroup())
                                <option value="{{ $role->value }}" @selected(request('role') == $role->value)>{{ $role->label() }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="saas-btn-secondary h-9 px-4 text-xs font-bold">Lọc</button>
            </form>
        </div>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th class="w-[35%]">Thành viên</th>
                    <th>Vai trò</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Ngày tham gia</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $acc)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-slate-900 flex items-center justify-center text-xs font-bold text-white uppercase shadow-sm flex-shrink-0">
                                    {{ substr($acc->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-slate-900 truncate">{{ $acc->name }}</div>
                                    <div class="text-[9px] font-medium text-slate-400 truncate mt-0.5">{{ $acc->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            @php $roleBadge = $acc->vaitro === \App\Enums\UserRole::Admin ? 'saas-badge-error' : 'saas-badge-info'; @endphp
                            <span class="saas-badge {{ $roleBadge }} text-[8px] px-2.5 py-0.5">{{ $acc->vaitro->label() }}</span>
                        </td>
                        <td class="py-4 text-center">
                            @if($acc->is_active)
                                <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Hoạt động
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-slate-300 uppercase tracking-wider">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-200"></span>Vô hiệu
                                </span>
                            @endif
                        </td>
                        <td class="py-4 text-xs font-bold text-slate-500 tabular-nums">{{ $acc->created_at->format('d/m/Y') }}</td>
                        <td class="py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.accounts.sua', $acc->id) }}" class="h-8 w-8 inline-flex items-center justify-center text-slate-400 hover:text-brand-emerald hover:bg-brand-emerald/10 border border-transparent hover:border-brand-emerald/20 rounded-lg transition-all" title="Chỉnh sửa">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if(auth()->id() !== $acc->id)
                                    <form action="{{ route('admin.accounts.xoa', $acc->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa tài khoản này?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="h-8 w-8 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-lg transition-all" title="Xóa">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Không có tài khoản nào phù hợp</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if($accounts->hasPages())
            <div class="py-4">{{ $accounts->links() }}</div>
        @endif
    </div>
</x-admin-layout>
