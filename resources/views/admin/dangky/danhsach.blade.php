<x-admin-layout>
    <x-slot:title>Duyệt đăng ký cư trú</x-slot:title>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-ink-primary font-display uppercase tracking-tight">Xét duyệt đăng ký</h1>
            <p class="text-xs font-medium text-ink-secondary/60">Thẩm định hồ sơ, điều phối giường và xác thực nghĩa vụ tài chính.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <nav class="flex items-center gap-1 rounded-xl bg-ui-bg p-1 ring-1 ring-ui-border shadow-sm">
                @foreach ([
                    'Tất cả' => 'Tất cả', 
                    \App\Enums\RegistrationStatus::Pending->value => 'Chờ duyệt', 
                    \App\Enums\RegistrationStatus::ApprovedPendingPayment->value => 'Chờ đóng tiền', 
                    \App\Enums\RegistrationStatus::Approved->value => 'Đã duyệt', 
                    \App\Enums\RegistrationStatus::Completed->value => 'Hoàn tất', 
                    \App\Enums\RegistrationStatus::Rejected->value => 'Từ chối'
                ] as $val => $label)
                    @php
                        $isActive = (isset($status) && $status === $val) || (!isset($status) && $val === 'Tất cả');
                    @endphp
                    <a href="{{ route('admin.duyetdangky', ['status' => $val]) }}"
                       class="rounded-lg px-4 py-2 text-[10px] font-bold uppercase tracking-widest transition-all {{ $isActive ? 'bg-white text-ink-primary shadow-sm ring-1 ring-ui-border' : 'text-ink-secondary hover:text-ink-primary' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    <article class="overflow-hidden rounded-2xl bg-white border border-ui-border shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-ink-primary">
                <thead class="bg-ui-bg/50 border-b border-ui-border text-[10px] font-bold uppercase tracking-widest text-ink-secondary">
                    <tr>
                        <th class="px-6 py-4 font-bold">Ứng viên</th>
                        <th class="px-6 py-4 font-bold text-center">Chỉ định</th>
                        <th class="px-6 py-4 font-bold text-center">Trạng thái</th>
                        <th class="px-6 py-4 font-bold text-center">Hồ sơ</th>
                        <th class="px-6 py-4 font-bold text-right">Điều phối</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($danhsachdangky as $dangky)
                        <tr class="group transition-colors hover:bg-ui-bg/50">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-ink-primary font-display text-base">{{ $dangky->ho_ten ?? $dangky->sinhvien?->taikhoan?->name ?? 'N/A' }}</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">{{ $dangky->email ?? $dangky->sinhvien?->taikhoan?->email ?? 'N/A' }}</span>
                                        <span class="h-1 w-1 rounded-full bg-ui-border"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary">{{ $dangky->so_dien_thoai ?? $dangky->sinhvien?->sodienthoai ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <div class="flex items-center gap-1.5 font-bold text-ink-primary text-sm">
                                        <svg class="h-3.5 w-3.5 text-ink-secondary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        {{ $dangky->phong?->tenphong ?? 'Chờ xếp' }}
                                    </div>
                                    @if($dangky->giuong_no)
                                        <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-ink-secondary/60">Giường #{{ $dangky->giuong_no }}</span>
                                    @endif
                                    <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-brand-emerald/80">{{ $dangky->loaidangky instanceof \App\Enums\RegistrationType ? $dangky->loaidangky->label() : $dangky->loaidangky }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $statusEnum = $dangky->trangthai;
                                    $badgeClass = match ($statusEnum) {
                                        \App\Enums\RegistrationStatus::Approved, \App\Enums\RegistrationStatus::Completed => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                        \App\Enums\RegistrationStatus::ApprovedPendingPayment => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10',
                                        \App\Enums\RegistrationStatus::Rejected => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-700/10',
                                        \App\Enums\RegistrationStatus::Pending => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                        default => 'bg-ui-bg text-ink-secondary ring-1 ring-inset ring-ui-border'
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $statusEnum->label() }}
                                </span>
                                @if($dangky->expires_at && $dangky->trangthai === \App\Enums\RegistrationStatus::ApprovedPendingPayment)
                                    <div class="mt-1.5 text-[9px] font-bold text-rose-500 uppercase tracking-tighter tabular-nums">
                                        Hết hạn: {{ $dangky->expires_at->format('d/m H:i') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($dangky->anh_cccd_path)
                                    <div x-data="{ openPreview: false }">
                                        <button @click="openPreview = true" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-ui-border bg-ui-bg text-ink-secondary transition-all hover:bg-white hover:text-ink-primary hover:shadow-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                        
                                        <template x-teleport="body">
                                            <div x-show="openPreview" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4">
                                                <div @click.away="openPreview = false" class="relative max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-300">
                                                    <div class="absolute top-4 right-4 z-10">
                                                        <button @click="openPreview = false" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-900/50 text-white backdrop-blur-md hover:bg-slate-900/80 transition-all">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </div>
                                                    <div class="p-2 bg-slate-100">
                                                        <img src="{{ route('private.file', ['path' => $dangky->anh_cccd_path]) }}" class="w-full h-auto max-h-[85vh] object-contain rounded-xl" alt="CCCD Preview">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                @else
                                    <span class="text-[10px] font-bold uppercase text-ink-secondary/30">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    @if ($dangky->trangthai === \App\Enums\RegistrationStatus::Pending)
                                        <form method="POST" action="{{ route('admin.xulyduyetdangky', ['id' => $dangky->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                            @csrf
                                            <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận duyệt hồ sơ cho ứng viên này?', action: () => showConfirm = true })" class="h-8 flex items-center justify-center rounded-lg bg-ink-primary px-3 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm transition-all hover:bg-brand-emerald active:scale-[0.98]">Duyệt</button>
                                        </form>
                                    @elseif($dangky->trangthai === \App\Enums\RegistrationStatus::ApprovedPendingPayment)
                                        <form method="POST" action="{{ route('admin.dangky.xacnhanthanhtoan', ['id' => $dangky->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                            @csrf
                                            <button type="button" @click="$dispatch('open-confirm', { message: 'Xác nhận sinh viên đã thanh toán phí cư trú?', action: () => showConfirm = true })" class="h-8 flex items-center justify-center rounded-lg bg-brand-emerald px-3 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm transition-all hover:bg-brand-jade active:scale-[0.98]">XN Tiền</button>
                                        </form>
                                    @endif

                                    @if (in_array($dangky->trangthai, [\App\Enums\RegistrationStatus::Pending, \App\Enums\RegistrationStatus::ApprovedPendingPayment]))
                                        <form method="POST" action="{{ route('admin.xulytuchoidangky', ['id' => $dangky->id]) }}" x-data="{ showConfirm: false }" @confirmed="$el.submit()">
                                            @csrf
                                            <button type="button" @click="$dispatch('open-confirm', { message: 'Bạn có chắc chắn muốn từ chối đăng ký này?', action: () => showConfirm = true })" class="h-8 flex items-center justify-center rounded-lg border border-rose-200 bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-rose-600 shadow-sm transition-all hover:bg-rose-50 active:scale-[0.98]">Từ chối</button>
                                        </form>
                                    @endif
                                    
                                    @if($dangky->trangthai === \App\Enums\RegistrationStatus::Completed)
                                        <div class="h-8 flex items-center px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-600/50 italic">Đã hoàn tất</div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-ui-bg text-ink-secondary/50 mb-3">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="text-sm font-bold text-ink-primary">Chưa có đăng ký</div>
                                <div class="text-[11px] text-ink-secondary mt-1">Hệ thống hiện chưa ghi nhận đơn đăng ký mới nào.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($danhsachdangky, 'links'))
            <div class="border-t border-ui-border px-6 py-4 bg-ui-bg/30">
                {{ $danhsachdangky->links() }}
            </div>
        @endif
    </article>
</x-admin-layout>