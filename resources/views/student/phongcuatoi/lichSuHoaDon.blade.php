@extends('student.layouts.chinh')

@section('student_page_title', 'Hóa đơn')

@section('noidung')
    @php
        $activeTab = (string) ($activeTab ?? request()->query('tab', 'can-thanh-toan'));
        $tabs = $tabs ?? [
            'can_thanh_toan' => (int) ($thongKe['chua_thanh_toan'] ?? 0),
            'cho_xac_nhan' => (int) ($thongKe['cho_xac_nhan'] ?? 0),
            'lich_su' => (int) ($thongKe['da_thanh_toan'] ?? 0),
        ];
    @endphp

    <div class="space-y-6">
        <x-admin.page-header
            title="Hóa đơn"
            subtitle="Theo dõi các khoản cần thanh toán, giao dịch đang chờ đối soát và lịch sử thu."
        />

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="text-sm font-semibold text-slate-900">Bộ lọc theo luồng xử lý</div>
                <div class="mt-0.5 text-xs text-slate-500">Chọn tab để xem đúng phần bạn cần.</div>
            </div>
            <nav class="flex items-center gap-1 p-1 rounded-xl bg-slate-100/80 w-fit" aria-label="Bộ lọc hóa đơn">
                @php
                    $tabItems = [
                        'can-thanh-toan' => ['label' => 'Cần thanh toán', 'count' => (int) ($tabs['can_thanh_toan'] ?? 0)],
                        'cho-xac-nhan' => ['label' => 'Chờ xác nhận', 'count' => (int) ($tabs['cho_xac_nhan'] ?? 0)],
                        'lich-su' => ['label' => 'Lịch sử', 'count' => (int) ($tabs['lich_su'] ?? 0)],
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
                        <span class="ml-2 inline-flex min-w-[20px] items-center justify-center rounded-full bg-slate-200/70 px-1.5 py-0.5 text-[10px] font-bold text-slate-700 tabular-nums">
                            {{ $tab['count'] }}
                        </span>
                    </a>
                @endforeach
            </nav>
        </div>

        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Hóa đơn</th>
                    <th class="text-right">Số tiền</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Hạn thanh toán</th>
                    <th>Ngày tạo</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hoadon as $item)
                    @php
                        $loai = (string) ($item->loai_hoadon ?? '');
                        $isRefund = $loai === 'refund';
                        $isDeposit = $loai === 'deposit';
                        $isExtra = $loai === 'extra';
                        $ky = null;
                        if (is_string($item->ghi_chu) && preg_match('/Ky\s+(\d{1,2}\/\d{4})/u', $item->ghi_chu, $m)) {
                            $ky = $m[1];
                        }
                        $kyHienThi = $ky
                            ?? ($item->ngay_thanh_toan?->format('m/Y') ?? $item->created_at?->format('m/Y'))
                            ?? 'Chưa có';
                        $tenLoai = $isRefund ? 'Hoàn cọc' : ($isDeposit ? 'Tiền cọc' : ($isExtra ? 'Phát sinh' : 'Hóa đơn tháng'));

                        $invoiceType = $loai;
                        $statusInvoice = $item->trang_thai;
                        $statusBadge = $statusInvoice->badgeClass($invoiceType);
                        $statusLabel = $statusInvoice->displayLabel($invoiceType);
                        $maHoaDon = $item->ma_hoa_don ?: ('HD-' . str_pad((string) $item->id, 6, '0', STR_PAD_LEFT));
                    @endphp
                    <tr>
                        <td>
                            <div class="font-semibold text-slate-900 tabular-nums">{{ $maHoaDon }}</div>
                            <div class="mt-0.5 text-xs text-slate-500">{{ $tenLoai }} • {{ $kyHienThi }}</div>
                        </td>
                        <td class="text-right">
                            <div class="font-semibold text-slate-900 tabular-nums">{{ number_format((int) $item->tong_tien) }} đ</div>
                        </td>
                        <td class="text-center">
                            <span class="saas-badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                        </td>
                        <td class="text-slate-600">
                            <div class="tabular-nums">{{ $item->ngay_het_han?->format('d/m/Y') ?? '—' }}</div>
                        </td>
                        <td class="text-slate-600">
                            <div class="tabular-nums">{{ $item->created_at?->format('d/m/Y') ?? '—' }}</div>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('student.hoadon.chitiet', $item->id) }}" class="saas-btn-secondary h-9 px-3 text-xs font-semibold">
                                    Xem
                                </a>
                                @if(!$isRefund && in_array($item->trang_thai, [\App\Enums\InvoiceStatus::Unpaid, \App\Enums\InvoiceStatus::Overdue], true))
                                    <a href="{{ route('student.hoadon.chitiet', $item->id) }}#huong-dan-thanh-toan" class="saas-btn-primary h-9 px-3 text-xs font-semibold">
                                        Thanh toán
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <x-empty-state
                                title="Chưa có hóa đơn"
                                description="Không có dữ liệu trong tab hiện tại."
                            />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>

        @if(method_exists($hoadon, 'links') && $hoadon->hasPages())
            <div class="mt-6">
                {{ $hoadon->links() }}
            </div>
        @endif
    </div>
@endsection
