@extends('student.layouts.chinh')

@section('noidung')
    <div class="mb-6">
        <a href="{{ route('student.hoadoncuaem') }}" class="saas-btn-ghost h-9 px-3 text-xs mb-2 w-fit">
            <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Quay lại
        </a>
        @php
            $loai = (string) ($hoadon->loai_hoadon ?? '');
            $isRefund = $loai === 'refund';
            $isDeposit = $loai === 'deposit';
            $isExtra = $loai === 'extra';
            $ky = null;
            if (is_string($hoadon->ghi_chu) && preg_match('/Ky\s+(\d{1,2}\/\d{4})/u', $hoadon->ghi_chu, $m)) {
                $ky = $m[1];
            }
            $kyHienThi = $ky
                ?? ($hoadon->ngay_thanh_toan?->format('m/Y') ?? $hoadon->created_at?->format('m/Y'))
                ?? 'N/A';
            $tenPhong = $hoadon->hopdong?->giuong?->phong?->ten_phong ?? $hoadon->phong?->ten_phong ?? 'N/A';
            $maHoaDon = $hoadon->ma_hoa_don ?: ('HD-' . str_pad((string) $hoadon->id, 6, '0', STR_PAD_LEFT));

            $statusInvoice = $hoadon->trang_thai;
            $statusBadge = match($statusInvoice) {
                \App\Enums\InvoiceStatus::Paid => 'saas-badge-success',
                \App\Enums\InvoiceStatus::PendingConfirmation => 'saas-badge-info',
                \App\Enums\InvoiceStatus::Overdue => 'saas-badge-error',
                default => $isRefund ? 'saas-badge-info' : 'saas-badge-warning',
            };
        @endphp
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="text-xl font-semibold text-slate-900">
                    {{ $isRefund ? 'Hoàn cọc' : ($isDeposit ? 'Tiền cọc' : ($isExtra ? 'Phát sinh' : ('Hóa đơn ' . $kyHienThi))) }}
                </div>
                <div class="mt-0.5 text-sm text-slate-500">
                    Mã: <span class="font-semibold text-slate-700 tabular-nums">{{ $maHoaDon }}</span> • Phòng {{ $tenPhong }}
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="saas-badge {{ $statusBadge }}">{{ $statusInvoice->label() }}</span>
            </div>
        </div>
    </div>

    <div class="mb-6">
        @if($isRefund)
            @if($hoadon->trang_thai === \App\Enums\InvoiceStatus::Paid)
                <div class="saas-card p-5">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="font-semibold text-slate-900">Đã hoàn tiền cọc</div>
                            <div class="mt-0.5 text-sm text-slate-500">Ngày hoàn: {{ $hoadon->ngay_thanh_toan?->format('d/m/Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="text-sm text-slate-500">Vui lòng giữ biên nhận khi cần đối soát.</div>
                    </div>
                </div>
            @else
                <div class="saas-card p-5">
                    <div class="font-semibold text-slate-900">Chờ Ban quản lý hoàn tiền cọc</div>
                    <div class="mt-0.5 text-sm text-slate-500">Dự kiến xử lý trước: {{ $hoadon->ngay_het_han?->format('d/m/Y') ?? 'N/A' }}</div>
                    <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                        Vui lòng đến Phòng quản lý để nhận tiền cọc. Mang theo CCCD hoặc thẻ sinh viên.
                    </div>
                </div>
            @endif
        @elseif($hoadon->trang_thai === \App\Enums\InvoiceStatus::Paid)
            <div class="saas-card p-5">
                <div class="font-semibold text-slate-900">Hóa đơn đã được thanh toán</div>
                <div class="mt-0.5 text-sm text-slate-500">Ngày thanh toán: {{ $hoadon->ngay_thanh_toan?->format('d/m/Y') ?? 'N/A' }}</div>
            </div>
        @elseif($hoadon->trang_thai === \App\Enums\InvoiceStatus::PendingConfirmation)
            <div class="saas-card p-5">
                <div class="font-semibold text-slate-900">Đang chờ Ban quản lý xác nhận thanh toán</div>
                <div class="mt-0.5 text-sm text-slate-500">Vui lòng chờ đối soát và cập nhật trạng thái hóa đơn.</div>
            </div>
        @else
            <div class="saas-card p-5">
                <div class="font-semibold text-slate-900">
                    {{ $hoadon->trang_thai === \App\Enums\InvoiceStatus::Overdue ? 'Hóa đơn đã quá hạn' : 'Hóa đơn chưa thanh toán' }}
                </div>
                <div class="mt-0.5 text-sm text-slate-500">
                    Hạn thanh toán: {{ $hoadon->ngay_het_han?->format('d/m/Y') ?? 'N/A' }}
                </div>
                @if($hoadon->trang_thai === \App\Enums\InvoiceStatus::Overdue)
                    <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                        Hóa đơn quá hạn sẽ được hệ thống nhắc định kỳ. Vui lòng chuyển khoản để tránh phát sinh công nợ.
                    </div>
                @endif
            </div>
        @endif
    </div>

    @if(!empty($thongBaoNhacNo) && count($thongBaoNhacNo) > 0)
        @php
            $nhacNoMoiNhat = $thongBaoNhacNo[0] ?? null;
        @endphp
        @if($nhacNoMoiNhat)
            <div class="mb-6 saas-card p-5">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="font-semibold text-slate-900">Nhắc nợ từ Ban quản lý</div>
                        <div class="mt-0.5 text-sm text-slate-500">
                            {{ $nhacNoMoiNhat->created_at?->format('d/m/Y H:i') ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="text-sm text-slate-600">
                        {{ $nhacNoMoiNhat->noi_dung }}
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if(!$isRefund && in_array($hoadon->trang_thai, [\App\Enums\InvoiceStatus::Unpaid, \App\Enums\InvoiceStatus::Overdue], true))
        <div id="huong-dan-thanh-toan" class="mb-6 saas-card p-6" x-data="{ copied: null, async copy(key, text) { try { await navigator.clipboard.writeText(text); this.copied = key; setTimeout(() => this.copied = null, 1200); } catch (e) { this.copied = null; } } }">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <div class="text-base font-semibold text-slate-900">Hướng dẫn thanh toán</div>
                    <div class="mt-1 text-sm text-slate-500">Chuyển khoản đúng nội dung để Ban quản lý đối soát nhanh hơn.</div>
                </div>
                <div class="text-right">
                    <div class="text-xs font-semibold text-slate-500">Số tiền cần thanh toán</div>
                    <div class="text-xl font-semibold text-slate-900 tabular-nums">{{ number_format((int) ($thanhToan['so_tien'] ?? $hoadon->tong_tien)) }} đ</div>
                </div>
            </div>

            @php
                $bankName = (string) ($thanhToan['ngan_hang'] ?? 'VietinBank');
                $accountNo = (string) ($thanhToan['so_tai_khoan'] ?? '123456789');
                $accountName = (string) ($thanhToan['chu_tai_khoan'] ?? 'BAN QUAN LY KTX');
                $transferContent = (string) ($thanhToan['noi_dung_ck'] ?? ('HD ' . $maHoaDon));
            @endphp

            <div class="mt-5 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-slate-200/60 bg-slate-50 p-4">
                    <div class="saas-label !mb-0">Ngân hàng</div>
                    <div class="mt-1 font-semibold text-slate-900">{{ $bankName }}</div>
                </div>
                <div class="rounded-lg border border-slate-200/60 bg-slate-50 p-4">
                    <div class="saas-label !mb-0">Số tài khoản</div>
                    <div class="mt-1 flex items-start justify-between gap-3">
                        <div>
                            <div class="font-semibold text-slate-900 tabular-nums">{{ $accountNo }}</div>
                            <div class="mt-0.5 text-xs text-slate-500">{{ $accountName }}</div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="saas-btn-secondary h-9 px-3 text-xs font-semibold" @click="copy('stk', @js($accountNo))">
                                Sao chép
                            </button>
                            <div class="mt-1 text-[11px] text-slate-500" x-show="copied === 'stk'">Đã sao chép</div>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200/60 bg-slate-50 p-4">
                    <div class="saas-label !mb-0">Nội dung chuyển khoản</div>
                    <div class="mt-1 flex items-start justify-between gap-3">
                        <div class="font-semibold text-slate-900 break-all">{{ $transferContent }}</div>
                        <div class="text-right shrink-0">
                            <button type="button" class="saas-btn-secondary h-9 px-3 text-xs font-semibold" @click="copy('ndck', @js($transferContent))">
                                Sao chép
                            </button>
                            <div class="mt-1 text-[11px] text-slate-500" x-show="copied === 'ndck'">Đã sao chép</div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('student.phongcuatoi.hoadon.yeu_cau_xac_nhan', $hoadon->id) }}" class="mt-6 rounded-lg border border-slate-200/60 bg-slate-50 p-4">
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="saas-label" for="ma_giao_dich">Mã giao dịch (nếu có)</label>
                        <input id="ma_giao_dich" name="ma_giao_dich" type="text" class="saas-input" placeholder="Ví dụ: FT123456789 / 4 số cuối">
                    </div>
                    <div>
                        <label class="saas-label" for="ghi_chu">Ghi chú</label>
                        <input id="ghi_chu" name="ghi_chu" type="text" class="saas-input" placeholder="Ví dụ: chuyển khoản lúc 20:15 ngày 04/05">
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-xs text-slate-500">
                        @if(!empty($thanhToan['so_dien_thoai_lien_he']))
                            Hotline: <span class="font-semibold text-slate-900">{{ $thanhToan['so_dien_thoai_lien_he'] }}</span>
                        @endif
                        @if(!empty($thanhToan['email_lien_he']))
                            @if(!empty($thanhToan['so_dien_thoai_lien_he'])) • @endif
                            Email: <span class="font-semibold text-slate-900">{{ $thanhToan['email_lien_he'] }}</span>
                        @endif
                    </div>
                    <button type="submit" class="saas-btn-primary h-10 px-4 text-sm font-semibold" data-loading-text="Đang ghi nhận...">
                        Tôi đã chuyển khoản
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="mb-6 saas-card p-6">
        @php
            $kyApDung = ($ky['thang'] ?? null) && ($ky['nam'] ?? null) ? ((int) $ky['thang']) . '/' . ((int) $ky['nam']) : $kyHienThi;

            $dienText = '';
            if (!empty($chiSoTieuThu['dien'])) {
                $dienText = (int) $chiSoTieuThu['dien']['chi_so_cu'] . ' → ' . (int) $chiSoTieuThu['dien']['chi_so_moi'] . ' ' . ($chiSoTieuThu['dien']['don_vi'] ?? 'kWh')
                    . ' (tiêu thụ: ' . (int) $chiSoTieuThu['dien']['tieu_thu'] . ' ' . ($chiSoTieuThu['dien']['don_vi'] ?? 'kWh') . ')';
            }

            $nuocText = '';
            if (!empty($chiSoTieuThu['nuoc'])) {
                $nuocText = (int) $chiSoTieuThu['nuoc']['chi_so_cu'] . ' → ' . (int) $chiSoTieuThu['nuoc']['chi_so_moi'] . ' ' . ($chiSoTieuThu['nuoc']['don_vi'] ?? 'm³')
                    . ' (tiêu thụ: ' . (int) $chiSoTieuThu['nuoc']['tieu_thu'] . ' ' . ($chiSoTieuThu['nuoc']['don_vi'] ?? 'm³') . ')';
            }

            $loaiHoaDon = (string) ($hoadon->loai_hoadon ?? '');
            $isDeposit = $loaiHoaDon === 'deposit';
            $isExtra = $loaiHoaDon === 'extra';

            if ($isRefund || $isDeposit || $isExtra) {
                $items = [[
                    'ten' => $isRefund ? 'Hoàn cọc' : ($isDeposit ? 'Tiền cọc' : 'Phát sinh'),
                    'so_tien' => (int) ($hoadon->tong_tien ?? 0),
                    'don_vi' => 'VNĐ',
                    'thoi_gian' => $hoadon->created_at?->format('d/m/Y') ?? '-',
                    'mo_ta' => (string) ($hoadon->ghi_chu ?? ''),
                ]];
            } else {
                $items = [
                    [
                        'ten' => 'Tiền phòng',
                        'so_tien' => (int) ($hoadon->tien_phong ?? 0),
                        'don_vi' => 'VNĐ/tháng',
                        'thoi_gian' => $kyApDung,
                        'mo_ta' => 'Phí phòng ' . $tenPhong . '.',
                    ],
                    [
                        'ten' => 'Tiền điện',
                        'so_tien' => (int) ($hoadon->tien_dien ?? 0),
                        'don_vi' => 'VNĐ',
                        'thoi_gian' => $kyApDung,
                        'mo_ta' => $dienText !== '' ? ('Chỉ số: ' . $dienText . '.') : 'Chưa có chỉ số điện ghi nhận cho kỳ này.',
                    ],
                    [
                        'ten' => 'Tiền nước',
                        'so_tien' => (int) ($hoadon->tien_nuoc ?? 0),
                        'don_vi' => 'VNĐ',
                        'thoi_gian' => $kyApDung,
                        'mo_ta' => $nuocText !== '' ? ('Chỉ số: ' . $nuocText . '.') : 'Chưa có chỉ số nước ghi nhận cho kỳ này.',
                    ],
                    [
                        'ten' => 'Phí dịch vụ',
                        'so_tien' => (int) ($hoadon->phi_dich_vu ?? 0),
                        'don_vi' => 'VNĐ/tháng',
                        'thoi_gian' => $kyApDung,
                        'mo_ta' => 'Phí dịch vụ vận hành KTX.',
                    ],
                ];

                $items = array_values(array_filter($items, fn($x) => (int) ($x['so_tien'] ?? 0) > 0));
            }
        @endphp

        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h3 class="font-semibold text-slate-900">Chi tiết các khoản phí</h3>
                <div class="mt-0.5 text-xs text-slate-500">Kỳ áp dụng: {{ $kyApDung }}</div>
            </div>
            <div class="text-right">
                <div class="text-xs font-semibold text-slate-500">Tổng tiền</div>
                <div class="text-xl font-semibold text-slate-900 tabular-nums">{{ number_format((int) $hoadon->tong_tien) }} đ</div>
            </div>
        </div>

        @if(count($items) === 0)
            <div class="mt-5 rounded-lg border border-slate-200/60 bg-slate-50 p-4 text-sm text-slate-600">
                Không có khoản phí nào để hiển thị.
            </div>
        @else
            <div class="mt-5 overflow-hidden rounded-xl border border-slate-200/60">
                <div class="hidden md:grid grid-cols-12 gap-0 bg-slate-50 px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <div class="col-span-4">Khoản phí</div>
                    <div class="col-span-2 text-right">Số tiền</div>
                    <div class="col-span-2">Đơn vị</div>
                    <div class="col-span-2">Thời gian</div>
                    <div class="col-span-2">Mô tả</div>
                </div>
                <div class="divide-y divide-slate-200/60 bg-white">
                    @foreach($items as $row)
                        <div class="grid grid-cols-1 gap-2 px-4 py-4 md:grid-cols-12 md:items-start md:gap-0">
                            <div class="md:col-span-4">
                                <div class="font-semibold text-slate-900">{{ $row['ten'] }}</div>
                            </div>
                            <div class="md:col-span-2 md:text-right">
                                <div class="font-semibold text-slate-900 tabular-nums">{{ number_format((int) $row['so_tien']) }} đ</div>
                                @if(!$isRefund && !$isDeposit && !$isExtra && (int) $soNguoiTrongPhong > 1)
                                    <div class="mt-0.5 text-[11px] text-slate-500">≈ {{ number_format((int) round(((int) $row['so_tien']) / max(1, (int) $soNguoiTrongPhong))) }} đ/người</div>
                                @endif
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-[11px] font-semibold text-slate-900">{{ $row['don_vi'] }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-[11px] font-semibold text-slate-900">{{ $row['thoi_gian'] }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-[11px] text-slate-600 leading-relaxed">{{ $row['mo_ta'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @if($hoadon->ghi_chu)
        <div class="saas-card p-5">
            <div class="flex items-start gap-2">
                <svg class="mt-0.5 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <div>
                    <p class="font-semibold text-slate-900">Ghi chú</p>
                    <p class="text-sm text-slate-600">{{ $hoadon->ghi_chu }}</p>
                </div>
            </div>
        </div>
    @endif
@endsection
