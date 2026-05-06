<x-admin-layout>
    <x-slot:title>Quản lý Đăng ký Cư trú</x-slot:title>

    <div class="space-y-8">
        <x-admin.page-header
            title="Hồ sơ đăng ký"
            subtitle="{{ ($type ?? 'thue-phong') === 'tra-phong' ? 'Luồng trả phòng: kiểm tra công nợ, xác nhận thanh lý và giải phóng giường.' : 'Luồng thuê phòng: thẩm định hồ sơ, điều phối hạ tầng và xác thực nghĩa vụ tài chính.' }}"
        >
            <div class="space-y-3">
                <x-admin.status-tabs
                    :items="[
                        'thue-phong' => 'Thuê phòng (' . (int) ($countThuePhong ?? 0) . ')',
                        'tra-phong' => 'Trả phòng (' . (int) ($countTraPhong ?? 0) . ')',
                    ]"
                    :active="$type ?? 'thue-phong'"
                    route="admin.duyetdangky"
                    param="type"
                    defaultValue="thue-phong"
                />

            <x-admin.status-tabs
                :items="[
                    'Tất cả' => 'Tất cả hồ sơ',
                    \App\Enums\RegistrationStatus::Pending->value => 'Chờ duyệt',
                    \App\Enums\RegistrationStatus::ApprovedPendingPayment->value => 'Chờ thu phí',
                    \App\Enums\RegistrationStatus::Approved->value => 'Đã duyệt',
                    \App\Enums\RegistrationStatus::Completed->value => 'Hoàn tất',
                    \App\Enums\RegistrationStatus::Rejected->value => 'Từ chối',
                ]"
                :active="$status ?? null"
                route="admin.duyetdangky"
                param="status"
                defaultValue="Tất cả"
            />
            </div>
        </x-admin.page-header>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Sinh viên</th>
                    <th class="text-center">Phòng được phân</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">CCCD</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($danhsachdangky as $dangky)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $dangky->ho_ten ?? $dangky->user?->name ?? 'Chưa xác định' }}</span>
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $dangky->email ?? $dangky->user?->email ?? 'Chưa có' }}</span>
                                    <div class="h-1 w-1 rounded-full bg-slate-200"></div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest tabular-nums">{{ $dangky->so_dien_thoai ?? $dangky->user?->phone ?? 'Chưa có' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">
                                    {{ \Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG')
                                        ? ($dangky->user?->sinhvien?->current_hopdong?->giuong?->phong?->ten_phong ?? 'Chưa có')
                                        : ($dangky->phong?->ten_phong ?? 'Chưa phân phòng') }}
                                </span>
                                @php
                                    $isTraPhong = \Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG');
                                    $loaiDangKy = $isTraPhong ? \App\Enums\RegistrationType::Return : \App\Enums\RegistrationType::Rental;
                                @endphp
                                <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">{{ $loaiDangKy?->label() ?? 'Chưa có' }}</span>
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            @php
                                $statusEnum = $dangky->trang_thai;
                                $statusBadgeDangKy = match ($statusEnum) {
                                    \App\Enums\RegistrationStatus::Approved, \App\Enums\RegistrationStatus::Completed => 'saas-badge-success',
                                    \App\Enums\RegistrationStatus::ApprovedPendingPayment => 'saas-badge-info',
                                    \App\Enums\RegistrationStatus::Rejected => 'saas-badge-error',
                                    \App\Enums\RegistrationStatus::Pending => 'saas-badge-warning',
                                    default => 'saas-badge-info'
                                };
                            @endphp
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="saas-badge {{ $statusBadgeDangKy }}">
                                    {{ $statusEnum?->label() ?? 'Chưa có' }}
                                </span>
                                @if($dangky->token_expires_at && $dangky->trang_thai === \App\Enums\RegistrationStatus::ApprovedPendingPayment)
                                    <div class="text-[9px] font-bold text-rose-500 uppercase tracking-widest tabular-nums bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-100/50">
                                        Hết hạn: {{ \Carbon\Carbon::parse($dangky->token_expires_at)->format('d/m H:i') }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-5 text-center">
                            @if($dangky->anh_cccd_path)
                                <div x-data="{ openPreview: false }">
                                    <button @click="openPreview = true" type="button" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xem CCCD">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <template x-teleport="body">
                                        <div x-show="openPreview" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 backdrop-blur-xl p-10" @keydown.escape.window="openPreview = false">
                                            <div @click.away="openPreview = false" class="relative max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/10">
                                                <div class="absolute top-6 right-6 z-10">
                                                    <button @click="openPreview = false" class="h-10 w-10 flex items-center justify-center rounded-xl bg-black/50 text-white hover:bg-black transition-all border border-white/20">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </div>
                                                <div class="p-3 bg-slate-950">
                                                    <img src="{{ route('private.file', ['path' => $dangky->anh_cccd_path]) }}" class="w-full h-auto max-h-[80vh] object-contain rounded-2xl" alt="Ảnh CCCD">
                                                    <div class="p-4 bg-slate-900 mt-3 rounded-xl">
                                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Cổng xác thực danh tính</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            @else
                                <span class="text-[10px] font-bold uppercase text-slate-300 tracking-widest">Chưa có</span>
                            @endif
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex justify-end items-center gap-1">
                                @if ($dangky->trang_thai === \App\Enums\RegistrationStatus::Pending)
                                    @if(\Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG'))
                                        <form method="POST" action="{{ route('admin.dangky.traphong.xuly', ['id' => $dangky->id]) }}" onsubmit="return confirm('Xác nhận xử lý yêu cầu trả phòng này?')">
                                            @csrf
                                            <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xử lý trả phòng">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.xulyduyetdangky', ['id' => $dangky->id]) }}" onsubmit="return confirm('Phê duyệt hồ sơ đăng ký cư trú này?')">
                                            @csrf
                                            <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Phê duyệt">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                @elseif($dangky->trang_thai === \App\Enums\RegistrationStatus::ApprovedPendingPayment)
                                    @if(!\Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG'))
                                        <form method="POST" action="{{ route('admin.dangky.xacnhanthanhtoan', ['id' => $dangky->id]) }}" onsubmit="return confirm('Xác nhận sinh viên đã thanh toán?')">
                                            @csrf
                                            <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Xác nhận thanh toán">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                @if (in_array($dangky->trang_thai, [\App\Enums\RegistrationStatus::Pending, \App\Enums\RegistrationStatus::ApprovedPendingPayment]))
                                    <form method="POST" action="{{ \Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG') ? route('admin.dangky.traphong.tuchoi', ['id' => $dangky->id]) : route('admin.xulytuchoidangky', ['id' => $dangky->id]) }}" onsubmit="return confirm('{{ \Illuminate\Support\Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG') ? 'Từ chối yêu cầu trả phòng này?' : 'Từ chối hồ sơ đăng ký này?' }}')">
                                        @csrf
                                        <button type="submit" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Từ chối">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                @endif

                                @if($dangky->trang_thai === \App\Enums\RegistrationStatus::Completed)
                                    <div class="h-9 w-9 inline-flex items-center justify-center text-emerald-400 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm" title="Đã hoàn tất">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Chưa có hồ sơ đăng ký nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if(method_exists($danhsachdangky, 'links'))
            <div class="mt-8">
                {{ $danhsachdangky->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
