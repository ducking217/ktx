<x-admin-layout>
    <x-slot name="title">Quản lý tài khoản</x-slot>

    <div class="space-y-6 animate-fade-up">
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-ink-primary uppercase tracking-tight">Tài khoản quản trị</h2>
                <p class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mt-1">Danh sách nhân sự vận hành hệ thống</p>
            </div>
            
            <a href="{{ route('admin.accounts.tao') }}" class="pdu-btn-primary shadow-lg shadow-brand-emerald/20">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tạo tài khoản mới
            </a>
        </header>

        {{-- Filters --}}
        <section class="pdu-card !p-4">
            <form action="{{ route('admin.accounts.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên, email..." 
                        class="w-full bg-ui-bg border-ui-border rounded-xl text-sm px-4 py-2 focus:ring-2 focus:ring-brand-emerald/20 transition-all">
                </div>
                <select name="role" class="bg-ui-bg border-ui-border rounded-xl text-[10px] font-black uppercase tracking-widest px-4 py-2">
                    <option value="">Tất cả vai trò</option>
                    @foreach(\App\Enums\UserRole::cases() as $role)
                        @if($role->isAdminGroup())
                            <option value="{{ $role->value }}" @selected(request('role') == $role->value)>{{ $role->label() }}</option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="pdu-btn-secondary !py-2">Lọc</button>
            </form>
        </section>

        <article class="pdu-card !p-0 overflow-hidden shadow-xl shadow-ink-primary/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">
                            <th class="px-8 py-4">Thành viên</th>
                            <th class="px-8 py-4">Vai trò</th>
                            <th class="px-8 py-4">Trạng thái</th>
                            <th class="px-8 py-4">Ngày tạo</th>
                            <th class="px-8 py-4 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @forelse($accounts as $acc)
                            <tr class="group hover:bg-ui-bg/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-ink-primary/5 flex items-center justify-center font-black text-ink-primary uppercase text-xs border border-ui-border">
                                            {{ substr($acc->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-ink-primary tracking-tight">{{ $acc->name }}</div>
                                            <div class="text-[10px] font-medium text-ink-secondary/60">{{ $acc->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    @php
                                        $color = match($acc->vaitro) {
                                            \App\Enums\UserRole::Admin => 'bg-status-error/10 text-status-error',
                                            \App\Enums\UserRole::AdminTruong => 'bg-brand-emerald/10 text-brand-emerald',
                                            \App\Enums\UserRole::AdminToaNha => 'bg-status-info/10 text-status-info',
                                            default => 'bg-ui-bg text-ink-secondary',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-widest {{ $color }}">
                                        {{ $acc->vaitro->label() }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    @if($acc->is_active)
                                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-status-success uppercase tracking-wider">
                                            <span class="h-1.5 w-1.5 rounded-full bg-status-success animate-pulse"></span>
                                            Hoạt động
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-ink-secondary/40 uppercase tracking-wider">
                                            <span class="h-1.5 w-1.5 rounded-full bg-ink-secondary/40"></span>
                                            Bị khóa
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-[11px] font-bold text-ink-secondary/60 tabular-nums">
                                    {{ $acc->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.accounts.sua', $acc->id) }}" class="p-2 text-ink-secondary hover:text-brand-emerald hover:bg-brand-emerald/5 rounded-lg transition-all">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        
                                        @if(auth()->id() !== $acc->id)
                                            <form action="{{ route('admin.accounts.xoa', $acc->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-ink-secondary hover:text-status-error hover:bg-status-error/5 rounded-lg transition-all">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-ink-secondary/40">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        <p class="text-xs font-black uppercase tracking-widest">Không tìm thấy tài khoản nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($accounts->hasPages())
                <div class="px-8 py-4 border-t border-ui-border bg-ui-bg/20">
                    {{ $accounts->links() }}
                </div>
            @endif
        </article>
    </div>
</x-admin-layout>
