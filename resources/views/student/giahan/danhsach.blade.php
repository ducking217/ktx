@extends('student.layouts.chinh')

@section('student_page_title', 'Gia hạn hợp đồng')

@section('noidung')
    <div class="space-y-8">
        <x-admin.page-header
            title="Gia hạn hợp đồng"
            subtitle="Lịch sử yêu cầu gia hạn thời gian lưu trú."
        >
            <a href="{{ route('student.giahan.tao') }}" class="saas-btn-primary h-11 px-6 shadow-lg shadow-blue-500/20">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Gửi yêu cầu mới
            </a>
        </x-admin.page-header>

        <!-- Data Table -->
        <x-admin.table-card>
            <thead>
                <tr>
                    <th>Hợp đồng</th>
                    <th class="text-center">Ngày mong muốn</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Lý do</th>
                    <th class="text-right">Ghi chú từ BQL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($yeuCauGiaHan as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4">
                            <div class="text-sm font-bold text-slate-900 uppercase tracking-tight">{{ $item->hopdong->ma_hd }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $item->hopdong->phong->tenphong ?? 'N/A' }}</div>
                        </td>
                        <td class="py-4 text-center">
                            <span class="text-xs font-bold text-slate-600 tabular-nums bg-slate-100 px-2 py-1 rounded-lg uppercase tracking-widest">{{ $item->ngay_ket_thuc_moi->format('d/m/Y') }}</span>
                        </td>
                        <td class="py-4 text-center">
                            @php
                                $status = $item->trang_thai->value;
                                $badgeClass = match($status) {
                                    'pending' => 'saas-badge-warning',
                                    'approved' => 'saas-badge-success',
                                    'rejected' => 'saas-badge-error',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <span class="saas-badge {{ $badgeClass }}">
                                @if($status === 'pending')
                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current animate-pulse"></span>
                                @endif
                                {{ $item->trang_thai->label() }}
                            </span>
                        </td>
                        <td class="py-4">
                            <p class="text-xs font-medium text-slate-700 line-clamp-1" title="{{ $item->ly_do }}">{{ $item->ly_do ?: 'Không có lý do' }}</p>
                        </td>
                        <td class="py-4 text-right">
                            <p class="text-xs font-medium text-slate-500 italic">{{ $item->ghi_chu_admin ?: '—' }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center gap-4 text-slate-200">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Chưa có yêu cầu gia hạn nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-admin.table-card>
        
        @if($yeuCauGiaHan->hasPages())
            <div class="mt-8">
                {{ $yeuCauGiaHan->links() }}
            </div>
        @endif
    </div>
@endsection
