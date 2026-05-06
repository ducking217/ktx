@extends('student.layouts.chinh')

@section('student_page_title', 'Hóa đơn của em')

@section('noidung')
<div class="space-y-8">
    <x-admin.page-header
        title="Hóa đơn dịch vụ"
        subtitle="Theo dõi và thanh toán các khoản phí định kỳ."
    >
    </x-admin.page-header>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <article class="saas-card p-6 border-slate-200">
            <div class="flex items-center gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-500 border border-slate-200">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tổng hóa đơn</div>
                    <div class="text-xl font-bold text-slate-900 tabular-nums leading-none mt-1">{{ $hoadon->count() }}</div>
                </div>
            </div>
        </article>
        <article class="saas-card p-6 border-slate-200">
            <div class="flex items-center gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 border border-rose-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Chưa thanh toán</div>
                    <div class="text-xl font-bold text-rose-600 tabular-nums leading-none mt-1">{{ $hoadon->where('trang_thai', \App\Enums\InvoiceStatus::Unpaid)->count() }}</div>
                </div>
            </div>
        </article>
        <article class="saas-card p-6 border-slate-200 md:col-span-2">
            <div class="flex items-center gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08-.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tổng dư nợ</div>
                    <div class="text-xl font-bold text-slate-900 tabular-nums leading-none mt-1">{{ number_format($hoadon->where('trang_thai', \App\Enums\InvoiceStatus::Unpaid)->sum('tong_tien')) }}đ</div>
                </div>
            </div>
        </article>
    </div>

    <!-- Main List -->
    <x-admin.table-card>
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Nội dung</th>
                <th class="text-right">Tổng tiền</th>
                <th class="text-center">Ngày tạo</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-right">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hoadon as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4">
                        <span class="text-xs font-bold text-slate-900 tabular-nums uppercase tracking-wider">#{{ $item->id }}</span>
                    </td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-500/20">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-900">Hóa đơn điện nước</span>
                        </div>
                    </td>
                    <td class="py-4 text-right">
                        <span class="text-sm font-bold text-slate-900 tabular-nums">{{ number_format($item->tong_tien) }}đ</span>
                    </td>
                    <td class="py-4 text-center">
                        <span class="text-xs font-bold text-slate-500 tabular-nums uppercase tracking-widest">{{ $item->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="py-4 text-center">
                        @php
                            $invoiceType = (string) ($item->loai_hoadon ?? '');
                            $trangThai = $item->trang_thai;
                            $isPaid = $trangThai === \App\Enums\InvoiceStatus::Paid;
                            $isPending = $trangThai === \App\Enums\InvoiceStatus::PendingConfirmation;

                            $badgeClass = $trangThai->badgeClass($invoiceType);
                        @endphp
                        <span class="saas-badge {{ $badgeClass }}">
                            @if(!$isPaid && !$isPending)
                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current animate-pulse"></span>
                            @endif
                            {{ $trangThai->displayLabel($invoiceType) }}
                        </span>
                    </td>
                    <td class="py-4 text-right">
                        <button type="button" data-modal-target="modal-bienlai-{{ $item->id }}" data-modal-toggle="modal-bienlai-{{ $item->id }}" class="h-9 w-9 inline-flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all shadow-sm hover:shadow-md" title="Chi tiết">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-24 text-center">
                        <div class="flex flex-col items-center gap-4 text-slate-200">
                            <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Chưa có hóa đơn nào</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-admin.table-card>
    
    @if(method_exists($hoadon, 'links') && $hoadon->hasPages())
        <div class="mt-8">
            {{ $hoadon->links() }}
        </div>
    @endif

    {{-- Modals Redesign --}}
    @foreach ($hoadon as $item)
        @php
            $chiTiet = is_array($item->chi_tiet) ? $item->chi_tiet : json_decode($item->chi_tiet, true);
            $phong = $item->hopdong?->giuong?->phong;
        @endphp
        <div id="modal-bienlai-{{ $item->id }}" tabindex="-1" aria-hidden="true" 
             class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl bg-white p-8 shadow-xl border border-slate-200">
                <div class="mb-8 flex items-start justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3">
                            Biên lai điện tử • {{ $chiTiet['thang'] ?? 'Chưa có' }}/{{ $chiTiet['nam'] ?? 'Chưa có' }}
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 tracking-tight uppercase">Thông tin Thanh toán</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Mã tra soát: #INV-{{ str_pad((string)$item->id, 8, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors" 
                            data-modal-hide="modal-bienlai-{{ $item->id }}">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-8">
                    <div class="md:col-span-7 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Phòng ở</span>
                                <div class="font-bold text-slate-900 text-sm">{{ $phong?->ten_phong ?? 'Chưa có' }}</div>
                            </div>
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Loại phòng</span>
                                <div class="font-bold text-slate-900 text-sm">{{ $phong?->loaiphong?->ten_loai ?? 'Tiêu chuẩn' }}</div>
                            </div>
                        </div>

                        <div class="rounded-xl bg-slate-50 border border-slate-100 p-6 space-y-4">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-500 uppercase tracking-widest">Cố định phòng</span>
                                <span class="font-bold text-slate-900 tabular-nums">{{ number_format($chiTiet['tien_phong'] ?? 0) }}đ</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-500 uppercase tracking-widest">Tiêu thụ Điện</span>
                                <span class="font-bold text-slate-900 tabular-nums">{{ number_format($chiTiet['tien_dien'] ?? 0) }}đ</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-500 uppercase tracking-widest">Tiêu thụ Nước</span>
                                <span class="font-bold text-slate-900 tabular-nums">{{ number_format($chiTiet['tien_nuoc'] ?? 0) }}đ</span>
                            </div>
                            <div class="pt-4 mt-2 border-t border-slate-200 flex justify-between items-end">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tổng cộng</span>
                                <span class="text-2xl font-bold text-blue-600 tabular-nums tracking-tight">{{ number_format($item->tong_tien) }}đ</span>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 flex flex-col items-center justify-center p-6 rounded-xl bg-white border border-slate-200 shadow-sm">
                        @php
                            $phongTen = $phong?->ten_phong ?? 'Chưa có';
                            $qrText = 'KTX - ' . $phongTen . ' - ' . ($chiTiet['thang'] ?? 'Chưa có') . '/' . ($chiTiet['nam'] ?? 'Chưa có') . ' - ' . number_format($item->tong_tien) . 'd';
                            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($qrText);
                        @endphp
                        <img src="{{ $qrUrl }}" alt="QR" class="h-32 w-32 object-contain rounded-lg" />
                        <div class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Quét mã thanh toán<br/>(QR chuyển khoản)</div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button class="flex-1 saas-btn-secondary h-12">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Tải hóa đơn (PDF)
                    </button>
                    <button class="flex-1 saas-btn-primary h-12 shadow-lg shadow-blue-500/20">
                        Xác nhận đã chuyển
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
