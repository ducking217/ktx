@extends('student.layouts.chinh')

@section('student_page_title', 'Gia hạn hợp đồng')

@section('noidung')
    <div class="space-y-8 animate-fade-up">
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-ink-primary uppercase tracking-tight">Yêu cầu đã gửi</h2>
                <p class="text-[10px] font-bold text-ink-secondary/50 uppercase tracking-widest mt-1">Quản lý lịch sử gia hạn hợp đồng nội trú</p>
            </div>
            <a href="{{ route('student.giahan.tao') }}" class="pdu-btn-primary shadow-lg shadow-brand-emerald/20 !px-6">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tạo yêu cầu mới
            </a>
        </header>

        <article class="pdu-card !p-0 overflow-hidden shadow-xl shadow-ink-primary/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-ui-bg/50 border-b border-ui-border">
                            <th class="px-6 py-4 text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">Hợp đồng</th>
                            <th class="px-6 py-4 text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">Ngày mong muốn</th>
                            <th class="px-6 py-4 text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">Lý do</th>
                            <th class="px-6 py-4 text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">Trạng thái</th>
                            <th class="px-6 py-4 text-[10px] font-black text-ink-secondary/40 uppercase tracking-[0.2em]">Ghi chú Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ui-border">
                        @forelse ($yeuCauGiaHan as $item)
                            <tr class="group hover:bg-ui-bg/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="font-display font-black text-ink-primary tracking-tight">{{ $item->hopdong->ma_hd }}</div>
                                    <div class="text-[10px] font-bold text-ink-secondary/40 uppercase tracking-widest">{{ $item->hopdong->phong->tenphong }}</div>
                                </td>
                                <td class="px-6 py-5 font-bold text-ink-primary tabular-nums tracking-tight">
                                    {{ $item->ngay_ket_thuc_moi->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-xs text-ink-secondary/80 max-w-xs truncate" title="{{ $item->ly_do }}">
                                        {{ $item->ly_do ?: 'Không có lý do' }}
                                    </p>
                                </td>
                                <td class="px-6 py-5">
                                    <span @class([
                                        'inline-flex items-center rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-widest ring-1',
                                        'bg-status-warning/10 text-status-warning ring-status-warning/20' => $item->trang_thai->value === 'pending',
                                        'bg-status-success/10 text-status-success ring-status-success/20' => $item->trang_thai->value === 'approved',
                                        'bg-status-error/10 text-status-error ring-status-error/20' => $item->trang_thai->value === 'rejected',
                                    ])>
                                        {{ $item->trang_thai->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs italic text-ink-secondary/60">{{ $item->ghi_chu_admin ?: '—' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-32 text-center">
                                    <div class="flex flex-col items-center justify-center text-ink-secondary/20">
                                        <svg class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-[10px] font-black uppercase tracking-widest italic">Bạn chưa gửi yêu cầu gia hạn nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($yeuCauGiaHan->hasPages())
                <div class="px-6 py-4 bg-ui-bg/30 border-t border-ui-border">
                    {{ $yeuCauGiaHan->links() }}
                </div>
            @endif
        </article>
    </div>
@endsection
