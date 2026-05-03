<x-admin-layout>
    <x-slot:title>Quản lý Hóa đơn & Công nợ</x-slot:title>

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-display font-black tracking-tight text-ink-primary uppercase">Hóa đơn & Công nợ</h1>
            <p class="mt-1 text-sm font-medium text-ink-secondary italic">Quản lý dòng tiền, chỉ số điện nước và trạng thái thanh toán.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.hoadon.nhap_hang_loat') }}" class="pdu-btn-ghost group">
                <svg class="mr-2 h-4 w-4 text-ink-secondary group-hover:text-brand-emerald" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Nhập hàng loạt
            </a>
            <button type="button" data-modal-target="modal-xulyhoadon" data-modal-toggle="modal-xulyhoadon" class="pdu-btn-primary">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Ghi chỉ số mới
            </button>
        </div>
    </div>

    <!-- Filters & Stats -->
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="pdu-card flex flex-col justify-between py-4">
            <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Tổng công nợ</div>
            <div class="mt-2 text-2xl font-display font-black tracking-tighter tabular-nums">{{ number_format($thongke['tong_no'] ?? 0) }}đ</div>
        </div>
        <div class="pdu-card flex flex-col justify-between py-4 border-l-4 border-l-status-error">
            <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Quá hạn</div>
            <div class="mt-2 text-2xl font-display font-black tracking-tighter tabular-nums text-status-error">{{ $thongke['so_qua_han'] ?? 0 }} phiếu</div>
        </div>
        <div class="pdu-card flex flex-col justify-between py-4 border-l-4 border-l-status-warning">
            <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Chờ thanh toán</div>
            <div class="mt-2 text-2xl font-display font-black tracking-tighter tabular-nums text-status-warning">{{ $thongke['so_cho_duyet'] ?? 0 }} phiếu</div>
        </div>
        <div class="pdu-card flex flex-col justify-between py-4 border-l-4 border-l-status-success">
            <div class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Đã thu tháng này</div>
            <div class="mt-2 text-2xl font-display font-black tracking-tighter tabular-nums text-status-success">{{ number_format($thongke['da_thu_thang'] ?? 0) }}đ</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pdu-card overflow-hidden !p-0 shadow-xl shadow-ink-primary/5">
        {{-- Desktop View --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-ui-bg text-[10px] font-bold uppercase tracking-widest text-ink-secondary border-b border-ui-border">
                    <tr>
                        <th class="px-6 py-4">Mã / Kỳ hạn</th>
                        <th class="px-6 py-4">Đối tượng / Phòng</th>
                        <th class="px-6 py-4 text-right">Tổng tiền</th>
                        <th class="px-6 py-4 text-center">Trạng thái</th>
                        <th class="px-6 py-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ui-border">
                    @forelse ($danhsachhoadon as $hoadon)
                        <tr class="group hover:bg-ui-bg/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-ink-primary tabular-nums">#{{ $hoadon->id }}</div>
                                <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-tighter">Kỳ T{{ $hoadon->thang }}/{{ $hoadon->nam }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-ink-primary font-display">{{ $hoadon->sinhvien?->taikhoan?->name ?? 'N/A' }}</div>
                                <div class="flex items-center gap-1.5 text-[10px] font-bold text-ink-secondary/60 uppercase tracking-widest mt-0.5">
                                    <span class="h-1 w-1 rounded-full bg-brand-emerald"></span>
                                    {{ $hoadon->phong?->tenphong ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="font-display font-black text-ink-primary tabular-nums">{{ number_format($hoadon->tongtien) }}đ</div>
                                <div class="text-[9px] font-bold text-ink-secondary/30 uppercase italic">{{ $hoadon->loai_hoadon === 'monthly' ? 'Hàng tháng' : 'Phát sinh' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $status = $hoadon->trangthaithanhtoan;
                                    $class = match($status) {
                                        \App\Enums\InvoiceStatus::Paid => 'bg-status-success/10 text-status-success ring-status-success/20',
                                        \App\Enums\InvoiceStatus::Overdue => 'bg-status-error/10 text-status-error ring-status-error/20',
                                        default => 'bg-status-warning/10 text-status-warning ring-status-warning/20',
                                    };
                                @endphp
                                <span class="inline-flex rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest ring-1 {{ $class }}">
                                    {{ $status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.hoadon.pdf', $hoadon->id) }}" class="h-9 w-9 rounded-xl bg-ui-bg flex items-center justify-center text-ink-secondary border border-ui-border hover:bg-white hover:text-brand-emerald hover:border-brand-emerald/30 transition-all active:scale-95 shadow-sm" title="Tải PDF">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </a>
                                    
                                    @if ($hoadon->trangthaithanhtoan !== \App\Enums\InvoiceStatus::Paid)
                                        <form action="{{ route('admin.xacnhanthanhtoan', $hoadon->id) }}" method="POST" onsubmit="return confirm('Xác nhận sinh viên đã đóng tiền?')">
                                            @csrf
                                            <button type="submit" class="h-9 w-9 rounded-xl bg-ink-primary flex items-center justify-center text-white hover:bg-brand-emerald transition-all active:scale-95 shadow-lg shadow-ink-primary/10">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center">
                                <div class="text-lg font-display font-black text-ink-secondary/20 uppercase italic tracking-widest">Không có dữ liệu hóa đơn</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="md:hidden divide-y divide-ui-border">
            @forelse ($danhsachhoadon as $hoadon)
                <div class="p-5 space-y-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="font-bold text-ink-primary tabular-nums">#{{ $hoadon->id }}</div>
                            <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-tighter">Tháng {{ $hoadon->thang }}/{{ $hoadon->nam }}</div>
                        </div>
                        @php
                            $status = $hoadon->trangthaithanhtoan;
                            $class = match($status) {
                                \App\Enums\InvoiceStatus::Paid => 'bg-status-success/10 text-status-success ring-status-success/20',
                                \App\Enums\InvoiceStatus::Overdue => 'bg-status-error/10 text-status-error ring-status-error/20',
                                default => 'bg-status-warning/10 text-status-warning ring-status-warning/20',
                            };
                        @endphp
                        <span class="inline-flex rounded-lg px-2 py-0.5 text-[8px] font-black uppercase tracking-widest ring-1 {{ $class }}">
                            {{ $status->label() }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 rounded-xl bg-ui-bg/30 p-4 ring-1 ring-inset ring-ui-border">
                        <div class="space-y-1">
                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Cư dân</div>
                            <div class="text-xs font-bold text-ink-primary truncate font-display">{{ $hoadon->sinhvien?->taikhoan?->name ?? 'N/A' }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Vị trí</div>
                            <div class="text-xs font-bold text-ink-primary">{{ $hoadon->phong?->tenphong ?? 'N/A' }}</div>
                        </div>
                        <div class="space-y-1 col-span-2">
                            <div class="text-[8px] font-bold text-ink-secondary/40 uppercase tracking-widest">Tổng quyết toán</div>
                            <div class="text-lg font-display font-black text-ink-primary tabular-nums">{{ number_format($hoadon->tongtien) }}đ</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.hoadon.pdf', $hoadon->id) }}" class="flex-1 flex h-10 items-center justify-center gap-2 rounded-xl bg-ui-bg text-[10px] font-bold uppercase tracking-widest text-ink-secondary ring-1 ring-ui-border">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Tải PDF
                        </a>
                        @if ($hoadon->trangthaithanhtoan !== \App\Enums\InvoiceStatus::Paid)
                            <form action="{{ route('admin.xacnhanthanhtoan', $hoadon->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full h-10 rounded-xl bg-ink-primary text-[10px] font-bold uppercase tracking-widest text-white shadow-lg shadow-ink-primary/10">Xác nhận</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-20 text-center text-ink-secondary/20 uppercase font-black text-[10px] tracking-widest">Không có dữ liệu hóa đơn</div>
            @endforelse
        </div>
    </div>

    @push('modals')
        <x-modal id="modal-nhaphangloat" title="Nhập chỉ số hàng loạt" subtitle="Điền chỉ số mới cho tất cả các phòng trong cùng một bảng để kết xuất hóa đơn nhanh chóng.">
            <form method="POST" action="{{ route('admin.hoadon.bulk') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Kỳ quyết toán (Tháng)</label>
                        <input name="thang" type="number" value="{{ now()->format('m') }}" class="linear-input mt-1.5 font-bold tabular-nums" required />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Năm vận hành</label>
                        <input name="nam" type="number" value="{{ now()->format('Y') }}" class="linear-input mt-1.5 font-bold tabular-nums" required />
                    </div>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-ui-border max-h-[400px]">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-ui-bg sticky top-0 z-10 text-[10px] font-bold uppercase tracking-widest text-ink-secondary border-b border-ui-border">
                            <tr>
                                <th class="px-4 py-3">Phòng</th>
                                <th class="px-4 py-3">Điện cũ → Mới</th>
                                <th class="px-4 py-3">Nước cũ → Mới</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ui-border">
                            @foreach ($danhsachphong as $phong)
                                <tr>
                                    <td class="px-4 py-3 font-bold text-ink-primary">{{ $phong->tenphong }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="hoa_don[{{ $phong->id }}][chisodiencu]" value="0" class="w-16 rounded-lg border-ui-border bg-ui-bg/50 px-2 py-1 text-[11px] tabular-nums" placeholder="Cũ" />
                                            <svg class="h-3 w-3 text-ink-secondary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            <input type="number" name="hoa_don[{{ $phong->id }}][chisodienmoi]" class="w-16 rounded-lg border-ui-border px-2 py-1 text-[11px] font-bold tabular-nums" placeholder="Mới" required />
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="hoa_don[{{ $phong->id }}][chisonuoccu]" value="0" class="w-16 rounded-lg border-ui-border bg-ui-bg/50 px-2 py-1 text-[11px] tabular-nums" placeholder="Cũ" />
                                            <svg class="h-3 w-3 text-ink-secondary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            <input type="number" name="hoa_don[{{ $phong->id }}][chisonuocmoi]" class="w-16 rounded-lg border-ui-border px-2 py-1 text-[11px] font-bold tabular-nums" placeholder="Mới" required />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-nhaphangloat" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Khởi tạo hàng loạt</button>
                </div>
            </form>
        </x-modal>

        <x-modal id="modal-xulyhoadon" title="Kê khai chỉ số tiện ích" subtitle="Nhập chỉ số điện nước mới nhất để hệ thống tự động kết xuất hóa đơn tháng.">
            <form method="POST" action="{{ route('admin.xulyhoadon') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Phòng cư trú chỉ định</label>
                    <select name="phong_id" class="linear-select mt-1.5 font-bold" required>
                        <option value="">-- Chọn phòng kết xuất --</option>
                        @foreach ($danhsachphong as $phong)
                            <option value="{{ $phong->id }}">{{ $phong->tenphong }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Kỳ quyết toán (Tháng)</label>
                        <input name="thang" type="number" value="{{ old('thang', now()->format('m')) }}" class="linear-input mt-1.5 font-bold tabular-nums" required />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/50">Năm vận hành</label>
                        <input name="nam" type="number" value="{{ old('nam', now()->format('Y')) }}" class="linear-input mt-1.5 font-bold tabular-nums" required />
                    </div>
                </div>

                <div class="space-y-4 rounded-2xl bg-ui-bg/50 p-6 ring-1 ring-inset ring-ui-border">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Điện Cũ</label>
                            <input name="chisodiencu" type="number" value="{{ old('chisodiencu', 0) }}" class="linear-input !bg-white tabular-nums" required />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Điện Mới</label>
                            <input name="chisodienmoi" type="number" value="{{ old('chisodienmoi', 0) }}" class="linear-input !bg-white font-bold text-ink-primary tabular-nums" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Nước Cũ</label>
                            <input name="chisonuoccu" type="number" value="{{ old('chisonuoccu', 0) }}" class="linear-input !bg-white tabular-nums" required />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-ink-secondary/60">Chỉ số Nước Mới</label>
                            <input name="chisonuocmoi" type="number" value="{{ old('chisonuocmoi', 0) }}" class="linear-input !bg-white font-bold text-ink-primary tabular-nums" required />
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" data-modal-hide="modal-xulyhoadon" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Hủy bỏ</button>
                    <button type="submit" class="flex-[2] rounded-xl bg-ink-primary py-3 text-sm font-bold text-white shadow-lg shadow-ink-primary/20 transition-all hover:bg-brand-emerald">Khởi tạo hóa đơn</button>
                </div>
            </form>
        </x-modal>

        @foreach ($danhsachhoadon as $hoadon)
            <x-modal id="modal-chitiethoadon-{{ $hoadon->id }}" title="Chi tiết quyết toán" subtitle="Bản tóm tắt các khoản chi phí tiện ích cho phòng {{ $mapphong[$hoadon->phong_id]->tenphong ?? 'N/A' }} kỳ {{ $hoadon->thang }}/{{ $hoadon->nam }}.">
                <div class="space-y-6">
                    <div class="divide-y divide-ui-border rounded-2xl bg-ui-bg/50 p-6 ring-1 ring-inset ring-ui-border">
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-bold text-ink-secondary">Tiền phòng cơ bản</span>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format(optional($mapphong[$hoadon->phong_id])->giaphong ?? 0) }}đ</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-ink-secondary">Tiền điện tiêu thụ</span>
                                <span class="text-[10px] font-medium text-ink-secondary/40 tabular-nums">({{ $hoadon->chisodiencu }} → {{ $hoadon->chisodienmoi }} kWh)</span>
                            </div>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format(($hoadon->chisodienmoi - $hoadon->chisodiencu) * $dongiadien) }}đ</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-ink-secondary">Lưu lượng nước</span>
                                <span class="text-[10px] font-medium text-ink-secondary/40 tabular-nums">({{ $hoadon->chisonuoccu }} → {{ $hoadon->chisonuocmoi }} m³)</span>
                            </div>
                            <span class="text-sm font-bold text-ink-primary tabular-nums">{{ number_format(($hoadon->chisonuocmoi - $hoadon->chisonuoccu) * $dongianuoc) }}đ</span>
                        </div>
                        <div class="flex items-center justify-between py-5">
                            <span class="text-base font-bold text-ink-primary uppercase tracking-tight font-display">Tổng quyết toán</span>
                            <span class="text-2xl font-bold text-ink-primary font-display tabular-nums">{{ number_format($hoadon->tongtien) }}đ</span>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.hoadon.pdf', $hoadon->id) }}" class="flex-1 flex items-center justify-center gap-2 rounded-xl bg-brand-emerald py-3 text-sm font-bold text-white shadow-lg shadow-brand-emerald/20 transition-all hover:bg-brand-emerald/90">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Tải bản in PDF
                        </a>
                        <button type="button" data-modal-hide="modal-chitiethoadon-{{ $hoadon->id }}" class="flex-1 rounded-xl bg-ui-bg py-3 text-sm font-bold text-ink-primary ring-1 ring-ui-border transition-colors hover:bg-white">Đóng bản tóm tắt</button>
                    </div>
                </div>
            </x-modal>
        @endforeach
    @endpush
</x-admin-layout>
