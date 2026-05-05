@extends('student.layouts.chinh')

@section('student_page_title', 'Hợp đồng cư trú')

@section('noidung')
    @php
        $activeTab = (string) request()->query('tab', 'hopdong');
        $allowedTabs = ['hopdong', 'gia-han'];
        if (!in_array($activeTab, $allowedTabs, true)) {
            $activeTab = 'hopdong';
        }

        $isAlumni = (auth()->user()?->vaitro === 'cuu_sinhvien');
        $yeuCauGiaHan = $yeuCauGiaHan ?? null;
        $hopdongHieuLuc = $hopdongHieuLuc ?? null;

        $hasAnyContract = method_exists($hopdong, 'isEmpty') ? !$hopdong->isEmpty() : !empty($hopdong);
        $hasActiveContract = (bool) $hopdongHieuLuc;
        $canShowTabs = $hasAnyContract && !$isAlumni;
    @endphp

    @if($canShowTabs)
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-lg font-semibold text-slate-900">Hợp đồng & gia hạn</div>
                <div class="mt-0.5 text-xs text-slate-500">Theo dõi hợp đồng cư trú và gửi yêu cầu gia hạn tại cùng một nơi.</div>
            </div>
            <nav class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80 w-fit" aria-label="Bộ lọc">
                @php
                    $tabItems = [
                        'hopdong' => ['label' => 'Hợp đồng'],
                        'gia-han' => ['label' => 'Gia hạn'],
                    ];
                @endphp
                @foreach($tabItems as $tabValue => $tab)
                    @php
                        $isActive = $activeTab === $tabValue;
                        $href = request()->fullUrlWithQuery(['tab' => $tabValue, 'page' => 1]);
                    @endphp
                    <a
                        href="{{ $href }}"
                        class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all {{ $isActive ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}"
                        aria-current="{{ $isActive ? 'page' : 'false' }}"
                    >
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>
    @endif

    @if ($hopdong->isEmpty())
        <div class="saas-card p-16 text-center border-dashed">
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-400">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 tracking-tight">Chưa có hợp đồng</h3>
            <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto">Hợp đồng của bạn sẽ hiển thị tại đây sau khi Ban quản lý xác nhận việc xếp phòng.</p>
            <div class="mt-8">
                <a href="{{ route('student.trangchu') }}" class="saas-btn-primary h-11 px-8 inline-flex items-center justify-center">
                    Về trang chủ
                </a>
            </div>
        </div>
    @elseif($activeTab === 'gia-han' && !$isAlumni)
        <div class="space-y-8">
            <div class="saas-card p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="text-sm font-semibold text-slate-900">Thao tác nhanh</div>
                        <div class="mt-0.5 text-xs text-slate-500">Gửi yêu cầu gia hạn hoặc gửi yêu cầu thanh lý hợp đồng.</div>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <a href="#form-gia-han" class="saas-btn-primary h-10 px-4 text-xs font-semibold">Gia hạn</a>
                        @if($hasActiveContract)
                            <form action="{{ route('student.yeucautraphong') }}" method="POST" onsubmit="return confirm('Gửi yêu cầu thanh lý hợp đồng và trả phòng?')">
                                @csrf
                                <button type="submit" class="saas-btn-danger h-10 px-4 text-xs font-semibold" @if(($yeuCauTraPhong?->trang_thai?->value ?? null) === \App\Enums\RegistrationStatus::Pending->value) disabled @endif>
                                    Yêu cầu thanh lý
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                    @if(($yeuCauTraPhong?->trang_thai?->value ?? null) === \App\Enums\RegistrationStatus::Pending->value)
                        <div class="mt-4 rounded-xl bg-amber-50 ring-1 ring-amber-100 px-4 py-3 text-sm text-amber-700">
                            Bạn đã gửi yêu cầu thanh lý. Ban quản lý đang xem xét và sẽ phản hồi sau.
                        </div>
                    @elseif(($yeuCauTraPhong?->trang_thai?->value ?? null) === \App\Enums\RegistrationStatus::Rejected->value)
                        @php
                            $lyDoTuChoi = null;
                            if (is_string($yeuCauTraPhong?->ghi_chu) && \Illuminate\Support\Str::startsWith($yeuCauTraPhong->ghi_chu, 'TRA_PHONG|')) {
                                $lyDoTuChoi = trim((string) \Illuminate\Support\Str::after($yeuCauTraPhong->ghi_chu, 'TRA_PHONG|'));
                            }
                        @endphp
                        <div class="mt-4 rounded-xl bg-rose-50 ring-1 ring-rose-100 px-4 py-3 text-sm text-rose-700">
                            Yêu cầu thanh lý của bạn đã bị từ chối.
                            @if($lyDoTuChoi)
                                <span class="font-semibold">Lý do:</span> {{ $lyDoTuChoi }}
                            @endif
                        </div>
                    @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                <aside class="md:col-span-4 space-y-4">
                    <div class="saas-card p-6 bg-slate-50/50 border-dashed">
                        <div class="text-xs font-semibold text-slate-500">Hợp đồng hiệu lực</div>
                        @if($hasActiveContract)
                            <div class="mt-4 space-y-3">
                                <div>
                                    <div class="text-[11px] font-semibold text-slate-500">Mã hợp đồng</div>
                                    <div class="mt-0.5 font-semibold text-slate-900 tabular-nums">{{ $hopdongHieuLuc->ma_hd }}</div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-semibold text-slate-500">Phòng</div>
                                    <div class="mt-0.5 font-semibold text-slate-900">{{ $hopdongHieuLuc->phong?->tenphong ?? '—' }}</div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-semibold text-slate-500">Ngày kết thúc hiện tại</div>
                                    <div class="mt-0.5 font-semibold text-slate-900 tabular-nums">{{ $hopdongHieuLuc->ngay_ket_thuc?->format('d/m/Y') ?? '—' }}</div>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 text-sm text-slate-600">Bạn chưa có hợp đồng hiệu lực để gia hạn.</div>
                        @endif
                    </div>

                    <div class="saas-card p-6 bg-blue-50 border-blue-100 flex gap-3">
                        <svg class="h-5 w-5 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-blue-700">
                            Yêu cầu gia hạn sẽ được Ban quản lý xét duyệt. Kết quả sẽ được thông báo khi xử lý xong.
                        </p>
                    </div>
                </aside>

                <main class="md:col-span-8 space-y-6">
                    <article id="form-gia-han" class="saas-card p-8">
                        <div class="text-sm font-semibold text-slate-900">Gửi yêu cầu gia hạn</div>
                        <div class="mt-1 text-xs text-slate-500">Chọn ngày kết thúc mới và gửi để Ban quản lý phê duyệt.</div>

                        @php
                            $ngayKetThuc = $hopdongHieuLuc?->ngay_ket_thuc;
                            if (is_string($ngayKetThuc)) {
                                $ngayKetThuc = \Illuminate\Support\Carbon::parse($ngayKetThuc);
                            }
                            $ngayMacDinh = $ngayKetThuc?->copy()->addMonths(5) ?? now()->addMonths(5);
                        @endphp

                        <form action="{{ route('student.giahan.store') }}" method="POST" class="mt-6 space-y-6" @if(!$hasActiveContract) data-no-loading="true" @endif>
                            @csrf
                            <input type="hidden" name="hopdong_id" value="{{ $hopdongHieuLuc?->id }}">

                            <div class="space-y-2">
                                <label for="ngay_ket_thuc_moi" class="saas-label">Ngày kết thúc mới</label>
                                <input
                                    type="date"
                                    name="ngay_ket_thuc_moi"
                                    id="ngay_ket_thuc_moi"
                                    value="{{ old('ngay_ket_thuc_moi', $ngayMacDinh->format('Y-m-d')) }}"
                                    class="saas-input h-11 font-semibold tabular-nums"
                                    @if(!$hasActiveContract) disabled @else required @endif
                                >
                                <div class="text-xs text-slate-500">Gợi ý: mặc định gia hạn thêm 01 học kỳ (5 tháng).</div>
                            </div>

                            <div class="space-y-2">
                                <label for="ly_do" class="saas-label">Lý do (tuỳ chọn)</label>
                                <textarea
                                    name="ly_do"
                                    id="ly_do"
                                    rows="4"
                                    class="saas-input p-3 text-sm"
                                    placeholder="Ví dụ: tiếp tục học tập kỳ tiếp theo..."
                                    @if(!$hasActiveContract) disabled @endif
                                >{{ old('ly_do') }}</textarea>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-2">
                                <a href="{{ route('student.hopdongcuatoi', ['tab' => 'hopdong']) }}" class="saas-btn-secondary h-10 px-4 text-xs font-semibold">Quay lại</a>
                                <button type="submit" class="saas-btn-primary h-10 px-4 text-xs font-semibold" data-loading-text="Đang gửi..." @if(!$hasActiveContract) disabled @endif>
                                    Gửi yêu cầu
                                </button>
                            </div>
                        </form>
                    </article>

                    <article class="saas-card overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/30">
                            <div class="text-sm font-semibold text-slate-900">Lịch sử yêu cầu gia hạn</div>
                            <div class="mt-0.5 text-xs text-slate-500">Theo dõi trạng thái xử lý các yêu cầu trước đó.</div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="saas-table">
                                <thead>
                                    <tr>
                                        <th>Hợp đồng</th>
                                        <th class="text-center">Ngày mong muốn</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th>Lý do</th>
                                        <th class="text-right">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($yeuCauGiaHan && $yeuCauGiaHan->count() > 0)
                                        @foreach ($yeuCauGiaHan as $item)
                                            @php
                                                $status = $item->trang_thai->value;
                                                $badgeClass = match($status) {
                                                    'pending' => 'saas-badge-warning',
                                                    'approved' => 'saas-badge-success',
                                                    'rejected' => 'saas-badge-error',
                                                    default => 'saas-badge-info',
                                                };
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="font-semibold text-slate-900 tabular-nums">{{ $item->hopdong?->ma_hd ?? '—' }}</div>
                                                    <div class="mt-0.5 text-xs text-slate-500">{{ $item->hopdong?->phong?->tenphong ?? '—' }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-xs font-semibold text-slate-700 tabular-nums">{{ $item->ngay_ket_thuc_moi?->format('d/m/Y') ?? '—' }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="saas-badge {{ $badgeClass }}">{{ $item->trang_thai->label() }}</span>
                                                </td>
                                                <td class="text-slate-600">
                                                    <div class="text-sm">{{ $item->ly_do ?: '—' }}</div>
                                                </td>
                                                <td class="text-right text-slate-600">
                                                    <div class="text-sm">{{ $item->ghi_chu_admin ?: '—' }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="py-14 text-center text-slate-500">
                                                Chưa có yêu cầu gia hạn nào.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if($yeuCauGiaHan && method_exists($yeuCauGiaHan, 'links'))
                            <div class="px-6 py-4 border-t border-slate-200">
                                {{ $yeuCauGiaHan->links() }}
                            </div>
                        @endif
                    </article>
                </main>
            </div>
        </div>
    @else
        <div class="saas-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-900">
                    <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        <tr>
                            <th class="px-6 py-4">Mã hợp đồng</th>
                            <th class="px-6 py-4">Phòng ở</th>
                            <th class="px-6 py-4">Thời hạn cư trú</th>
                            <th class="px-6 py-4 text-right">Giá ký kết</th>
                            <th class="px-6 py-4 text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($hopdong as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight">{{ $item->ma_hd }}</div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Năm học {{ date('Y', strtotime($item->ngay_bat_dau)) }}-{{ date('Y', strtotime($item->ngay_ket_thuc)) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm uppercase tracking-tight">{{ $item->phong->tenphong ?? 'Chưa xác định' }}</div>
                                            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">{{ $item->phong->toa ?? 'N/A' }} • Tầng {{ $item->phong->tang ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="space-y-0.5">
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Từ ngày</div>
                                            <div class="font-bold text-slate-900 tabular-nums text-xs">{{ date('d/m/Y', strtotime($item->ngay_bat_dau)) }}</div>
                                        </div>
                                        <svg class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        <div class="space-y-0.5">
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Đến ngày</div>
                                            <div class="font-bold text-slate-900 tabular-nums text-xs">{{ date('d/m/Y', strtotime($item->ngay_ket_thuc)) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-bold text-slate-900 tabular-nums tracking-tight">{{ number_format($item->gia_thuc_te) }}đ</div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">/ tháng</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusValue = $item->trang_thai instanceof \App\Enums\ContractStatus
                                            ? $item->trang_thai->value
                                            : (string) $item->trang_thai;

                                        $statusLabel = $item->trang_thai instanceof \App\Enums\ContractStatus
                                            ? $item->trang_thai->label()
                                            : (\App\Enums\ContractStatus::tryFrom($statusValue)?->label() ?? 'N/A');

                                        $badgeClass = match ($statusValue) {
                                            \App\Enums\ContractStatus::Active->value => 'saas-badge-success',
                                            \App\Enums\ContractStatus::Expired->value => 'saas-badge-warning',
                                            \App\Enums\ContractStatus::Terminated->value => 'saas-badge-error',
                                            default => 'saas-badge-secondary',
                                        };
                                    @endphp
                                    <span class="saas-badge {{ $badgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
